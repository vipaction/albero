<?php
	class Controller_test extends Controller {

	/*
	Methods:
		_index - save new task and task status
		_delete - delete all data about current task of current client
	*/

	function action_index($id_client){	
		foreach (file('data/door_config_list.php', FILE_SKIP_EMPTY_LINES) as $str) { // Данные по моделям дверей из вложенного файла
    		$num = explode('=', $str);
			if (isset($num[1]))
	    		$doors[(int)$num[0]] = $num[1];//$this->from_string_to_array($num[1]); // В массиве храним данные о составлющих элементах двери
    	}
    	$data_str = 'aaa';
    	echo $data_str.'<hr>';
    	print_r($m);
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