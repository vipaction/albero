<?php
class Model_order extends Model
{
	/*
	Methods:
		get_order - get order's number from table if it exists	
		set_order - save or update order's number to database 
	*/

	function get_order($id_task){
		$order_num = $this->base->querySingle("SELECT order_num FROM order_check WHERE id_task=$id_task");
		$inner_id = 123;
		return(array('order_num'=>$order_num, 'inner_id'=>$inner_id);
	}

	function set_order($id_task){
		$this->base->exec("DELETE FROM order_check WHERE id_task=$id_task");
		if (isset($_POST['order_num'])){
			$this->base->exec("INSERT INTO order_check (order_num, id_task) VALUES ('{$_POST['order_num']}', $id_task)");
		}
	}
	
}