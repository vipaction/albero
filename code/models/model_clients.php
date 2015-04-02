<?php
class Model_clients extends Model {

/*
	Methods:
		get_data - get list of all clients
		get_info - get info about choosen clients
		save_client - update client's data or create new record for new client
*/

	function get_data(){
		$condition = "";
		if (isset($_POST['search'])) {
			$search_str = $_POST['search'];
			if ($_POST['sort'] == 'no_orders')
				$condition .= " LEFT OUTER JOIN tasks ON tasks.id_client=clients.rowid WHERE tasks.id_client IS NULL AND";
			else
				$condition .= " WHERE";
			$condition .= " (clients.first_name LIKE '%$search_str%' OR clients.second_name LIKE '%$search_str%'
					OR clients.last_name LIKE '%$search_str%' OR clients.address LIKE '%$search_str%' OR clients.phone LIKE '%$search_str%')";
		}
		$query_str = "SELECT clients.rowid, * FROM clients $condition ORDER BY clients.rowid DESC";
		$result=$this->base->query($query_str);
		while ($content = $result->fetchArray(SQLITE3_ASSOC)) {
			
			// get clients full name or noname
			if ($content['last_name']!== '' || $content['first_name']!== '' || $content['second_name']!==''){
				$content['full_name'] = $content['last_name'].' '.$content['first_name'].' '.$content['second_name'];
				unset($content['last_name'],$content['first_name'],$content['second_name']);
			} elseif (!empty($content)) {
				$content['full_name'] = 'нет данных';
			}
			$this->data['content'][] = $content;
		}
		$this->data['title'] = 'Список клиентов';
		return $this->data;
	}

	function get_info($id_client){
		// clients info (first, last, second name, address, phone)
		$this->data['client_info'] = $this->get_client_info($id_client);
		$this->data['id_client'] = $id_client;
		// client's tasks with statuses
		$client_tasks = $this->base->query("SELECT t.rowid, tsn.name, tsn.value, t.is_closed, ts.date, s.last_name, s.first_name
											FROM tasks AS t
											INNER JOIN task_status AS ts
											ON ts.id_task=t.rowid
											INNER JOIN task_status_names AS tsn
											ON tsn.rowid = ts.status
											LEFT JOIN staff AS s
											ON s.id_auth = ts.staff
											WHERE t.id_client=$id_client");
		while ($tasks = $client_tasks->fetchArray(SQLITE3_ASSOC)){
			if (!empty($tasks['date'])){
				$status_date_all = getdate($tasks['date']);
				$status_date = $status_date_all['mday'].'-'.$status_date_all['mon'].'-'.$status_date_all['year'];
			} else
				$status_date = '';
			$this->data['tasks'][$tasks['rowid']]['statuses'][] = array(
					'name' => $tasks['name'],
					'value' => $tasks['value'], 
					'staff' => $tasks['last_name'].' '.$tasks['first_name'],
					'date' => $status_date,);
			$this->data['tasks'][$tasks['rowid']]['closed'] = $tasks['is_closed'];
		}
		$this->data['title'] = "Информация о клиенте";
		return $this->data;
	}

	function save_client($id_client){
		$client_data = $_POST;

		// search phone number in DB, if in it then exit
		$check_phone = $this->base->querySingle("SELECT rowid FROM clients WHERE phone='{$client_data['phone']}'");

		if (!empty($id_client)){
			if ((int) $check_phone !== (int) $id_client)
				return $check_phone;	// return id_client which phone number was input
			// edit current client
			foreach ($client_data as $key => $value) {
				$arg_set[] = "$key='$value'";
			}
			$arr_sets = implode(',' , $arg_set);
			$this->base->exec("UPDATE clients SET $arr_sets WHERE rowid='$id_client'");
		} else {
			if (!is_null($check_phone))
				return $check_phone;	// return id_client which phone number was input
			// create new record for new client
			$array_check = array_filter($client_data);
			if (empty($array_check)) 
				return;
			$arr_set = implode(',', array_keys($client_data));
			
			$arr_values = implode(',', array_map(function($value){return "'$value'";}, array_values($client_data)));
			$this->base->exec("INSERT INTO clients ($arr_set) VALUES ($arr_values)");
			$id_client = $this->base->lastInsertRowID();
		}
		return $id_client;
	}

	function delete_client($id_client){
		// get client's tasks
		$tasks = $this->base->query("SELECT rowid FROM tasks WHERE id_client='$id_client'");
		while ($task = $tasks->fetchArray(SQLITE3_NUM)) {
			// delete all records of this task
			$id_task=$task[0];
			$tables = array('task_status', 'measure', 'measure_content', 'checkout', 'postage');
			$exec_string='';
			foreach ($tables as $table) {
				$exec_string .= "DELETE FROM $table WHERE id_task='$id_task';";
			}
			$exec_string .= "; DELETE FROM tasks WHERE rowid='$id_task'";
			$this->base->exec($exec_string);

			//delete all images and folder of this task;
			$path = "images/task_".$id_task;
			if (is_dir($path)){
				$files = glob($path.'/*.*');
				if (!empty($files)){
					foreach ($files as $file) {
						unlink($file);
					}
				}
				rmdir($path);
			}
		}
		$this->base->exec("DELETE FROM clients WHERE rowid='$id_client'");
	}
}