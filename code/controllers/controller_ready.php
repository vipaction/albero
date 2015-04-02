<?php
	class Controller_ready extends Controller {

	/*
		Methods:
			_index - get view to set couriers data
            _apply - save data to database, level-up status and relocate to main page
	*/

	function __construct(){
        $this->model = new Model_ready();
    }
        
    function action_index($id_task){
        $this->view = new View('task', 'ready', $this->model->get_content($id_task));
        $this->view->generate();
    }

    function action_apply($id_task){
        $this->status_up($id_task, 'ready'); 
        header("Location: /delivery/index/$id_task");
    }
}