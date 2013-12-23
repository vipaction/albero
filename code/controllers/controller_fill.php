<?php
	class Controller_fill extends Controller {

	/*
		Methods:
			
	*/

	function __construct(){
        $this->model = new Model_fill;
        $this->view = new View;
    }
    
    function action_index(){
        $data = $this->model->get_data();
        //$this->view->generate("",$data);
    }
}