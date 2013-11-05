<?php
class Form 
/* Common functions which used to create any form in views*/
{
	public function createInputField($name, $current_value, $size = 20, $disabled = NULL){
		return "<input type='text' name='$name' value='$current_value' size=$size $disabled>";
	}

	public function createSelectField($name, $current_value, $list_value, $size = 3){
		$to_string = "<select name='$name' size=$size>";
		foreach ($list_value as $value => $content) {
			$selected = ($value==$current_value) ? 'selected' : '';
			$to_string .= "<option value='$value' $selected>$content</option>";
		}
		$to_string .= "</select>";
		return $to_string;
	}

	public function createCheckboxField($name, $value = NULL){
		$checked = $value ? 'checked' : '';
		return "<input type='checkbox' name='$name' $checked>";
	}

}

class Client_info

{
	public function getInfo($id){
		$base = new Dbase;
		$client_info = $base->querySingle("SELECT * FROM clients WHERE rowid='$id'",true);
		$data = array();
		$data['Клиент'] = ucwords($client_info['last_name']).' '.ucwords($client_info['first_name']).' '.ucwords($client_info['second_name']);
		$data['Телефон'] = $client_info['phone'];
		$data['Адрес'] = $client_info['address'];
		return $data;
	}
}