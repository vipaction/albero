<?php
class Form{ 
/* Common functions which used to create any form in views*/
	function createInputField($name, $current_value, $size = 20){
		return "<input type='text' name='$name' value='$current_value' size=$size>";
	}

	function createSelectField($name, $current_value, $list_value, $size = 3){
		$to_string = "<select name='$name' size=$size>";
		foreach ($list_value as $value => $content) {
			$selected = ($value==$current_value) ? 'selected' : '';
			$to_string .= "<option value='$value' $selected>$content</option>";
		}
		$to_string .= "</select>";
		return $to_string;
	}

	function createCheckboxField($name, $value = NULL){
		$checked = $value ? 'checked' : '';
		return "<input type='checkbox' name='$name' $checked value='1'>";
	}

	function create_link_elem($controller, $name){
		return "<a href='/$controller/index'>$name</a>";
	}
}

class Info{
	public $base;
	public $id_task;
	function __construct(){
		$this->base = new SQLite3('base.db');
		$this->id_task = $_COOKIE['id_task'];
	}

	function client_info(){
		$client_info = $this->base->querySingle("SELECT * FROM clients INNER JOIN tasks ON tasks.id_client=clients.rowid 
											WHERE tasks.rowid='{$this->id_task}'",true);
		$data = array();
		$data['Клиент'] = ucwords($client_info['last_name']).' '.ucwords($client_info['first_name']).' '.ucwords($client_info['second_name']);
		$data['Телефон'] = $client_info['phone'];
		$data['Адрес'] = $client_info['address'];
		return $data;
	}

	function status_info(){
		$task_list = $this->base->query("SELECT tsn.name, tsn.value FROM task_status AS ts
									INNER JOIN task_status_names AS tsn
									ON ts.status = tsn.rowid
									WHERE ts.id_task={$this->id_task} AND tsn.name!='close'");
		while ($statuses[] = $task_list->fetchArray(SQLITE3_ASSOC)) {}
		array_pop($statuses);
		return $statuses;
	}
}
