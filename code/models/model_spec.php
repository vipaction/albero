<?php
class Model_spec extends Model{

	/*
	get_data - вывод всех блоков из таблицы замеров, формирование выбора моделей дверей для расчета спецификации
	calc_spec - расчет и вывод спецификации по заказу для выбранных моделей дверей в отдельном окне (для удобства печати)
	*/

	function get_data($id_task){
		$this->data['title'] = 'Расчет спецификации';
		$this->data['id_task'] = $id_task;
		
		// Подготовка данных о параметрах блока из таблицы замера
		$blocks = $this->base->query("SELECT rowid, block_width, block_height FROM measure_content
									  WHERE id_task='$id_task'");
		while ($block = $blocks->fetchArray(SQLITE3_ASSOC)) {
			$this->data['content'][] = $block;
		}
		return $this->data;
	}

	function calc_spec($id_task){ // Расчет спецификации для выбранных дверей
		foreach (file('data/door_config_list.php', FILE_SKIP_EMPTY_LINES) as $str) { // Данные по моделям дверей из вложенного файла
    		$num = explode('=', $str);
    		if (isset($num[1]))
	    		$doors[(int)$num[0]] = $this->from_string_to_array($num[1]); // В массиве храним данные о составлющих элементах двери
    	}
    	$this->data['title'] = 'Расчет спецификации';
		$this->get_header_info($id_task);

		// Получаем номера выбранных моделей 
		$blocks = $_POST['block'];
		
		// Получаем параметры о габаритах блока и дополнительных элементах (расширитель, наличиники) из таблицы замеров 
		$doors_measure = $this->base->query("SELECT rowid, block_width, block_height, block_add, door_jamb 
											 FROM measure_content WHERE id_task='$id_task'");
		while ($door_value = $doors_measure->fetchArray(SQLITE3_ASSOC)) {
			$content[array_shift($door_value)] = $door_value;
		}

		// Получаем данные о параметрах модели из массива во вложенном файле
		foreach ($blocks as $id => $model) {
			$block = new Block((int) $id, $doors[$model], (int) $model, (int) $content[$id]['block_width'], (int) $content[$id]['block_height'], (int) $content[$id]['block_add'],(float) $content[$id]['door_jamb']);
			
			$this->data['content'][] = $block;
		}
		return $this->data;
	}

	function get_element_keys($elem){ // Парсинг строки элемента с разбивкой на название и параметры
    	$keys = array('width', 'height', 'border_width', 'border_height');
    	$num = explode('@', $elem);
		$new['type'] = $num[0];
		foreach (explode('*',$num[1]) as $key=>$value) {
			$new[$keys[$key]] = $value;
		}
    	return $new;
    }

    function from_string_to_array(&$data_string){ // Парсинг строки модели двери с разбивкой на контейнеры и отдельные элементы
    	for ($i=0; $i < strlen($data_string); $i++) { 
    		if ($data_string[$i] === '['){
    			$begin_string = array_filter((explode('+', strstr($data_string, '[', TRUE))));
    			foreach ($begin_string as $each) {
    				$container[] = $this->get_element_keys($each);
    			}
    			$data_string = substr($data_string, strpos($data_string, '[')+1);
    			$container[] = array('type'=>'container', 'value'=>$this->from_string_to_array($data_string));
    			$i = 0;
    		}
    		if ($data_string[$i] === ']'){
    			$mid_string = array_filter(explode('+',strstr($data_string, ']',TRUE)));
    			foreach ($mid_string as $each) {
    				$container[] = $this->get_element_keys($each);
    			}
    			$data_string = substr(strstr($data_string, ']'), +1);
    			return $container;
    		}
    	}
    	$end_string = array_filter(explode('+', $data_string));
    	foreach ($end_string as $each) {
			$container[] = $this->get_element_keys($each);
		}
    	return $container;
    }
}

class Block {
	public $id;			// id блока из таблицы замера
	public $model_name;	// номер модели двери в каталоге
	public $content;	// контейнер с элементами полотна двери

	const BLOCK_WIDTH_EXT = 80;		// разница полотна от блока в ширине и высоте
	const BLOCK_HEIGHT_EXT = 50;
	const JAMB_WIDTH = 60;			// ширина и высота наличника для шпонирования
	const JAMB_HEIGHT = 2200;
	const EXTEND_HEIGHT = 2100; 	// высота расширителя 
	const FRAME_WIDTH = 80; 		// толщина коробки

	function __construct($id, $model, $model_name, $width, $height, $block_add, $jambs){
		$this->id = $id;
		$this->model_name = $model_name;
		$this->content = new Elem_container('container', $model, true, $width-self::BLOCK_WIDTH_EXT, $height-self::BLOCK_HEIGHT_EXT);
		$this->content->calc_param(); 					// расчет размеров элементов двери
		$this->create_additions($block_add, $jambs);	// добавление наличников, и тп.
	}
	private function create_additions($block_add, $jambs){	// добавляем к блоку коробку, наличники и расширители 
		$extend = new Elem_single('extend', array(
			'width'=>$block_add, 
			'height'=>(self::EXTEND_HEIGHT * 2 + ($this->content->width + self::BLOCK_WIDTH_EXT))));
		$extend->calc_material();
		$this->content->add_elem($extend);
		$jamb = new Elem_single('jamb', array('width'=>(int) (self::JAMB_WIDTH*$jambs), 'height'=>self::JAMB_HEIGHT));
		$jamb->calc_material();
		$this->content->add_elem($jamb);
		$frame = new Elem_single('frame', array(
			'width'=>self::FRAME_WIDTH, 
			'height'=>($this->content->width + self::BLOCK_WIDTH_EXT + (($this->content->height + self::BLOCK_HEIGHT_EXT) * 2))));
		$frame->calc_material();
		$this->content->add_elem($frame);
	}
	function get_param_str(){ 	// возврат размеров блока ()
		return ($this->content->width + self::BLOCK_WIDTH_EXT).'*'.($this->content->height + self::BLOCK_HEIGHT_EXT);
	}
	
}

class Elem {
	public $type;		// тип элемента двери (стойка, стекло и т.д.)
	public $width = 0;
    public $height = 0;

    function __construct($type, $content = array()){
    	$this->type = $type;
    	foreach ($content as $key => $value) {
			$this->$key =(int) $value;
		}
    }
    function get_width(){
    	return $this->width;
    }
    function get_height(){
    	return $this->height;
    }
}

class Elem_single extends Elem{ // класс для элементов наличник, коробка, расширитель, перемычка, стойка, декор
	public $materials;

	function __construct($type, $content){
		parent::__construct($type, $content);
		include('data/constants.php');
		$this->materials = array_fill_keys($project_data['door_elements'][$type]['value'], null);	
	}
	function calc_material(){ // расчет количества используемого материала в зависимости от типа элемента и типа материала
		foreach (array_keys($this->materials) as $name) {
			$value = 0;
			switch ($name) {
				case 'glass':
					$value = $this->get_width() * $this->get_height(); //переводим в кв.м. 
					break;
				case 'wood':
					switch ($this->type) {
						case 'pillar':
							$value = ($this->get_width() - 20) * $this->get_height() * 34; // переводим в куб.м.
							break;
						case 'crossbar':
							$value = $this->get_width() * ($this->get_height() - 20) * 28;
							break;
						case 'frame':
							$value = $this->get_width() * $this->get_height() * 34;
							break;
					}
					break;
				case 'mdf_12':
					$value = $this->get_height() * 40;
					break;
				case 'mdf_10':
				case 'mdf_16':
					switch ($this->type) {
						case 'fill_low':
						case 'fill_high':
						case  'extend':
						case    'jamb':
							$value = $this->get_height() * $this->get_width();
							break;
						case 'pillar':
							$value = $this->get_height() * 34 * 2;
							break;
						case 'crossbar':
							$value = $this->get_height() * 28 * 2;
							break;
						case 'decor':
							$value = $this->get_height() * $this->get_width() * 2;
							break; 
					}
					break;
				case 'dvp':
					switch ($this->type) {
						case   'pillar':
						case 'crossbar':
							$value = $this->get_height() * $this->get_width() * 2;
							break;
						case 'jamb':
							$value = $this->get_height() * 30;
							break;
					}
					break;
				case 'lacquer':
				case  'veneer':
					switch ($this->type) {
						case  'fill_low':
						case 'fill_high':
						case 	'frame':
							$value = $this->get_height() * $this->get_width() * 2;
							break;
						case 'jamb':
							$value = $this->get_height() * ($this->get_width() + 40);
							break;
						case 'extend':
							$value = $this->get_height() * ($this->get_width() + 10);
							break;
						case 'crossbar':
							$value = ($this->get_height() * 2 + 100) * $this->get_width();
							break;
						case 'pillar':
							$value = $this->get_height() * ($this->get_width() * 2 + 100);
							break;
						case 'decor':
							$value = $this->get_height() * ($this->get_width() + 20) * 2;
							break;
					}
					break;
				case 'glue':
					switch ($this->type) {
						case  'fill_low':
						case  'fill_high':
							$value = $this->get_height() * $this->get_width() * 2;
							break;
						case 'jamb':
							$value = $this->get_height() * ($this->get_width() + 40);
							break;
						case 'extend':
							$value = $this->get_height() * ($this->get_width() + 10);
							break;
						case 'frame':
							$value = ($this->get_height() * $this->get_width() * 2 + 40 * 3 * $this->get_height());
							break;
						case 'crossbar':
							$value = (($this->get_height() * 2 + 100) * $this->get_width() + ($this->get_height() * 2 + 120) * $this->get_width());
							break;
						case 'pillar':
							$value = (($this->get_width() * 2 + 100) * $this->get_height() + ($this->get_width() * 2 + 120) * $this->get_height());
							break;
						case 'decor':
							$value = $this->get_height() * ($this->get_width()+20) * 2;
							break;
					}
					break;
			}
			$this->materials[$name] = $value;
		}
	}
}

class Elem_filling extends Elem_single{ // класс для элементов филенка и стакло
	public $border_width = 0;
	public $border_height = 0;

	function get_width(){
		return $this->width+($this->border_width*2); // ширина и высота больше из-за припусков
	}
	function get_height(){
		return $this->height+($this->border_height*2);
	}
}

class Elem_container extends Elem{ // класс для контейнера с элементами
	public $content = array();
	public $direction; // направление расчета и отображения элементов (горизонталь-вертикаль-горизонталь-...)

	function __construct($type, $content, $direction, $width=0, $height=0){
		parent::__construct($type);
		$this->width = $width;
		$this->height = $height;
		$this->direction = $direction;
		$this->create_elements($content); // заполнение контейнера элементами с указанием используемых материалов
	}
	private function create_elements($content){
		foreach ($content as $element) {
			$type = array_shift($element);
			switch ($type) {
				case 'container':
					$this->add_elem(new Elem_container($type, $element['value'], !$this->direction));
					break;
				case 'glass':
					$this->add_elem(new Elem_filling($type, $element));
					break;
				case 'fill_low':
				case 'fill_high':
					$this->add_elem(new Elem_filling($type, $element));
					break;
				case 'pillar':
					$this->add_elem(new Elem_single($type, $element));
					break;
				case 'crossbar':
					$this->add_elem(new Elem_single($type, $element));
					break;
				default:
					$this->add_elem(new Elem_single($type, $element));
					break;
			}
				
		}
	}
	function add_elem($elem){
		array_push($this->content, $elem);
	}
	private function check_door_elem($type){
		$types = array('crossbar', 'fill_low', 'fill_high', 'glass', 'pillar', 'container');
		return in_array($type, $types);
	}
	function calc_param(){
		$count_num = 0; // общее количество элементов в контейнере
		$count_x = 0;	// количество элементов в контейнере без указанной ширины
		$count_y = 0;	// количество элементов в контейнере без указанной высоты
		$width_value = 0;	// сумма всех указанных ширин элементов контейнера
		$height_value = 0;	// сумма всех указанных высот элементов контейнера

		/* Находим "резиновые" элементы у которых не указана высота/ширина, а указанные суммируем */
		foreach ($this->content as $element) { 
			if ($this->check_door_elem($element->type)){
				$count_num++;
				if ($element->width>0) {
					$width_value += $element->width;
				} else {
					++$count_x;
				}
				if ($element->height>0) {
					$height_value += $element->height;
				} else {
					++$count_y;
				}
			}
		}

		/* Назначаем вычисленные параметры высоты и ширины для "резиновых элементов" */
		$flex_width = (($count_num-$count_x)>0 && ($count_x>0)) ? (int) (($this->width-$width_value)/$count_x) : $this->width;
		$flex_height = (($count_num-$count_y)>0 && ($count_y>0)) ? (int) (($this->height-$height_value)/$count_y) : $this->height;
		
		foreach ($this->content as $element) {  
			if ($element->width == 0) {
				$element->width = $flex_width;
			}
			if ($element->height == 0) {
				$element->height = $flex_height;
			} 
			if ($element instanceof Elem_container)	/* Применяем метод ко вложенным контейнерам */
				$element->calc_param();
			else 
				$element->calc_material();	/* Расчет используемого материала для элементов */
		}

	}
}
