<?php
	class Controller_clients extends Controller {

	/*
	Methods:
		_index - get list of all clients
		_info - get info about choosen client with list of tasks
		_search - get form to search client
		_check - find client from database by phone number and get form to edit client's info
		_save - save data of new or current client to database
		_delete - delete clients and all client's tasks
	*/

	function __construct(){
		$this->model = new Model_clients;
	}
    
    function action_index(){	
    	$this->view = new View('clients', 'clients_list', $this->model->get_data());
        $this->view->generate();
    }

    function action_info($id_client){
        if (!empty($id_client))
            $data = $this->model->get_info($id_client);
        else
            $data['title'] = 'Данные нового клиента';
    	$this->view = new View('client', 'client_info', $data);
        $this->view->generate();
    }

    function action_save($id_client){
        $id = $this->model->save_client($id_client); 
        if (is_null($id))
            header("Location: /clients");
        else
            header("Location: /clients/info/$id");
    }

    function action_delete($id_client){
    	$this->model->delete_client($id_client);
		header("Location: /clients");
    }
}