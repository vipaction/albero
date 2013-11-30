<?php
class Model_clients extends Model {

/*
	Methods:
		get_data - get list of all clients
		get_info - get info about choosen clients
		check_phone - search phone in database and return id_client or 'false'
		clients_form - get form to input or edit data of client
		save_client - update client's data or create new record for new client
*/

	function get_data(){
		$result=$this->base->query('SELECT rowid, * FROM clients');
		while ($content = $result->fetchArray(SQLITE3_ASSOC)) {
			
			// get clients full name or noname
			if ($content['last_name']!== '' || $content['first_name']!== '' || $content['second_name']!==''){
				$content['full_name'] = $content['last_name'].' '.$content['first_name'].' '.$content['second_name'];
				unset($content['last_name'],$content['first_name'],$content['second_name']);
			} elseif (!empty($content)) {
				$content['full_name'] = 'нет данных';
			}
			$result_list[] = $content;
		}
		return !empty($result_list) ? $result_list : 'Нет записей';
	}

	function get_info($id_client){
		// clients info (first, last, second name, address, phone)
		$client_info = $this->base->querySingle("SELECT * FROM clients WHERE rowid=$id_client", true);

		// client's tasks with statuses
		$client_tasks = $this->base->query("SELECT t.rowid, tsn.name, tsn.value
											FROM tasks AS t
											INNER JOIN task_status AS ts
											ON ts.id_task=t.rowid
											INNER JOIN task_status_names AS tsn
											ON tsn.rowid = ts.status
											INNER JOIN (SELECT rowid, id_task, max(status) FROM task_status GROUP BY id_task) AS sel
											ON sel.rowid = ts.rowid
											WHERE t.id_client=$id_client");
		while ($one_task[] = $client_tasks->fetchArray(SQLITE3_ASSOC));
		array_pop($one_task);		// delete last value (will 'false')
		return array($client_info, $one_task);
	}

	function check_phone(){
		$phone_num = $_POST['client_phone'];
		$check = $this->base->querySingle("SELECT rowid FROM clients WHERE phone='$phone_num'");
		if ($check != '')
			return $check;
		else 
			return false;
	}

	function clients_form($id_client=null){
		if (!$id_client){
			$client_phone = $_POST['client_phone'];
		}
		$form = new Form;
		$fields = array(
			'last_name'=>'Фамилия',
			'first_name'=>'Имя',
			'second_name'=>'Отчество',
			'address'=>'Адрес',
			'phone'=>'Телефон');
		$client_data = $this->base->querySingle("SELECT rowid,* FROM clients WHERE rowid='$id_client'",true);
		$data = array();
		
		// fill array with epmty values if client not exist
		if (empty($client_data)){
			$client_data=array_fill_keys(array_keys($fields), '');
			$client_data['phone']=$client_phone;
		}
		
		// Create fields of form on clients data
		foreach ($fields as $key => $value){
			$data[$value] = $form -> createInputField($key, $client_data[$key], 20);
		}
		if (isset($client_data['rowid'])){
			// for client exists add hidden field with id_client
			$addition = "<input name='rowid' type='hidden' value='{$client_data['rowid']}'>";
		} else {
			$addition = '';
		}
		return array($data, $addition);
	}

	function save_client(){
		$client_data = $_POST;
		if (isset($client_data['rowid'])){

			// edit current client

			$id_client = $client_data['rowid'];
			unset($client_data['rowid']);
			foreach ($client_data as $key => $value) {
				$arr_set[] = "$key='$value'";
			}
			$arr_sets = implode(',' , $arr_set);
			$this->base->exec("UPDATE clients SET $arr_sets WHERE rowid='$id_client'");
			return $id_client;
		} else {

			// create new record for new client

			$arr_set = implode(',', array_keys($client_data));
			$quotes_add = function($value){
				return "'$value'";
			};
			$arr_values = implode(',', array_map($quotes_add, array_values($client_data)));
			$this->base->exec("INSERT INTO clients ($arr_set) VALUES ($arr_values)");
			return $this->base->lastInsertRowID();;
		}
	}
}