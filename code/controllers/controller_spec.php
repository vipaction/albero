<?php
	class Controller_spec extends Controller {

	/*
	*/

	function __construct(){
		$this->model = new Model_spec;
        $this->view = new View;
	}
    
    function action_index($id_task){	
        $data = $this->model->get_data($id_task);
    	$this->view->generate("spec_view.php", "spec", $data);
    }

    function action_calc($id_task){
        $data = $this->model->calc_spec($id_task);
        $this->view->generate_spec($data);
    }    
}