<?php
class Model_calendar extends Model{

	/*
	*/
	function get_calendar(){
		$this->data['title'] = "Календарь событий";
		$events = $this->base->query("SELECT cl.address, tsn.value, est.id_task, est.date FROM estimate_date AS est
									  INNER JOIN task_status_names AS tsn ON tsn.rowid=est.status
									  INNER JOIN tasks AS t ON t.rowid=est.id_task
									  INNER JOIN clients AS cl ON cl.rowid=t.id_client");
		while ($event = $events->fetchArray(SQLITE3_ASSOC)) {
			$week = idate("W", $event['date']);
			$day = idate("w", $event['date']);
			$this->data['dates'][$week][$day][] = $event;
		}
		return $this->data;
	}

	function get_event(){
		$this->data['title'] = "Добавление нового задания в календарь";
		$tasks = $this->base->query("SELECT tasks.rowid, clients.address FROM clients 
									INNER JOIN tasks ON tasks.id_client = clients.rowid
									WHERE tasks.is_closed IS NULL ORDER BY tasks.rowid DESC");
		while ($task = $tasks->fetchArray(SQLITE3_ASSOC)){
			$this->data['content']['task'][$task['rowid']] = $task['address'];
		}
		$statuses = $this->base->query("SELECT rowid, value FROM task_status_names");
		while ($status = $statuses->fetchArray(SQLITE3_ASSOC)) {
			$this->data['content']['status'][$status['rowid']] = $status['value'];
		}
		$this->data['date'] = $_POST['day'];
		return $this->data;
	}

	function add_event($day){
		$task = $_POST['task'];
		$status = $_POST['status'];
		$current_id = $this->base->querySingle("SELECT rowid FROM estimate_date WHERE id_task='$task' AND status='$status'");
		if (empty($current_id)){
			$this->base->exec("INSERT INTO estimate_date (id_task, status, date) VALUES ('$task', '$status', '$day')");
		} else {
			$this->base->exec("UPDATE estimate_date SET date='$day' WHERE status='$status' AND id_task='$task'");
		}
	}

	function remove_event($day){
		$this->base->exec("DELETE FROM estimate_date WHERE date='$day'");
	}
}