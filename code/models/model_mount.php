<?php
class Model_mount extends Model{
	/*
		get_content - get data of mount_cost or mount_date
	*/

	function get_content($id_task){
		$this->get_data($id_task, 'mount', array('mount_date'));
		if (empty($this->data['content']['mount_date'])){
			$this->data['content'] = '';
			$this->get_data($id_task, 'checkout', array('mount_cost'));
		}
		return $this->data;
	}
}