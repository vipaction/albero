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

	function calc_spec($id_task){
		include('data/spec_elem_list.php');	// подключаем файл с описанием моделей дверей
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
}

class Block {
	public $id;			// id блока из таблицы замера
	public $model_name;	// номер модели двери в каталоге
	public $content;	// контейнер с элементами полотна двери
	
	const BLOCK_WIDTH_EXT = 60;		// разница полотна от блока в ширине и высоте
	const BLOCK_HEIGHT_EXT = 40;
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
			'height'=>(self::EXTEND_HEIGHT * 2 + ($this->content->width + self::BLOCK_WIDTH_EXT))), 
			array('mdf_10', 'glue', 'lacquer', 'veneer'));
		$extend->calc_material();
		$this->content->add_elem($extend);
		$jamb = new Elem_single('jamb', array('width'=>(int) (self::JAMB_WIDTH*$jambs), 'height'=>self::JAMB_HEIGHT), array('mdf_10', 'dvp', 'glue', 'lacquer', 'veneer'));
		$jamb->calc_material();
		$this->content->add_elem($jamb);
		$frame = new Elem_single('frame', array(
			'width'=>self::FRAME_WIDTH, 
			'height'=>($this->content->width + self::BLOCK_WIDTH_EXT + (($this->content->height + self::BLOCK_HEIGHT_EXT) * 2))), 
			array('wood', 'mdf_12', 'glue', 'lacquer', 'veneer'));
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
			$this->$key = $value;
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

	function __construct($type, $content, $materials){
		parent::__construct($type, $content);
		$this->materials = array_fill_keys($materials, null);	
	}
	function calc_material(){ // расчет количества используемого материала в зависимости от типа элемента и типа материала
		foreach (array_keys($this->materials) as $name) {
			$value = 0;
			$square = 1000*1000;
			$volume = $square * 1000;
			switch ($name) {
				case 'glass':
					$value = $this->get_width() * $this->get_height() / $square; //переводим в кв.м. 
					break;
				case 'wood':
					switch ($this->type) {
						case 'pillar':
							$value = ($this->get_width() - 20) * $this->get_height() * 34 / $volume; // переводим в куб.м.
							break;
						case 'crossbar':
							$value = $this->get_width() * ($this->get_height() - 20) * 28 / $volume;
							break;
						case 'frame':
							$value = $this->get_width() * $this->get_height() * 34 / $volume;
							break;
					}
					break;
				case 'mdf_12':
					$value = $this->get_height() * 40 / $square;
					break;
				case 'mdf_10':
					switch ($this->type) {
						case 'filling':
						case  'extend':
						case    'jamb':
							$value = $this->get_height() * $this->get_width() / $square;
							break;
						case 'pillar':
							$value = $this->get_height() * 34 * 2 / $square;
							break;
						case 'crossbar':
							$value = $this->get_height() * 28 * 2 / $square;
							break;
						case 'decor':
							$value = $this->get_height() * $this->get_width() * 2 / $square;
							break; 
					}
					break;
				case 'dvp':
					switch ($this->type) {
						case   'pillar':
						case 'crossbar':
							$value = $this->get_height() * $this->get_width() * 2 / $square;
							break;
						case 'jamb':
							$value = $this->get_height() * 30 / $square;
							break;
					}
					break;
				case 'lacquer':
				case  'veneer':
					switch ($this->type) {
						case  'filling':
						case 	'frame':
							$value = $this->get_height() * $this->get_width() * 2 / $square;
							break;
						case 'jamb':
							$value = $this->get_height() * ($this->get_width() + 40) / $square;
							break;
						case 'extend':
							$value = $this->get_height() * ($this->get_width() + 10) / $square;
							break;
						case 'crossbar':
							$value = ($this->get_height() * 2 + 100) * $this->get_width() / $square;
							break;
						case 'pillar':
							$value = $this->get_height() * ($this->get_width() * 2 + 100) / $square;
							break;
						case 'decor':
							$value = $this->get_height() * ($this->get_width() + 20) * 2 / $square;
							break;
					}
					if ($name == 'lacquer')
						$value = $value * 0.2; // расход лака 200гр/кв.м.
					break;
				case 'glue':
					switch ($this->type) {
						case  'filling':
							$value = $this->get_height() * $this->get_width() * 2 / $square;
							break;
						case 'jamb':
							$value = $this->get_height() * ($this->get_width() + 40) / $square;
							break;
						case 'extend':
							$value = $this->get_height() * ($this->get_width() + 10) / $square;
							break;
						case 'frame':
							$value = ($this->get_height() * $this->get_width() * 2 + 40 * 3 * $this->get_height()) / $square;
							break;
						case 'crossbar':
							$value = (($this->get_height() * 2 + 100) * $this->get_width() + ($this->get_height() * 2 + 120) * $this->get_width()) / $square;
							break;
						case 'pillar':
							$value = (($this->get_width() * 2 + 100) * $this->get_height() + ($this->get_width() * 2 + 120) * $this->get_height()) / $square;
							break;
						case 'decor':
							$value = $this->get_height() * ($this->get_width()+20) * 2 / $square;
							break;
					}
					$value = $value * 0.2; // расход клея 200гр/кв.м.
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
					$this->add_elem(new Elem_filling($type, $element, array('glass')));
					break;
				case 'filling':
					$this->add_elem(new Elem_filling($type, $element, array('mdf_10', 'glue', 'lacquer', 'veneer')));
					break;
				case 'pillar':
					$this->add_elem(new Elem_single($type, $element, array('wood', 'mdf_10', 'dvp', 'glue', 'lacquer', 'veneer')));
					break;
				case 'crossbar':
					$this->add_elem(new Elem_single($type, $element, array('wood', 'mdf_10', 'dvp', 'glue', 'lacquer', 'veneer')));
					break;
				default:
					$this->add_elem(new Elem_single($type, $element, array('mdf_10', 'glue', 'lacquer', 'veneer')));
					break;
			}
				
		}
	}
	function add_elem($elem){
		array_push($this->content, $elem);
	}
	private function check_door_elem($type){
		$types = array('crossbar', 'filling', 'glass', 'pillar', 'container');
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
