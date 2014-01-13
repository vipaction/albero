<?php
	class Controller_checkout extends Controller {

	/*
		Methods:
			_index - get list of measured doors for checkout
	*/

	function __construct(){
        $this->model = new Model_checkout;
        $this->view = new View;
    }
    
    function action_index($id_task){	
        $data = $this->model->get_list($id_task);
        $this->view->generate("checkout_list_view.php", $data);
    }
}