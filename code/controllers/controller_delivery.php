<?php
	class Controller_delivery extends Controller {

	/*
		Methods:
			_index - get view delivery cost or date of delivery
            _apply - save data to database, level-up status and relocate to main page
	*/

	function __construct(){
        $this->model = new Model_delivery();
    }
        
    function action_index($id_task){
        $this->view = new View('task', 'delivery', $this->model->get_content($id_task));
        $this->view->generate();
    }

    function action_apply($id_task){
        $this->status_up($id_task, 'delivery'); 
        header("Location: /mount/index/$id_task");
    }
}