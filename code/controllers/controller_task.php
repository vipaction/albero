<?php
	class Controller_task extends Controller {

	/*
	Methods:
		_index - get form to create task
		_create - save new task and task status
		_info - get info about  client and links to task statuses 
		_check - 
		_delete - delete all data about current task of current client
	*/

	function __construct(){
		$this->model = new Model_task;
		$this->view = new View;
	}

	function action_index()
    {	
    	$data=$this->model->get_data();
        $this->view->generate('main_view.php', $data);
    }
    
    function action_create()
    {	
    	// repeat to input phone number if it empty
    	if ($_POST['client_phone'] == '') {
			header('Location: /task/search');
		}
    	$data=$this->model->get_data(); //$data is array with 2 elements (client's info and hidden field with id_client)
        $this->view->generate('create_task_view.php', $data[0], $data[1]);
    }

    function action_info($id_task)
    {
    	setcookie('id_task',$id_task, 0, '/');
    	$data = $this->model->get_info($id_task);
    	$this->view->generate('task_info_view.php',$data[0], $data[1]);
    }

	function action_check(){
		if ($_POST['task_mode'] == 'main'){
			header("Location: /main/index");
			return;
		}
		$status = $this->model->open_task(); //add new client if it need, create new task and save choosen status of task)
		$this->view->generate('confirmation_view.php', $status);
	}

	function action_delete($id_task){
		$id_client = $_COOKIE['id_client'];
		$this->model->base->exec("DELETE FROM task_status WHERE id_task='$id_task'");
		$this->model->base->exec("DELETE FROM tasks WHERE rowid='$id_task'");
        header("Location: /clients/info/$id_client");
	}
}