<?php
class Info{
	public $base;
	function __construct(){
		$this->base = new SQLite3('base.db');
	}

	function get_client_info($id_task){
		$client_info = $this->base->querySingle("SELECT * FROM clients INNER JOIN tasks ON tasks.id_client=clients.rowid 
											WHERE tasks.rowid='$id_task'",true);
		$data = array();
		$data['Клиент'] = ucwords($client_info['last_name'].' '.$client_info['first_name'].' '.$client_info['second_name']);
		$data['Телефон'] = $client_info['phone'];
		$data['Адрес'] = $client_info['address'];
		return array('info'=>$data,'id_client'=>$client_info['id_client']);
	}

	function get_status_info($id_task){
		$task_list = $this->base->query("SELECT tsn.name, tsn.value, ts.id_task FROM task_status AS ts
									INNER JOIN task_status_names AS tsn
									ON ts.status = tsn.rowid
									WHERE ts.id_task=$id_task AND tsn.name!='close'");
		while ($statuses[] = $task_list->fetchArray(SQLITE3_ASSOC)) {}
		array_pop($statuses);
		return $statuses;
	}
}

class Model{
	public $base; 
	public $data; /*This variable for output content*/
	
	function __construct(){
		$this->base = new SQLite3('base.db');
	}

	/*
		Get info about task and client
	*/
	function get_header_info($id_task){ 
		$info = new Info;
		$client_info = $info->get_client_info($id_task);
        $this->data = array(
            'header' => array(
                'client_info' => $client_info['info'],
                'id_client' => $client_info['id_client'],
                'status_info' => $info->get_status_info($id_task)),
            'id_task' => $id_task);
    }

	/*
		Return clients and task statuses info and content of table_name for current id_task or empty fields.
	*/
	function get_data($id_task, $table_name, $fields){
		$this->get_header_info($id_task);
		$this->data['content'] = array_fill_keys($fields, null);
		$current_data = $this->base->querySingle("SELECT ".implode(',', $fields)." FROM $table_name WHERE id_task='$id_task'", true);
		foreach ($this->data['content'] as $key => $value) {
			if (isset($current_data[$key])) $this->data['content'][$key] = $current_data[$key];
		}
	}

	/* 
		Save or replace data in table_name 
	*/
	function save_data($id_task, $table_name){ 
		$form_data = $_POST;
		$form_names = implode(",", array_keys($form_data));
		$form_values = implode("','", array_values($form_data));
		$current_id = $this->base->querySingle("SELECT rowid FROM $table_name WHERE id_task='$id_task'");
		if (!empty($_POST)){
			if (!empty($current_id)){
				foreach ($form_data as $key => $value) {
					$form_array[] = "$key='$value'";
				}
				$this->base->exec("UPDATE $table_name SET ".implode(', ', $form_array)." WHERE id_task=$id_task");
			} else $this->base->exec("INSERT INTO $table_name (id_task, $form_names) VALUES ('$id_task', '$form_values')");

		}
	}
}

