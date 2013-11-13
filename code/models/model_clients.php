<?php
class Model_clients extends Model {

/*
	Methods:
		get_data - get list of all clients
		get_info - get info about choosen clients
*/

	public function get_data(){
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

	public function get_info($id_client){
		// clients info (first, last, second name, address, phone)
		$client_info = $this->base->querySingle("SELECT * FROM clients WHERE rowid=$id_client", true);

		// client's tasks with statuses
		$client_tasks = $this->base->query("SELECT t.rowid, tsn.name, tsn.value
											FROM tasks AS t
											INNER JOIN task_status AS ts
											ON ts.id_task=t.rowid
											INNER JOIN task_status_names AS tsn
											ON tsn.rowid = ts.status
											WHERE t.id_client=$id_client");
		while ($one_task[] = $client_tasks->fetchArray(SQLITE3_ASSOC)) {
		}
		array_pop($one_task);		// delete last value (will 'false')
		return array($client_info, $one_task);
	}
}