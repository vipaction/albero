<?php
	class Controller_checkout extends Controller {

	/*
		Methods:
			_index - get data about costs and payment for checkout
            _apply - save data in DB and change status to 'postage'
	*/

	function __construct(){
        $this->model = new Model_checkout();
        $this->view = new View;
    }
    
    function action_index($id_task){
        $data = $this->model->get_content($id_task);
        $this->view->generate("checkout_view.php", 'task', $data);
    }

    function action_apply($id_task){
        $this->model->save_data($id_task, 'checkout');
        $this->status_up($id_task, 'checkout');
        header("Location: /postage/index/$id_task");
    }
}