<?php
class Model_task extends Model
{
	/*
	Methods:
		open_task - create record in data base with choosen status for current client
		get_info - get all data about client and statuses of current task 
	*/

	function open_task($task_mode){
		$id_client = $_COOKIE['id_client'];
		// create task and save status to base
		$this->base->exec("INSERT INTO tasks (id_client) VALUES ('$id_client')");
		$id_task = $this->base->lastInsertRowID();
		$this->base->exec("INSERT INTO task_status (id_task, date, status, responsible_staff) 
							VALUES ($id_task, 10, (SELECT rowid FROM task_status_names WHERE name='$task_mode'), 1)");
	}
// delete this method when restruct it
	function get_info($id_task)
	{
		$task_list = $this->base->query("SELECT ts.id_task, tsn.name, tsn.value FROM task_status AS ts
									INNER JOIN task_status_names AS tsn
									ON ts.status = tsn.rowid
									WHERE ts.id_task=$id_task AND tsn.name!='close'");
		$client_info = $this->base->querySingle("SELECT clients.* FROM clients 
												INNER JOIN tasks ON tasks.id_client=clients.rowid
												WHERE tasks.rowid=$id_task", true);
		while ($one_status[] = $task_list->fetchArray(SQLITE3_ASSOC)) {}
		array_pop($one_status);
		return array($client_info,$one_status);
	}
}