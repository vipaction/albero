<?php
class Dbase
{
	static $dbf;
	
	private function create_Tables($tables)			// Create tables according to content array
	{
		foreach ($tables as $name => $content) {
			$sql_content = "CREATE TABLE IF NOT EXISTS $name (".implode(', ', $content).")";
			Dbase::$dbf->exec($sql_content);
		}
	}

	
	static function reset()			// reset tables
	{
		Dbase::$dbf = new SQLite3('base.db');
		$tables=array(
			'tasks'=>array(
				'id_client INTEGER'),
			'staff'=>array(
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