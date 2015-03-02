<?php
class Model_checkout extends Model{
	/*
		get_content - this function get data from 'checkout' table and output it as text list or as fields list for editing
	*/
	function get_content($id_task){
		$this->data['content'] = $this->get_data('id_task', $id_task, 'checkout', array('total_sum','delivery_cost','mount_cost','prepaid_sum'));
		$this->data['title'] = "Оформление заказа №".$id_task;
		return $this->data;
	}
}