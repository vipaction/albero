<?php
	class Controller_measure extends Controller {

    /*
        methods:
            _index - get info about measures and client
            _form - get form to input values of measure
            _save - save values of measure to database
            _edit - get form of measure with saved values of measure
            _image - save or replace image in database
            _comment - save or replace comment in database
            _delete - delete current row from database
            _close - change task status to next values
    */

	function __construct(){
		$this->model = new Model_measure;
		$this->view = new View;
	}
    
	function action_index($id_task){
        setcookie('id_task', $id_task, 0, '/');
		$data=$this->model->get_data($id_task);
        $this->view->generate('measure_view.php',$data); 
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

    function action_image(){
        $id_task = $_COOKIE['id_task'];
        if (isset($_POST['delete'])) {
            $photo = $this->model->base->querySingle("SELECT photo FROM measure WHERE id_task='$id_task'");
            if (unlink('images/'.$photo)){
                $this->model->base->exec("UPDATE measure SET photo='' WHERE id_task='$id_task'");
            }
        } else {
            $this->model->save_image($id_task);
        }
        header("Location: /measure/index/$id_task");
    }

    function action_comment(){
        $id_task = $_COOKIE['id_task'];
        if (isset($_POST['delete'])) {
            $this->model->base->exec("UPDATE measure SET comment='' WHERE id_task='$id_task'");
        } else {
            $this->model->save_comment($id_task);
        }
        header("Location: /measure/index/$id_task");
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