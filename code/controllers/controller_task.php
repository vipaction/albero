<?php
	class Controller_task extends Controller {

	/*
	Methods:
		_index - save new task and task status
		_info - get info about  client and links to task statuses
		_delete - delete all data about current task of current client
	*/

	function __construct(){
		$this->model = new Model_task;
        $this->view = new View;
	}

	function action_index()
    {	
    	$task_mode = $_POST['mode'];
    	$this->model->open_task($task_mode);
    	header("Location: /main");
    }
    

    function action_info($id_task)
    {
    	$data = $this->model->get_info($id_task);
    	$this->view->generate('task_info_view.php',$data[0], $data[1]);
    }

	function action_delete($id_task){
		$this->model->base->exec("DELETE FROM task_status WHERE id_task='$id_task'");
		$this->model->base->exec("DELETE FROM tasks WHERE rowid='$id_task'");
        header("Location: /clients/info/$id_client");
	}
}