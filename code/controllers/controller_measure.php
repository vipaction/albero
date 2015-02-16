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
            _apply - change task status to next values
    */

	function __construct($id_task){
		$this->model = new Model_measure($id_task);
        $this->view = new View;
	}
    
	function action_index($id_task){
        $data = $this->model->get_data($id_task);
		$this->view->generate('measure_view.php','task', $data); 
	}

    function action_form(){	
    	$data=$this->model->measure_form();
        $this->view->generate_task('measure_form_view.php', $this->id_task, $data);
    }

    function action_save(){
    	if (isset($_POST['send'])){
    		$this->model->save_measure_data($this->id_task);
    	}
    	setcookie('id_form',false, 0, '/');
    	header("Location: /measure/index/{$this->id_task}");
    }

    function action_edit($id_form){
        setcookie('id_form',$id_form, 0, '/');
    	$data=$this->model->measure_form($id_form);
        $this->view->generate_task('measure_form_view.php', $this->id_task, $data);
    }

    function action_image(){
        if (isset($_POST['delete'])) {
            $photo = $this->model->base->querySingle("SELECT photo FROM measure WHERE id_task='{$this->id_task}'");
            if (unlink('images/'.$photo)){
                $this->model->base->exec("UPDATE measure SET photo='' WHERE id_task='{$this->id_task}'");
            }
        } else {
            $this->model->save_image($this->id_task);
        }
        header("Location: /measure/index/$id_task");
    }

    function action_comment(){
        if (isset($_POST['delete'])) {
            $this->model->base->exec("UPDATE measure SET comment='' WHERE id_task='$this->id_task'");
        } else {
            $this->model->save_comment($this->id_task);
        }
        header("Location: /measure/index/{$this->id_task}");
    }

    function action_delete($id_form){
        $this->model->base->exec("DELETE FROM measure_content WHERE rowid=$id_form");
        header("Location: /measure/index/{$this->id_task}");
    }

    function action_apply(){
        $this->status_up($this->id_task, 'checkout');
        header("Location: /main/index/");
    }
}   