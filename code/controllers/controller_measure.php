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
    	$data=$this->model->measure_form($id_client);
        $this->view->generate('measure_form_view.php', 'template_view.php', $data);
    }

}   