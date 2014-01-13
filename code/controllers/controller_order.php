<?php
	class Controller_order extends Controller {

	/*
		Methods:
			_index - get view to set order number
            _close - save order number and relocate to main page
	*/

	function __construct(){
        $this->model = new Model_order;
        $this->view = new View;
        $this->id_task = $_COOKIE['id_task']; 
    }
        
    function action_index(){
        $data = $this->model->get_order($this->id_task);
        $this->view->generate("order_view.php", $data);
    }

    function action_close(){
        if (!isset($_POST['cancel'])) {
            $this->model->set_order($this->id_task);
            $this->status_up($this->id_task, 'ready');
        }
        header("Location: /main/index/");
    }
}