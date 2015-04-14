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
		$blocks = $this->base->query("SELECT rowid, block_width, block_height, room_type, block_add, door_jamb FROM measure_content
									  WHERE id_task='$id_task'");
		while ($block = $blocks->fetchArray(SQLITE3_ASSOC)) {
			$this->data['content'][] = $block;
		}
		return $this->data;
	}

	function calc_spec($id_task){ // Расчет спецификации для выбранных дверей
		foreach (file('data/door_config_list.cfg', FILE_SKIP_EMPTY_LINES) as $str) { // Данные по моделям дверей из вложенного файла
    		$num = explode('=', $str);
    		if (isset($num[1]))
	    		$doors_param[(int)$num[0]] = $this->from_string_to_array($num[1]); // В массиве храним данные о составлющих элементах двери
    	}
    	$this->data['title'] = 'Расчет спецификации';
		$this->get_header_info($id_task);

		// Получаем номера выбранных моделей 
		$blocks = $_POST['block'];
		
		// Получаем параметры о габаритах блока и дополнительных элементах (расширитель, наличиники) из таблицы замеров 
		$doors_measure = $this->base->query("SELECT rowid, block_width, block_height, block_add, door_jamb, door_openning 
											 FROM measure_content WHERE id_task='$id_task'");
		while ($door_value = $doors_measure->fetchArray(SQLITE3_ASSOC)) {
			$id_door = array_shift($door_value);
			$content[$id_door] = $door_value;
		}

		// Получаем данные о параметрах модели из массива во вложенном файле, используя данные POST
		foreach ($blocks as $id => $model) {
			$block = new Block(
				(int) $id, 							// id двери из POST
				$doors_param[$model],				// содержимое модели двери по id из данных парсинга
				(int) $model, 						// номер модели в каталоге
				($content[$id]['door_openning'] === '' ? null : (int) $content[$id]['door_openning']), // открывание
				(int) $content[$id]['block_width'],	// ширина блока двери из замера
				(int) $content[$id]['block_height'],// высота блока двери из замера
				80,									// разница в ширине блока и полотна
				50);								// разница в высоте блока и полотна
			if ($content[$id]['block_add'] != ''){
				// добавляем расширитель, если указана ширина в замере - 2 стойки и 1 перемычка
				$block->add_elem(new Elem_single('extend', array('width'=>$content[$id]['block_add'], 'height'=>$content[$id]['block_height']+50)));
				$block->add_elem(new Elem_single('extend', array('width'=>$content[$id]['block_add'], 'height'=>$content[$id]['block_height']+50)));
				$block->add_elem(new Elem_single('extend', array('width'=>$content[$id]['block_add'], 'height'=>$content[$id]['block_width']+50)));
			}
			// добавляем коробку - 2 стойки и 1 перемычка
			$block->add_elem(new Elem_single('frame', array('width'=>80, 'height'=>$content[$id]['block_height'])));
			$block->add_elem(new Elem_single('frame', array('width'=>80, 'height'=>$content[$id]['block_height'])));
			$block->add_elem(new Elem_single('frame', array('width'=>80, 'height'=>$content[$id]['block_width'])));

			// добавляем наличники
			if (strcspn($content[$id]['door_jamb'], ',.') != strlen($content[$id]['door_jamb'])){
				// если не целое количество, добавляем половинку наличника
				$block->add_elem(new Elem_single('jamb', array('width'=>60, 'height'=>($content[$id]['block_width']<1100 ? 1100 : ($content[$id]['block_width']+50)))));
			}
			// и затем целое количество наличников
			for($i=intval($content[$id]['door_jamb']); $i>0; $i--) {
				$block->add_elem(new Elem_single('jamb', array('width'=>60, 'height'=>($content[$id]['block_height']<2100 ? 2200 : ($content[$id]['block_height']+120)))));
			}
			$this->data['content'][] = $block;
		}
		return $this->data;
	}

	private function get_element_keys($elem){ // Парсинг строки элемента с разбивкой на название и параметры
    	$keys = array('width', 'height', 'border_width', 'border_height');
    	$num = explode('@', $elem);
		$new['type'] = $num[0];
		foreach (explode('*',$num[1]) as $key=>$value) {
			$new[$keys[$key]] = $value;
		}
    	return $new;
    }

    private function from_string_to_array(&$data_string){ // Парсинг строки модели двери с разбивкой на контейнеры и отдельные элементы
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
	public $openning;
	public $content;	// контейнер с элементами полотна двери
	public $additions = array();	// дополнительные элементы блока: коробка, наличник, расширитель

	protected $block_width_ext;		// разница полотна от блока в ширине и высоте
	protected $block_height_ext;

	function __construct($id, $model, $model_name, $openning, $width, $height, $width_ext, $height_ext){
		$this->id = $id;
		$this->model_name = $model_name;
		$this->openning = $openning;
		$this->block_width_ext = $width_ext;
		$this->block_height_ext = $height_ext;
		$this->content = new Elem_container('container', $model, true, $width-$this->block_width_ext, $height-$this->block_height_ext);
		$this->content->calc_param(); 					// расчет размеров элементов двери
	}
	function add_elem(Elem_single $elem){
		$elem->set_current_param();
		array_push($this->additions, $elem);
	}
	
	function get_size(){ 	// возврат размеров блока ()
		return array($this->content->width, $this->content->height);
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
    	return $this->width > $this->height ? $this->height : $this->width;
    }
    function get_length(){
    	return $this->width > $this->height ? $this->width : $this->height;
    }
}

class Elem_single extends Elem{ // класс для элементов наличник, коробка, расширитель, перемычка, стойка, декор
	public $materials;

	function __construct($type, $content){
		parent::__construct($type, $content);
		$data = file("data/materials.cfg", FILE_IGNORE_NEW_LINES);	// заполняем маасив с используемыми материалами
        foreach ($data as $value) {									// в соотвествии с конфигурацией элемента
            $num = explode('=',$value);
            $result[$num[0]] = $this->get_materials_from_str($num[1]);	// парсинг строки конфигурации
            
        }
        $this->materials = $result[$this->type];	
	}

	private function split_material($material){	// разбивка строки на название и параметры материала
        $keys=array('width','length','depth');
        if (strpos($material, '[') === FALSE)
            foreach(explode('*',$material) as $key=>$each){
                $result[$keys[$key]] = $each;
            }
        else {	// при использовании 
            foreach (explode(',',substr($material,1,-1)) as $num=>$value) {
                foreach(explode('*',$value) as $key=>$each){
                    $result[$num][$keys[$key]] = $each;
                }
            }
        }
        return $result;
    }

    private function get_materials_from_str($data_string){ // Парсинг строки элемента двери с разбивкой на материалы
        $data = explode(' ', $data_string);
        foreach ($data as $value) {
            $material = explode('@', $value);
            $result[$material[0]] = $this->split_material($material[1]);
        }
        return $result;
    }

    function set_current_param(){
    	array_walk_recursive($this->materials,function(&$elem, $key, $param){
            $elem = str_replace(array('W','L'), $param, $elem);
            eval('$elem='.$elem.';');
        }, array($this->get_width(),$this->get_length()));
    }

    function get_materials(){
    	$list = array();
    	foreach ($this->materials as $key => $value) {
    		if (isset($value['length'])){
    			$value['value'] = array_product(array_map(function($arg){return $arg/1000;}, $value));
	    		$value['type'] = $key;
    			$list[] = $value;
	    	} else {
	    		foreach ($value as $each) {
	    			$each['value'] = array_product(array_map(function($arg){return $arg/1000;}, $each));
		    		$each['type'] = $key;
	    			$list[] = $each;
	    		}
	    	}
    	}
    	return $list;
    }
}

class Elem_filling extends Elem_single{ // класс для элементов заполнения
	public $border_width = 0;
	public $border_height = 0;

	function get_width(){
    	return $this->width > $this->height ? $this->height+($this->border_height*2) : $this->width+($this->border_width*2);
    }
    function get_length(){
    	return $this->width > $this->height ? $this->width+($this->border_width*2) : $this->height+($this->border_height*2);
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
				case 'glass_trpl':
				case 'fill_low':
				case 'fill_high':
					$this->add_elem(new Elem_filling($type, $element));
					break;
				case 'decor':
					$this->add_elem(new Elem_single($type, $element));
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
		return $type !=='decor';
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
				$element->set_current_param();	/* Расчет используемого материала для элементов */
		}

	}

	function get_list(){
		$list = array();
		foreach ($this->content as $elem) {
			if ($elem instanceof Elem_container){
				$result = $elem->get_list();
				foreach ($result as $each) {
					$list[] = $each;
				}
			} else {
				$list[] = $elem;
			}
		}
		return $list;
	}
}
