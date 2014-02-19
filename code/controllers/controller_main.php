<?php
	class Controller_main extends Controller {

	/*
		Methods:
			_index - get list of unclosed tasks
	*/

	function __construct(){
		$this->model = new Model_main;
        $this->view = new View;
        setcookie('id_task', false, 0, '/');
	}
    
    function action_index()
    {	
    	$data=$this->model->get_data();
        $this->view->generate('main_view.php', $data);
    }
}