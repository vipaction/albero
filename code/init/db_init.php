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
					"'order', 'подтверждение'",
					"'ready', 'ожидание готовности'",
					"'delivery', 'доставка'",
					"'mount', 'установка'",
					"'close', 'выполнено'"
					)
				),
			"staff"=>array(
				"fields"=>"last_name, first_name, type",
				"values"=>array(
					"'Васютин', 'Алексей', '1'",
					"'Малык', 'Алексей', '2'",
					"'Малык', 'Максим', '2'",
					"'Климова', 'Елена', '1'",
					"'Какаято', 'Наташа', '3'",
					"'Ещеодна', 'Алина', '3'"
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
				'id_client INTEGER'),
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
			'checkout_list'=>array(
				'checkout_id INTEGER PRIMARY KEY ASC',
				'id_task INTEGER',
				'id_measure INTEGER',
				'delivery_cost INTEGER',
				'lifting_cost INTEGER',
				'mount_cost INTEGER',
				'total_sum INTEGER',
				'prepaid_sum INTEGER',
				'lost_sum INTEGER'),
			'items_checkout'=>array(
				'item_id INTEGER PRIMARY KEY ASC',
				'checkout_id INTEGER',
				'item_type INTEGER'),
			'item_door'=>array(
				'door_id INTEGER PRIMARY KEY ASC',
				'item_id INTEGER',
				'type_construction INTEGER',
				'fabric_id INTEGER',
				'model_name TEXT',
				'width_door INTEGER',
				'height_door INTEGER',
				'openning_type INTEGER'),
			'item_door_tech'=>array(
				'door_id INTEGER',
				'filling_type TEXT'),
			'item_furniture'=>array(
				'furniture_id INTEGER PRIMARY KEY ASC',
				'item_id INTEGER'),
			'item_furniture_tech'=>array(
				'furniture_id INTEGER',
				'furniture_type INTEGER',
				'furniture_model TEXT',
				'furniture_color TEXT',
				'count INTEGER'),
			'item_moulding'=>array(
				'moulding_id INTEGER PRIMARY KEY ASC',
				'item_id INTEGER'),
			'item_moulding_tech'=>array(
				'moulding_id INTEGER',
				'moulding_type INTEGER',
				'fabric_id INTEGER',
				'moulding_modelTEXT',
				'moulding_colorTEXT',
				'moulding_width INTEGER',
				'moulding_height INTEGER',
				'count INTEGER'),
			'order_check'=>array(
				'id_task INTEGER',
				'order_num TEXT'),
			'ready'=>array(
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