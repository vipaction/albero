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
			'tasks'=>array(	// many_tasks-to-one_client
				'id_client INTEGER',
				'is_closed INTEGER'), //0 - active task, 1 - closed(archived) task
			'staff'=>array(	// staff 
				'id_auth INTEGER',
				'last_name TEXT',
				'first_name TEXT',
				'type INTEGER', // 1 - administrator, 2 - manager, 3 - montager
				'PRIMARY KEY (id_auth)'),
			'auth'=>array(	// authorization of staff
				'login TEXT',
				'password TEXT'),
			'clients'=>array(	// client's data
				'first_name TEXT',
				'last_name TEXT',
				'second_name TEXT',
				'address TEXT',
				'phone TEXT PRIMARY KEY'),
			'task_status'=>array(	// info about task's status
				'id_task INTEGER',
				'date INTEGER',		// date of change task status
				'status INTEGER',	// type of status from task_status_names
				'staff INTEGER',	// staff which set current status
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
				'door_jamb INTEGER',		// count of jambs
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
				'payment INTEGER'),
			'door_model'=>array(
				'name TEXT'),
			'door_number'=>array(
				'id_model INTEGER',
				'number INTEGER',
				'tech TEXT'),
			'door_elem'=>array(
				'name TEXT',
				'content TEXT',
				'tech TEXT'),
			'door_material'=>array(
				'name TEXT',
				'content TEXT',
				'price INTEGER',
				'tag TEXT'),
			'door_param'=>array(
				'name TEXT',
				'content TEXT',
				'value INTEGER'),
			'estimate_date'=>array(
				'id_task INTEGER',
				'status INTEGER',
				'date INTEGER',
				'PRIMARY KEY (id_task, status)'));
		foreach ($tables as $name => $content) { // Creating tables if it nessesary
			Dbase::$dbf->exec("CREATE TABLE IF NOT EXISTS $name (".implode(', ', $content).")");
			$empty_table = Dbase::$dbf->querySingle("SELECT count(*) FROM task_status_names");
			if ($empty_table == 0){
				Dbase::addValues();
			}
		}
	}
}

class DTable {
	private $db;
	function __construct(){
		$this->db = new SQLite3('base.db');
	}
	public function get_fields($table){
		$query_str = "PRAGMA table_info(".$table.")";
		$query_arr = $this->db->query($query_str);
		while($res = $query_arr->fetchArray(SQLITE3_ASSOC)){
			$result[] = $res['name'];
		} 
		return $result;
	}
	public function get_values($table, $param='', $key=''){
		$query_str = "SELECT rowid, * FROM ".$table;
		if ($param !== '')
			$query_str .= " WHERE ".$param;
		$query_arr = $this->db->query($query_str);
		$result = array();
		while($res = $query_arr->fetchArray(SQLITE3_ASSOC)){
			if ($key === '')
				$key = 'rowid';
			$value = $res[$key];
			unset($res[$key]);
			$result[$value] = $res;
		} 
		return $result;
	}

	public function set_values($table, $values, $rowid){
		if ($rowid !== '') {
			foreach ($values as $key => $value) {
				$query_arr[] = "$key='$value'";
			}
			$query_str = "UPDATE ".$table." SET ".implode(',', $query_arr)." WHERE rowid=".$rowid;
		} else {
			$query_str = "INSERT INTO ".$table." (".implode(',', array_keys($values)).") VALUES ('".implode("','",array_values($values))."')";
		}
		$this->db->exec($query_str);
	}
	public function remove_values($table, $rowid){
		$query_str = "DELETE FROM ".$table." WHERE rowid=".$rowid;
		$this->db->exec($query_str);
	}
}