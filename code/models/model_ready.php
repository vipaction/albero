<?php
class Model_ready extends Model
{
	/*
	Methods:
		get_data - get data of couriers, declaration number and postage costs
	*/

	function get_data($id_task){
		$form_fields = array('declarate_num', 'courier_id', 'payment');
		$data = $this->base->querySingle("SELECT ".implode(', ', $form_fields)." FROM ready WHERE id_task=$id_task", true);
		foreach ($form_fields as $name) {
			$result[$name] = isset($data[$name]) ? $data[$name] : '';
		}
		return($result);
	}

	function set_data($id_task){
		$this->base->exec("DELETE FROM ready WHERE id_task=$id_task");
		$data = array_filter($_POST);
		if (!empty($data)){
			$this->base->exec("INSERT INTO ready (".implode(', ', array_keys($data)).", id_task) 
								VALUES ('".implode("', '", $data)."', $id_task)");
		}
	}
}