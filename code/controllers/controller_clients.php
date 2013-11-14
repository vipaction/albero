<?php
	class Controller_clients extends Controller {

	/*
	Methods:
		_index - get list of all clients
		_info - get info about choosen client with list of tasks
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
}