<?php
	class Controller_checkout extends Controller {

	/*
		Methods:
			_index - get list of measured doors for checkout
	*/

	function __construct(){
        $this->model = new Model_checkout;
        $this->view = new View;
        $this->id_task = $_COOKIE['id_task'];
    }
    
    function action_index(){	
        $data = $this->model->get_list($this->id_task);
        $this->view->generate_task("checkout_list_view.php", $data);
    }
}