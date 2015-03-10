<?php
	class Controller_admin extends Controller {

	/*
	*/

	function __construct(){
		$this->model = new Model_admin;
        $this->view = new View;
	}
    
    function action_index(){	
    	$data = $this->model->get_list();
        $this->view->generate('admin_view.php', 'admin', $data);
    }

    function action_edit($id_user){
        $data = $this->model->get_user_info($id_user);
        $this->view->generate('user_data_view.php', 'admin', $data);
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