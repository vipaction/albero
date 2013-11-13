<?php
class Model_task extends Model
{
	public function open_task(){
		extract($_POST);	//get all data as variables;
		if (empty($rowid)){
			// add new client to base
			$this->base->exec("INSERT INTO clients (last_name, first_name, second_name, phone, address) 
							VALUES ('$last_name','$first_name','$second_name','$phone','$address')");
			$id_client = $this->base->lastInsertRowID();
		} else {
			// client exist
			$id_client = $rowid;
		}

		// create task and save status to base
		$this->base->exec("INSERT INTO tasks (id_client) VALUES ('$id_client')");
		$id_task = $this->base->lastInsertRowID();
		$this->base->exec("INSERT INTO task_status (id_task, date, status, responsible_staff) 
							VALUES ($id_task, 10, (SELECT rowid FROM task_status_names WHERE name='$task_mode'), 1)");

		// get status russian name
		$task_mode_value = $this->base->querySingle("SELECT value FROM task_status_names WHERE name='$task_mode'");
		return $task_mode_value;
	}


	public function get_data() //Get data for form to create task.
	{
		$client_phone = $_POST['client_phone'];
		$form = new Form;
		$fields = array(
			'last_name'=>'Фамилия',
			'first_name'=>'Имя',
			'second_name'=>'Отчество',
			'address'=>'Адрес',
			'phone'=>'Телефон');
		$client_data = $this->base->querySingle("SELECT rowid,* FROM clients WHERE phone='$client_phone'",true);
		$data = array();

		// Create fields of form on clients data
		foreach ($fields as $key => $value){
			$disabled = '';
			if (isset($client_data[$key])) 
				$disabled = 'disabled';
			elseif ($key == 'phone') {	
				$client_data[$key]=$client_phone;
			} else 
				$client_data[$key]='';
			$data[$value] = $form -> createInputField($key, $client_data[$key], 20, $disabled);
		}
		if (isset($client_data['rowid'])){
			// for client exists add hidden field with id_client
			$addition = "<input name='rowid' type='hidden' value='{$client_data['rowid']}'>";
		} else {
			$addition = '';
		}
		return array($data, $addition);
	}

	public function get_info($id_task)
	{
		$task_list = $this->base->query("SELECT ts.id_task, tsn.name, tsn.value FROM task_status AS ts
									INNER JOIN task_status_names AS tsn
									ON ts.status = tsn.rowid
									WHERE ts.id_task=$id_task");
		$client_info = $this->base->querySingle("SELECT clients.* FROM clients 
												INNER JOIN tasks ON tasks.id_client=clients.rowid
												WHERE tasks.rowid=$id_task", true);
		while ($one_status[] = $task_list->fetchArray(SQLITE3_ASSOC)) {}
		array_pop($one_status);
		return array($client_info,$one_status);
	}
}