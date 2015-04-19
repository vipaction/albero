<?php
	class Controller_admin extends Controller {

	/*
	*/

	function __construct(){
		$this->model = new Model_admin;
	}
    
    function action_index(){	
    	$this->view = new View('admin', 'admin', $this->model->get_users_list());
        $this->view->generate();
    }
    function action_choose(){
        $this->view = new View('admin', 'admin_choose', $this->model->get_tables());
        $this->view->generate();
    }
    function action_table(){
        $this->view = new View('admin', 'admin_table', $this->model->view_table());
        $this->view->generate();
    }
    function action_edit($id_row){
        $this->view = new View ('admin', 'admin_edit',$this->model->edit_table($id_row));
        $this->view->generate();
    }
    function action_save($id_row){
        $this->model->save_row($id_row);
        header("Location: /admin/choose/");
    }
    function action_delete($id_row){
        $this->model->delete_row($id_row);
        header("Location: /admin/choose/");
    }
    function action_edit_user($id_user){
        $this->view = new View('admin', 'user_data', $this->model->get_user_info($id_user));
        $this->view->generate();
    }
    function action_save_user($id_user){
        $id_user = $this->model->save_user($id_user);
        header("Location: /admin/index");
    }
    function action_delete_user($id_user){
        $this->model->remove_user($id_user);
        header("Location: /admin/index");
    }
}