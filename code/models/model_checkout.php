<?php
class Model_checkout extends Model{
	function __construct($id_task){ /* Get info about task and client*/
		parent::__construct();
		$info = new Info;
        $this->data = array(
            'header' => array(
                'client_info' => $info->get_client_info($id_task),
                'status_info' => $info->get_status_info($id_task)),
            'id_task' => $id_task);
	}
	/*
		get_data - this function get data from 'checkout' table and output it as text list or as fields list for editing
		save_data - insert or update data in 'checkout' table in DB
	*/
	function get_data($id_task){
		$this->data['content'] = array(
			'total_sum' => 0,
			'delivery_cost' => 0,
			'mount_cost' => 0,
			'prepaid_sum' => 0,);
		$checkout_data = $this->base->querySingle("SELECT total_sum, delivery_cost, mount_cost, prepaid_sum FROM checkout WHERE id_task='$id_task'", true);
		foreach ($this->data['content'] as $key => $value) {
			if (isset($checkout_data[$key])) $this->data['content'][$key] = $checkout_data[$key];
		}
		return $this->data;
	}

	function save_data($id_task){
		$checkout_data = $_POST;

		//make string for sql expression
		$checkout_names = implode(",", array_keys($checkout_data));
		$checkout_values = implode("','", array_values($checkout_data));
		$current_id = $this->base->querySingle("SELECT rowid FROM checkout WHERE id_task='$id_task'");
		if (!empty($_POST)){
			if (!empty($current_id)){
				foreach ($checkout_data as $key => $value) {
					$checkout_array[] = "$key='$value'";
				}
				$this->base->exec("UPDATE checkout SET ".implode(', ', $checkout_array)." WHERE id_task=$id_task");
			} else $this->base->exec("INSERT INTO checkout (id_task, $checkout_names) VALUES ('$id_task', '$checkout_values')");

		}
	}
}