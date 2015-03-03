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
        $this->view = new View;
	}
    
    function action_index(){	
    	$data = $this->model->get_data();
        $this->view->generate('clients_list_view.php', 'clients', $data);
    }

    function action_info($id_client){
        if (!empty($id_client))
            $data = $this->model->get_info($id_client);
        else
            $data['title'] = 'Данные нового клиента';
    	$this->view->generate('client_info_view.php', 'client', $data);
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