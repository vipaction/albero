<?php
class Block_view{
	public $elem;	// Объект описывающий полотно двери (содержимое, параметры, расчет материала)
	public $project_data; // Данные о названиях и параметры дверей из вложения

	function __construct($elem){
		include('data/constants.php');
		$this->project_data = $project_data;
		$this->elem = $elem; 
	}

	function get_model_name(){	// Возвращает название и номер медели двери согласно каталогу
		foreach ($this->project_data['door_models'] as $name => $models) {
			if (in_array($this->elem->model_name, $models))
				return $name.'('.$this->elem->model_name.')';
		}
	}

	// вывод сгенерированного изображения модели двери
	function get_model_image(){
		return $this->get_elements_view($this->elem->content);
	}

	// вывод размеров блока в виде строки Х*Y
	function get_size_str(){
		return implode('*', $this->elem->get_size()).'('.$this->project_data['door_openning'][$this->elem->openning].')';
	}

	// сбор данных о всех элементах блока
	function get_total_elem_list(){
		return array_merge($this->get_main_elem_list(), $this->get_other_elem_list());
	}
	// генерация списка данных об элементах двери
	function get_elem_list($name){
		$method = "get_{$name}_elem_list";
		$list = $this->{$method}();
		$list_array = array();
		foreach ($list as $elem) {
			$list_array[] = array(
				'type'=>$elem->type,
				'length'=>$elem->get_length(),
				'width'=>$elem->get_width(),
				'materials'=>$this->get_count_array($elem->get_materials()),
			);
		}
		$result = $this->get_count_array($list_array);
		return $result;
	}
	
	// группировка одинаковых элементов массива
	private function get_count_array($array_list){
		$uniq_list = array();
		foreach ($array_list as $value) {
			if (!in_array($value, $uniq_list))
				$uniq_list[] = $value;
				
		}
		foreach ($uniq_list as $key=>$value) {
			$count = array_keys($array_list, $value); // заносим значение количества одинаковых элементов
			$uniq_list[$key]['count'] = count($count);
		}
		usort($uniq_list, function ($a, $b){ // сортировка по типу-длине-ширине
			if ($a['type'] === $b['type']) {
				if ($a['length'] === $b['length']){
					if ($a['width'] === $b['width'])
						return 0;
					elseif ($a['width'] > $b['width'])
						return -1;
					else return 1;
				} elseif ($a['length'] > $b['length'])
					return -1;
				else return 1;
			} elseif ($a['type'] > $b['type'])
				return 1;
			else return -1;
		});
		return $uniq_list;
	}

	// генерация изображения модели двери по элементам контейнера и вложениям.
	private function get_elements_view($container){
		$str = "";
		if ($container instanceof Elem_container){
			$direction = $container->direction ? "row" : "column"; // выбор направления размещения элементов
			$str.= "<div class='".$container->type."_spec' style='width: ".($container->width/5)."px; height: ".($container->height/5)."px; flex-direction: $direction'>\n";
			foreach ($container->content as $content) {
				$str .= $this->get_elements_view($content)."\n";	//рекурсивная проверка вложенных контейнеров
			}
			$str.= "</div>";
		} elseif ($container->type !== 'decor'){	// отображаются только основные элементы двери
			// для каждого элемента указан класс стиля css, для визуального отображения
			$str .= "<div class='".$container->type."_spec' style='width: ".($container->width/5)."px; height: ".($container->height/5)."px;'></div>\n";
		}
		return $str;
	}

	private function get_main_elem_list(){
		return $this->elem->content->get_list();
	}

	// вывод сгенерированной информации о дополнительных элементах двери
	private function get_other_elem_list(){
		return $this->elem->additions;

	}
}
