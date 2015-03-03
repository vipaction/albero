<?php
class Dbase
{
	static $dbf;

	private function addValues(){
		$value_list = array(	// Previous save status names values in task_status_names
				"fields"=>"name, value",
				"values"=>array(
					"'measure', 'замер'",
					"'checkout', 'оформление'",
					"'postage', 'отправка'",
					"'ready', 'получение'",
					"'delivery', 'доставка'",
					"'mount', 'установка'"
					)
				);
		foreach ($value_list['values'] as $value) {
			Dbase::$dbf->exec("INSERT INTO task_status_names ({$value_list['fields']}) VALUES ($value)");
		}
	}
	
	static function reset()			// reset tables
	{
		Dbase::$dbf = new SQLite3('base.db');
		$tables = array(
			'tasks'=>array(
				'id_client INTEGER',
				'is_closed INTEGER'), //0 - active task, 1 - closed(archived) task
			'staff'=>array(
				'last_name TEXT',
				'first_name TEXT',
				'type INTEGER', // 1 - administrator, 2 - manager, 3 - montager
				'PRIMARY KEY (last_name, first_name)'),
			'clients'=>array(
				'first_name TEXT',
				'last_name TEXT',
				'second_name TEXT',
				'address TEXT',
				'phone TEXT PRIMARY KEY'),
			'task_status'=>array(
				'id_task INTEGER',
				'date INTEGER',		// date of change task status
				'status INTEGER',	// type of status from task_status_names
				'responsible_staff  INTEGER',
				'PRIMARY KEY (id_task, status)'),
			'task_status_names'=>array(
				'name TEXT PRIMARY KEY',	// english name of status for form fields names
				'value TEXT',),		// russian alternative value for text output
			'measure'=>array(
				'id_task INTEGER',
				'comment TEXT'),	// comment to measure table
			'measure_content'=>array(
				'id_task INTEGER',
				'room_type INTEGER',	// type of room, values for it in data/constants.php
				'section_width INTEGER',
				'section_height INTEGER',
				'section_thickness INTEGER',
				'block_width INTEGER',
				'block_height INTEGER',
				'block_add INTEGER',
				'door_type INTEGER',		// ----------------------------------------
				'door_openning INTEGER',	// value for this types in data/constants.php
				'door_handle INTEGER',		// ----------------------------------------
				'door_jamb INTEGER',		
				'door_step INTEGER',		// ----------------------------------------
				'cut_section INTEGER',		// for this fields: null/0 - not use , 1 - 
				'cut_block INTEGER',		// needed
				'cut_door INTEGER'),		// ----------------------------------------
			'checkout'=>array(
				'id_task INTEGER PRIMARY KEY',
				'delivery_cost INTEGER',
				'mount_cost INTEGER',
				'total_sum INTEGER',
				'prepaid_sum INTEGER'),
			'postage'=>array(
				'id_task INTEGER',
				'declarate_num TEXT',
				'courier_id INTEGER',
				'payment INTEGER'));
		foreach ($tables as $name => $content) {
			Dbase::$dbf->exec("CREATE TABLE IF NOT EXISTS $name (".implode(', ', $content).")");
			$empty_table = Dbase::$dbf->querySingle("SELECT count(*) FROM task_status_names");
			if ($empty_table == 0){
				Dbase::addValues();
			}
		}
	}
}