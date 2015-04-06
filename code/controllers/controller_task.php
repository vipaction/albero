<?php
	class Controller_task extends Controller {

	/*
	Methods:
		_index - save new task and task status
		_delete - delete all data about current task of current client
	*/

	function __construct(){
		$this->model = new Model_task;
	}

	function action_index($id_client){	
    	$this->model->open_task($id_client);
    	header("Location: /clients/info/$id_client");
    }

	function action_delete($id_task){
		$id_client = $this->model->delete_task($id_task);
		header("Location: /clients/info/$id_client");
	}
}