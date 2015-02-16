<?php
	class Controller_ready extends Controller {

	/*
		Methods:
			_index - get view to set couriers data
            _apply - save data to database, level-up status and relocate to main page
	*/

	function __construct($id_task){
        $this->model = new Model_ready($id_task);
        $this->view = new View;
    }
        
    function action_index($id_task){
        $data = $this->model->get_content($id_task);
        $this->view->generate("ready_view.php", 'task', $data);
    }

    function action_apply($id_task){
        $this->model->save_data($id_task, 'ready');
        $this->status_up($id_task, 'delivery'); 
        header("Location: /main/index/");
    }
}