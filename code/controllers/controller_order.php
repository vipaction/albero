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
        if (isset($_COOKIE['id_task'])) $this->id_task = $_COOKIE['id_task'];, $id_task
    }
        
    function action_index($id_task){
        setcookie('id_task', $id_task, 0, '/');
        $data = $this->model->get_order($id_task);
        $this->view->generate_task("order_view.php", $id_task, $data);
    }

    function action_close(){
        if (!isset($_POST['cancel'])) {
            $this->model->set_order($this->id_task);
            $this->status_up($this->id_task, 'ready');
        }
        header("Location: /main/index/");
    }
}