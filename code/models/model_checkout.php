<?php
class Model_checkout extends Model
{
	/*
	Methods:
		get_list - get list of measured doors for checkout
	*/

	function get_list($id_task){
		$doors_list = $this->base->query(
			"SELECT room_type, door_type, section_width, section_height, section_thickness, block_add
			 FROM measure_content
			 INNER JOIN measure ON measure.rowid=measure_content.id_measure
			 WHERE measure.id_task=$id_task");
		while ($one_door = $doors_list->fetchArray(SQLITE3_ASSOC)){
			extract($one_door);
			$section = array_filter(array($section_width, $section_height, $section_thickness));
			$doors[] = array(
				'room_type'=>$room_type, 
				'door_type'=>$door_type,
				'section'=>implode('*',$section));
			// change it when will refactoring code
			
		}
		return array('list'=>$doors);
	}
}