<?php
	class Controller_checkout extends Controller {

	/*
		Methods:
			_index - get list of measured doors for checkout
            _apply - save data in DB and change status to 'ready'
	*/

	function __construct($id_task){
        $this->model = new Model_checkout($id_task);
        $this->view = new View;
    }
    
    function action_index($id_task){
        $data = $this->model->get_data($id_task);
        $this->view->generate("checkout_view.php", 'task', $data);
    }

    function action_apply($id_task){
        $this->model->save_data($id_task);
        $this->status_up($id_task, 'ready');
        header("Location: /main/index/");
    }
}