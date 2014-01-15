<?php
	class Controller_ready extends Controller {

	/*
		Methods:
			_index - get view to set couriers data
            _close - save data to database, level-up status and relocate to main page
	*/

	function __construct(){
        $this->model = new Model_ready;
        $this->view = new View;
        $this->id_task = $_COOKIE['id_task']; 
    }
        
    function action_index(){
        $data = $this->model->get_data($this->id_task);
        $this->view->generate_task("ready_view.php", $data);
    }

    function action_close(){
        if (!isset($_POST['cancel'])) {
            $this->model->set_data($this->id_task);
            $this->status_up($this->id_task, 'delivery');
        } 
        header("Location: /main/index/");
    }
}