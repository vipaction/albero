<?php
	class Controller_main extends Controller {

	/*
		Methods:
			_index - get list of unclosed tasks
	*/

	function __construct(){
		$this->model = new Model_main;
		$this->view = new View;
	}
    
    function action_index()
    {	
    	$data=$this->model->get_data();
        $this->view->generate('main_view.php', 'main', $data);
    }

    function action_archive(){
    	$data=$this->model->get_data("= '1'");
        $this->view->generate('main_view.php', 'main', $data);
    }
}