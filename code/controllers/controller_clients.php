<?php
	class Controller_clients extends Controller {

	/*
	Methods:
		_index - get list of all clients
		_info - get info about choosen client with list of tasks
		_search - get form to search client
		_check - find client from database by phone number and get form to edit client's info
		_save - save data of new or current client to database
	*/

	function __construct(){
		$this->model = new Model_clients;
		$this->view = new View;
	}
    
    function action_index(){	
    	$data = $this->model->get_data();
        $this->view->generate('clients_list_view.php', $data);
    }

    function action_info($id_client){
    	$data = $this->model->get_info($id_client);
    	setcookie('id_client',$id_client, 0, '/');
    	$this->view->generate('client_info_view.php', $data[0], $data[1]);
    }

    function action_search(){
    	$this->view->generate('search_view.php');
    }

    function action_check(){
    	if ($id_client = $this->model->check_phone()){
    		$this->action_info($id_client);
    	} else {
    		$data = $this->model->clients_form();
    		$this->view->generate('client_form_view.php', $data[0], $data[1]);
    	}
    }

    function action_edit($id_client){
    	$data = $this->model->clients_form($id_client);
    	$this->view->generate('client_form_view.php', $data[0], $data[1]);
    }

    function action_save(){
    	if (isset($_POST['cancel'])){
    		header("Location: /main/index/");
    		return;
    	}
    	$id_client = $this->model->save_client();
    	$this->action_info($id_client);
    }
}