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
    function action_choose(){
        $this->view = new View ('spec', 'spec_choose',$this->model->choose_spec_tables());
        $this->view->generate();
    }   
    function action_view(){
        $this->view = new View ('spec', 'spec_table',$this->model->view_spec_table());
        $this->view->generate();
    }
    function action_edit($id_row){
        $this->view = new View ('spec', 'spec_edit',$this->model->edit_table($id_row));
        $this->view->generate();
    }
    function action_save($id_row){
        $this->model->save_row($id_row);
        header("Location: /spec/choose/");
    }
    function action_load($id_task){
        header('Content-Type: application/xml');
        header("Content-Disposition: attachment; filename='spec_{$id_task}.xml'");
        readfile("spec/spec_{$id_task}.xml");
    }
    function action_delete($id_row){
        $this->model->delete_row($id_row);
        header("Location: /spec/choose/");
    }
}