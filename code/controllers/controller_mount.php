<?php
	class Controller_mount extends Controller {

	/*
		Methods:
			_index - get view delivery cost or date of delivery
            _apply - save data to database, level-up status and relocate to main page
	*/

	function __construct(){
        $this->model = new Model_mount();
    }
        
    function action_index($id_task){
        $this->view = new View('task', 'mount', $this->model->get_content($id_task));
        $this->view->generate();
    }

    function action_apply($id_task){
        $this->save_status_date($id_task, 'mount');
        $this->model->close_task($id_task); 
        header("Location: /main/index/");
    }
}