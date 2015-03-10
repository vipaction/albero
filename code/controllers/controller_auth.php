<?php
	class Controller_auth extends Controller {

	/*
	*/

	function __construct(){
		$this->model = new Model_auth;
        $this->view = new View;
	}
    
    function action_index(){	
    	$data = $this->model->auth_session();
        if (isset($_POST['auth']))
            header('Location: /main');
        else
            $this->view->generate('auth_view.php', 'auth', $data);
    }

    function action_close(){
        $this->model->close_auth_session();
        header('Location: /auth');
    }
}