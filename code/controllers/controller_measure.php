<?php
	class Controller_measure extends Controller {

    /*
        methods:
            _index - get info about measures and client
            _form - get form to input values of measure
            _save - save values of measure to database
            _edit - get form of measure with saved values of measure
            _delete - delete current row from database
            _close - change task status to next values
    */

	function __construct(){
		$this->model = new Model_measure;
		$this->view = new View;
	}
    
	function action_index($id_task){
		$data=$this->model->measure($id_task);
		$this->view->generate('measure_view.php',$data[0], $data[1]); //data is array of task info(0) and client info(1)
	}

    function action_form(){	
    	$data=$this->model->measure_form();
        $this->view->generate('measure_form_view.php', $data);
    }

    function action_save(){
    	$id_task = $_COOKIE['id_task'];
    	if (isset($_POST['send'])){
    		$this->model->save_measure_data($id_task);
    	}
    	setcookie('id_form',false, 0, '/');
    	header("Location: /measure/index/$id_task");
    }

    function action_edit($id_form){
    	$data=$this->model->measure_form($id_form);
        $this->view->generate('measure_form_view.php', $data);
    }

    function action_delete($id_form){
        $id_task = $_COOKIE['id_task'];
        $this->model->base->exec("DELETE FROM measure_content WHERE rowid=$id_form");
        header("Location: /measure/index/$id_task");
    }

    function action_close(){
        $id_task = $_COOKIE['id_task'];
        $this->model->base->exec("INSERT INTO task_status (id_task, status) 
                                VALUES ($id_task, (SELECT rowid FROM task_status_names WHERE name='close'))");
        header("Location: /main/index/");
    }
}   