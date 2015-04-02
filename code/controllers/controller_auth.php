<?php
	class Controller_auth extends Controller {

	function __construct(){
		$this->model = new Model_auth;
	}
    
    function action_index(){
        $this->view = new View('auth', 'auth', $this->model->auth_session());
    	if (isset($_POST['auth']))
            header('Location: /main');
        else
            $this->view->generate();
    }

    function action_close(){
        $this->model->close_auth_session();
        header('Location: /auth');
    }
}