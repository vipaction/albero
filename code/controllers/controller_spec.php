<?php
	class Controller_spec extends Controller {

	/*
	*/

	function __construct(){
		$this->model = new Model_spec;
	}
    
    function action_index($id_task){	
        $this->view = new View ('spec', 'spec',$this->model->get_data($id_task));
    	$this->view->generate();
    }

    function action_calc($id_task){
        $this->view = new View ('spec', 'spec_result',$this->model->calc_spec($id_task));
        $this->view->generate();
    }    
}