<?php
	class Controller_delivery extends Controller {

	/*
		Methods:
			_index - get view delivery cost or date of delivery
            _apply - save data to database, level-up status and relocate to main page
	*/

	function __construct(){
        $this->model = new Model_delivery();
        $this->view = new View;
    }
        
    function action_index($id_task){
        $data = $this->model->get_content($id_task);
        $this->view->generate("delivery_view.php", 'task', $data);
    }

    function action_apply($id_task){
        $this->status_up($id_task, 'delivery'); 
        header("Location: /mount/index/$id_task");
    }
}