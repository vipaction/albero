<?php
	class Controller_measure extends Controller {

    /*
        methods:
            _index - get info about measures and client
            _save - save values of measure to database
            _edit - get form of measure with saved values of measure
            _apply - change task status to next values
    */

	function __construct(){
		$this->model = new Model_measure();
	}
    
	function action_index($id_task){
        $this->view = new View('task', 'measure', $this->model->get_content($id_task));
        $this->view->data['title'] = "Замер к заказу №".$id_task;
		$this->view->generate(); 
	}

    function action_edit($id_task){
        $this->view = new View('task', 'measure_edit', $this->model->get_content($id_task));
        $this->view->data['title'] = "Редактирование замера к заказу №".$id_task;
        $this->view->generate();
    }

    function action_save($id_task){
        $this->model->save_measure_data($id_task);
        header("Location: /measure/index/$id_task");
    }

    function action_apply($id_task){
        $this->status_up($id_task, 'measure');
        header("Location: /checkout/index/$id_task");
    }
}   