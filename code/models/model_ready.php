<?php
class Model_ready extends Model{
	/*
		get_content - get date of getting from storage or data of couriers, declaration number and postage costs
	*/

	function get_content($id_task){
		$this->get_status_date($id_task, 'ready');
		if (empty($this->data['content']['date'])){
			$this->data['content'] = $this->get_data('id_task' ,$id_task, 'postage', array('courier_id', 'declarate_num', 'payment'));
		}
		$this->data['title'] = "Получение заказа №".$id_task;
		return $this->data;
	}	
}