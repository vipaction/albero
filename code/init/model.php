<?php
class Model{
	public $base; 
	public $data; /*This variable for output content*/
	
	function __construct(){
		$this->base = new SQLite3('base.db');
		if (isset($_SESSION['id_auth']))	// Get personal data of session user
			$this->data['auth'] = $_SESSION;
	}	

	function get_client_info($id_client){	// Get client info from DB
		$client_info = $this->base->querySingle("SELECT * FROM clients WHERE rowid=$id_client",true);
		return $client_info;
	}

	function get_status_info($id_task){		// Get info about all statuses of current task
		$task_list = $this->base->query("SELECT tsn.name, tsn.value, ts.id_task FROM task_status AS ts
									INNER JOIN task_status_names AS tsn
									ON ts.status = tsn.rowid
									WHERE ts.id_task=$id_task");
		while ($statuses[] = $task_list->fetchArray(SQLITE3_ASSOC)) {}
		array_pop($statuses);
		return $statuses;
	}

	function get_header_info($id_task){ // Get summary info about client and task's statuses
		$id_client = $this->base->querySingle("SELECT id_client FROM tasks WHERE rowid=$id_task");
		$this->data['header'] = array(
                'client_info' => $this->get_client_info($id_client),
                'id_client' => $id_client,
                'status_info' => $this->get_status_info($id_task));
        $this->data['id_task'] = $id_task;
    }

	/*
		Return clients and task statuses info and content of table_name for current id_task or empty fields.
	*/
	function get_data($field, $field_value, $table_name, $fields_list){
		if ($field == 'id_task') $this->get_header_info($field_value);
		$content = array_fill_keys($fields_list, null);
		$current_data = $this->base->querySingle("SELECT ".implode(',', $fields_list)." FROM $table_name WHERE $field='$field_value'", true);
		foreach ($content as $key => $value) {
			if (isset($current_data[$key])) $content[$key] = $current_data[$key];
		}
		return $content;
	}

	/* 
		Save or replace data in table_name 
	*/
	function save_data($id_task, $table_name, $id_field="id_task"){ 
		$form_data = $_POST;
		$form_names = implode(",", array_keys($form_data));
		$form_values = implode("','", array_values($form_data));
		$current_id = $this->base->querySingle("SELECT rowid FROM $table_name WHERE $id_field='$id_task'");
		if (!empty($_POST)){
			if (!empty($current_id)){
				foreach ($form_data as $key => $value) {
					$form_array[] = "$key='$value'";
				}
				$this->base->exec("UPDATE $table_name SET ".implode(', ', $form_array)." WHERE $id_field=$id_task");
			} else {
				echo "INSERT INTO $table_name ($id_field, $form_names) VALUES ('$id_task', '$form_values')";
				$this->base->exec("INSERT INTO $table_name ($id_field, $form_names) VALUES ('$id_task', '$form_values')");
			}
		}
	}

	/*
		Return date of status changes
	*/
	function get_status_date($id_task, $status){ 
		$this->get_header_info($id_task);
		$prepare_str = "SELECT date FROM task_status AS ts 
						INNER JOIN task_status_names AS tsn ON ts.status=tsn.rowid
						WHERE ts.id_task=$id_task AND tsn.name='$status'";
		$this->data['content'] = $this->base->querySingle($prepare_str ,true);
	}
}

