<?php
	function checkTableNotExists($db, $name){ // Return TRUE if table with this name is not exists
		$check = $db -> querySingle("SELECT name FROM sqlite_master
                       WHERE type='table' and name='$name'", true);
		return (empty($check));
	}

	function createTable($db, $name, $content){ // Create table with indicated name if it's not exists
		if (checkTableNotExists($db, $name)){
			$sql_content = "CREATE TABLE $name (".implode(', ', $content).")";
			$db -> exec($sql_content);
		}
	}

	$tables_list=array(  
		'tasks'=>array(
			'id INTEGER PRIMARY KEY AUTOINCREMENT',
			'id_client INTEGER'),
		'staff'=>array(
			'id INTEGER PRIMARY KEY AUTOINCREMENT',
			'first_name TEXT',
			'type INTEGER',
			'last_name TEXT'),
		'clients'=>array(
			'first_name TEXT',
			'last_name TEXT',
			'second_name TEXT',
			'address TEXT',
			'phone TEXT PRIMARY KEY'),
		'task_status'=>array(
			'id INTEGER PRIMARY KEY AUTOINCREMENT',
			'id_task INTEGER',
			'date INTEGER',
			'status INTEGER',
			'responsible_staff  INTEGER'));
	foreach ($tables_list as $name => $content) {
		createTable($db, $name, $content);
	}
?>