<?php
	class Controller_checkout extends Controller {

	/*
		Methods:
			_index - get list of measured doors for checkout
	*/

	function __construct($id_task=null){
        $this->model = new Model_checkout;
        $this->view = new View;
        if (isset($_COOKIE['id_task'])) $this->id_task = $_COOKIE['id_task'];
    }
    
    function action_index($id_task){
        setcookie('id_task', $id_task, 0, '/');
        $data = $this->model->get_list($id_task);
        $this->view->generate_task("checkout_list_view.php", $id_task, $data);
    }
}