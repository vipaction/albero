<?php
	class Controller_admin extends Controller {

	/*
	*/

	function __construct(){
		$this->model = new Model_admin;
	}
    
    function action_index(){	
    	$this->view = new View('admin', 'admin', $this->model->get_list());
        $this->view->generate();
    }

    function action_edit($id_user){
        $this->view = new View('admin', 'user_data', $this->model->get_user_info($id_user));
        $this->view->generate();
    }

    function action_save($id_user){
        $id_user = $this->model->save_user($id_user);
        header("Location: /admin/index");
    }

    function action_delete($id_user){
        $this->model->remove_user($id_user);
        header("Location: /admin/index");
    }
}