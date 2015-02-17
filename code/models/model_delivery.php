<?php
class Model_delivery extends Model{
	/*
		get_content - get data of delivery_cost or delivery_date
	*/

	function get_content($id_task){
		$this->get_data($id_task, 'delivery', array('delivery_date'));
		if (empty($this->data['content']['delivery_date'])){
			$this->data['content'] = '';
			$this->get_data($id_task, 'checkout', array('delivery_cost'));
		}
		return $this->data;
	}
}