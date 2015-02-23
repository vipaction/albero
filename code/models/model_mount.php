<?php
class Model_mount extends Model{
	/*
		get_content - get data of mount_cost or mount date
	*/

	function get_content($id_task){
		$this->get_status_date($id_task, 'mount');
		if (empty($this->data['content']['date'])){
			$this->data['content'] = $this->get_data('id_task', $id_task, 'checkout', array('mount_cost'));
		}
		return $this->data;
	}

	function close_task($id_task){
		$this->base->exec("UPDATE tasks SET is_closed='1' WHERE rowid=$id_task");
	}
}