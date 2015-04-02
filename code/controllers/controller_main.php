<?php
	class Controller_main extends Controller {

	/*
		Methods:
			_index - get list of unclosed tasks
			_archive - get list of closed tasks
	*/

	function __construct(){
		$this->model = new Model_main;
	}
    
    function action_index(){	
    	$this->view = new View('main', 'main', $this->model->get_data());
    	$this->view->generate();
    }

    function action_archive(){
    	$this->view = new View('main', 'main', $this->model->get_data("= '1'"));// it's value of field is_closed in 'tasks' table in DB for closed tasks
    	$this->view->generate(); 
    }
}