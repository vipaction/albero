<?php
	class Controller_measure extends Controller {

	function __construct(){
		$this->model = new Model_measure;
		$this->view = new View;
	}
    
	function action_index($id_task){
		$data=$this->model->measure($id_task);
		$this->view->generate('measure_view.php', 'template_view.php',$data[0], $data[1]); //data is array of task info(0) and client info(1)
	}

    function action_measure_form(){	
    	$data=$this->model->measure_form();
        $this->view->generate('measure_form_view.php', 'template_view.php', $data);
    }

    function action_save_measure(){
    	$id_task = $_COOKIE['id_task'];
    	if (isset($_POST['send'])){
    		$this->model->save_measure_data($id_task);
    	}
    	setcookie('id_form',false, 0, '/');
    	header("Location: /measure/index/$id_task");
    }

    function action_edit_measure_form($id_form){
    	$data=$this->model->measure_form($id_form);
        $this->view->generate('measure_form_view.php', 'template_view.php', $data);
    }

}   