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
	// проверка типа элемента (перечислены те, что в основе двери, остальные - дополнения)
	private function check_elem_in_model($type){
		return in_array($type, array('pillar', 'crossbar', 'filling', 'glass'));
	}
	// вывод сгенерированного изображения модели двери
	function get_model_image(){
		return $this->get_elements_view($this->elem->content);
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
		} elseif ($this->check_elem_in_model($container->type)){	// отображаются только основные элементы двери
			// для каждого элемента указан класс стиля css, для визуального отображения
			$str .= "<div class='".$container->type."_spec' style='width: ".($container->width/5)."px; height: ".($container->height/5)."px;'></div>\n";
		}
		return $str;
	}

	// вывод сгенерированной таблицы с данными основных элементов двери
	function get_spec_table(){ 
		return $this->get_elem_data($this->elem->content);
	}

	// генерация вывода данных о размерах элементов двери
	private function get_elem_data($elem, $padd = 0){
		$str= "";
		if ($elem instanceof Elem_container){
			foreach ($elem->content as $element) {
				$str .= $this->get_elem_data($element, $padd+10);	// рекурсивная иттерация
			}
		} elseif ($this->check_elem_in_model($elem->type)){
			$str .= "<tr><th style='padding-left: {$padd}px; background-color: #eee;'>".$this->project_data['door_elements'][$elem->type]."</th><td>".$elem->get_width()."</td><td>".$elem->get_height()."</td></tr>";
		}
		return $str;
	}

	// генерация вывода данных о используемых материалов суммарно для всех элементов двери
	function get_materials_data(){
		$str = "";
		$sum = 0;	// общая стоимость материалов
		foreach ($this->project_data['materials_array'] as $name => $value) {
			$str .= "<tr><th>".$value['type']."</th><td>";
			$str .= round($this->get_material_value($this->elem->content, $name), 2).' '.$value['tag']; // количество используемого материала
			$str .= "</td><td>";
			$price = round($this->get_material_value($this->elem->content, $name)*$value['price'], 2);	// суммарная стоимость материала
			$str .= $price." грн.</td></tr>";
			$sum += $price;
		}
		$str .= "<tr><th colspan='2'>ИТОГО:</th><th><b>".$sum." грн.</b></th></th>"; // общая стоимость материалов
		return $str;
	}

	// сбор количества материала элементов по всем контейнерам 
	private function get_material_value($elem, $name){
		$val = 0;
		if ($elem instanceof Elem_container){
			foreach ($elem->content as $element) {
				$val += $this->get_material_value($element, $name);
			}
		} else {
			if (isset($elem->materials[$name]))
					$val += $elem->materials[$name];
		}
		return $val;
	}

	// вывод сгенерированной информации о дополнительных элементах двери
	function get_addition(){
		return $this->get_addition_list($this->elem->content);
	}

	// генерация вывода информации о дополнительных элементах
	private function get_addition_list($elem){
		$str = "";
		if ($elem instanceof Elem_container){
			foreach ($elem->content as $element){
				$str .= $this->get_addition_list($element);
			}
		} elseif (!$this->check_elem_in_model($elem->type)) { // выбор неосновных, а дополнительных элементов
			if (($elem->type == 'extend') || ($elem->type == 'frame'))
				$str_type = $elem->get_width().' мм.';
			elseif ($elem->type == 'decor')
				$str_type = $elem->get_width().'*'.$elem->get_height().' мм';
			else
				$str_type = '';
			$str .= "<tr><td colspan='3'>".$this->project_data['door_elements'][$elem->type].', '.$str_type."</td></tr>";
		}
		return $str;
	}
}
