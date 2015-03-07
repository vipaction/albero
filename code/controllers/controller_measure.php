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
        $this->view = new View;
	}
    
	function action_index($id_task){
        $data = $this->model->get_content($id_task);
        $data['title'] = "Замер к заказу №".$id_task;
		$this->view->generate('measure_view.php','task', $data); 
	}

    function action_edit($id_task){
        $data=$this->model->get_content($id_task);
        $data['title'] = "Редактирование замера к заказу №".$id_task;
        $this->view->generate('measure_edit_view.php','task', $data);
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