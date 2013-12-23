<?php
class Model_checkout extends Model
{
	/*
	Methods:
		get_list - get list of measured doors for checkout
	*/

	function get_list($id_task){
		$doors_list = $this->base->query(
			"SELECT measure_content.rowid, room_type, door_type, section_width, section_height, section_thickness 
			 FROM measure_content
			 INNER JOIN measure ON measure.rowid=measure_content.id_measure
			 WHERE measure.id_task=$id_task");
		while ($one_door = $doors_list->fetchArray(SQLITE3_ASSOC)){
			extract($one_door);
			$section = array_filter(array($section_width, $section_height, $section_thickness));
			$room_type = is_null($room_type) ? '' : $this->room_type[$room_type];
			$door_type = is_null($door_type) ? '' : $this->door_type[$door_type];
			$doors[$rowid] = array(
				'room_type'=>$room_type, 
				'door_type'=>$door_type,
				implode('*',$section));
		}
		return array('list'=>$doors);
	}
}