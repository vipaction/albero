<?php
class Model_delivery extends Model{
	/*
		get_content - get data of delivery_cost or delivery date
	*/

	function get_content($id_task){
		$this->get_status_date($id_task, 'delivery');
		if (empty($this->data['content']['date'])){
			$this->data['content'] = '';
			$this->get_data('id_task', $id_task, 'checkout', array('delivery_cost'));
		}
		return $this->data;
	}
}