<?php
class Dbase
{
	public function db() // Use marker of Data Base
	{
		return new SQLite3('base.db');
	}

	private function check_TableExists($name)		// If table non exists - create new
	{
		$check = Dbase::db()->querySingle("SELECT name FROM sqlite_master
                       WHERE type='table' and name='$name'", true);
		return (empty($check));
	}

	
	private function create_Tables($tables)			// Create tables according to content array
	{
		foreach ($tables as $name => $content) {
			if (Dbase::check_TableExists($name)){
				$sql_content = "CREATE TABLE $name (".implode(', ', $content).")";
				Dbase::db()->exec($sql_content);
			}
		}
	}

	
	static function reset()			// reset tables
	{
		$tables=array(
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
				'responsible_staff  INTEGER'),
			'measure'=>array(
				'id_task INTEGER'),
			'measure_content'=>array(
				'id_measure INTEGER',
				'section_width INTEGER',
				'section_height INTEGER',
				'section_thickness INTEGER',
				'block_width INTEGER',
				'block_height INTEGER',
				'block_add INTEGER',
				'door_type INTEGER',
				'door_openning INTEGER',
				'door_handle INTEGER',
				'door_jamb INTEGER',
				'door_step INTEGER',
				'cut_section INTEGER',
				'cut_block INTEGER',
				'cut_door INTEGER'));
		Dbase::create_Tables($tables);
	}
}