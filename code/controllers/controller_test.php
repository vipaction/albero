<?php
	class Controller_test extends Controller {

	/*
	Methods:
		_index - save new task and task status
		_delete - delete all data about current task of current client
	*/
    
	function action_index($id_client){	
		$m = file("data/materials.cfg", FILE_IGNORE_NEW_LINES);
        foreach ($m as $value) {
            $num = explode('=',$value);
            $result[$num[0]] = $this->from_string_to_array($num[1]);
            
        }
        array_walk_recursive($result,function(&$elem){
            $elem = str_replace(array('W','L'), array(100,100), $elem);
            eval('$elem='.$elem.';');
        });
    	print_r($result);
    }

    private function split_material($material){
        $keys=['width','length','depth'];
        if (strpos($material, '[') === FALSE)
            foreach(explode('*',$material) as $key=>$each){
                $result[$keys[$key]] = $each;
            }
        else {
            foreach (explode(',',substr($material,1,-1)) as $num=>$value) {
                foreach(explode('*',$value) as $key=>$each){
                    $result[$num][$keys[$key]] = $each;
                }
            }
        }
        return $result;
    }

    private function from_string_to_array($data_string){ // Парсинг строки модели двери с разбивкой на контейнеры и отдельные элементы
        $data = explode(' ', $data_string);
        foreach ($data as $value) {
            $material = explode('@', $value);
            $res[$material[0]] = $this->split_material($material[1]);
        }
        return $res;
    }
 }