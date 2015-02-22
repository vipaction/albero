<?php
class Dbase
{
	static $dbf;

	private function addValues($table){
		$value_list = array(
			"task_status_names"=>array(
				"fields"=>"name, value",
				"values"=>array(
					"'measure', 'замер'",
					"'checkout', 'оформление'",
					"'postage', 'отправка'",
					"'ready', 'получение'",
					"'delivery', 'доставка'",
					"'mount', 'установка'"
					)
				),
			"staff"=>array(
				"fields"=>"last_name, first_name, type",
				"values"=>array(
					"'Васютин', 'Алексей', '1'",
					"'Малык', 'Алексей', '2'",
					"'Малык', 'Максим', '2'",
					)
				)
			);
		if (isset($value_list[$table])){
			foreach ($value_list[$table]['values'] as $value) {
				Dbase::$dbf->exec("INSERT INTO $table ({$value_list[$table]['fields']}) VALUES ($value)");
			}
		}
	}
	
	static function reset()			// reset tables
	{
		Dbase::$dbf = new SQLite3('base.db');
		$tables = array(
			'tasks'=>array(
				'id_client INTEGER',
				'is_closed INTEGER'),
			'staff'=>array(
				'last_name TEXT',
				'first_name TEXT',
				'type INTEGER',
				'PRIMARY KEY (last_name, first_name)'),
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
				'responsible_staff  INTEGER',
				'PRIMARY KEY (id_task, status)'),
			'task_status_names'=>array(
				'name TEXT PRIMARY KEY',
				'value TEXT',),
			'measure'=>array(
				'id_task INTEGER',
				'photo TEXT',
				'comment TEXT'),
			'measure_content'=>array(
				'id_measure INTEGER',
				'room_type INTEGER',
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
				'cut_door INTEGER'),
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
				'payment TEXT'));
		foreach ($tables as $name => $content) {
			Dbase::$dbf->exec("CREATE TABLE IF NOT EXISTS $name (".implode(', ', $content).")");
			$empty_table = Dbase::$dbf->querySingle("SELECT count(*) FROM $name");
			if ($empty_table == 0){
				Dbase::addValues($name);
			}
		}

	}
}