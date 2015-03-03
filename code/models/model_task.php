<?php
class Model_task extends Model
{
	/*
	Methods:
		open_task - create record in data base with choosen status for current client
		
	*/

	function open_task($id_client){
		// Save new record to tasks table
		$this->base->exec("INSERT INTO tasks (id_client) VALUES ($id_client)"); 
		$id_task = $this->base->lastInsertRowID();
		
		// Set a new status for new record as 'measure'
		$this->base->exec("INSERT INTO task_status (id_task, status, date) 
					VALUES ($id_task, (SELECT rowid FROM task_status_names WHERE name='measure'), '".date('U')."')");
	}

	function delete_task($id_task){
		// get client's id
		$id_client = $this->base->querySingle("SELECT id_client FROM tasks WHERE rowid='$id_task'");
		
		// delete all records of this task
		$tables = array('task_status', 'measure', 'measure_content', 'checkout', 'postage');
		$exec_string='';
		foreach ($tables as $table) {
			$exec_string .= "DELETE FROM $table WHERE id_task='$id_task';";
		}
		$exec_string .= "DELETE FROM tasks WHERE rowid='$id_task'";
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
		return $id_client;
	}
}