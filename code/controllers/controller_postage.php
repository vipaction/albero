<?php
	class Controller_postage extends Controller {

	/*
		Methods:
			_index - get view to set couriers data
            _apply - save data to database, level-up status and relocate to main page
	*/

	function __construct(){
        $this->model = new Model_postage();
        $this->view = new View;
    }
        
    function action_index($id_task){
        $data = $this->model->get_content($id_task);
        $this->view->generate("postage_view.php", 'task', $data);
    }

    function action_apply($id_task){
        $this->model->save_data($id_task, 'postage');
        $this->status_up($id_task, 'postage'); 
        header("Location: /ready/index/$id_task");
    }
}