<?php
class Model_postage extends Model{
	/*
		get_content - get data of couriers, declaration number and postage costs for editing
	*/

	function get_content($id_task){
		$this->data['content'] = $this->get_data('id_task' ,$id_task, 'postage', array('courier_id', 'declarate_num', 'payment'));
		return $this->data;
	}
}