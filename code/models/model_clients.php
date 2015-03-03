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
		if (isset($_POST['search'])) {
			$search_str = $_POST['search'];
			$condition = "WHERE first_name LIKE '%$search_str%' OR second_name LIKE '%$search_str%'
					OR last_name LIKE '%$search_str%' OR address LIKE '%$search_str%' OR phone LIKE '%$search_str%'";
		} else
			$condition = "";
		$query_str = "SELECT rowid, * FROM clients $condition ORDER BY rowid DESC";
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
		$client_tasks = $this->base->query("SELECT t.rowid, tsn.name, tsn.value, t.is_closed, ts.date, ts.responsible_staff
											FROM tasks AS t
											INNER JOIN task_status AS ts
											ON ts.id_task=t.rowid
											INNER JOIN task_status_names AS tsn
											ON tsn.rowid = ts.status
											WHERE t.id_client=$id_client");
		while ($tasks[] = $client_tasks->fetchArray(SQLITE3_ASSOC));
		array_pop($tasks);		// delete last value (will 'false')
		foreach ($tasks as $value) { // split all statuses for each task.
			$status_date = getdate($value['date']);
			$this->data['tasks'][$value['rowid']]['statuses'][] = array(
					'name' => $value['name'],
					'value' => $value['value'], 
					'staff' => $value['responsible_staff'],
					'date' => $status_date['mday'].'-'.$status_date['mon'].'-'.$status_date['year'],);
			$this->data['tasks'][$value['rowid']]['closed'] = $value['is_closed'];
		}
		$this->data['title'] = "Информация о клиенте";
		return $this->data;
	}

	function save_client(&$id_client){
		$client_data = $_POST;
		if (!is_null($id_client)){

			// edit current client

			foreach ($client_data as $key => $value) {
				$arg_set[] = "$key='$value'";
			}
			$arr_sets = implode(',' , $arg_set);
			$this->base->exec("UPDATE clients SET $arr_sets WHERE rowid='$id_client'");
		} else {

			// create new record for new client

			$arr_set = implode(',', array_keys($client_data));
			$quotes_add = function($value){
				return "'$value'";
			};
			$arr_values = implode(',', array_map($quotes_add, array_values($client_data)));
			$this->base->exec("INSERT INTO clients ($arr_set) VALUES ($arr_values)");
			$id_client = $this->base->lastInsertRowID();;
		}
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