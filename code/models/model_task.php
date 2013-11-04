<?php
class Model_task extends Model
{
	public function get_data()
	{
		// Repeat input phone for empty field
		$client_phone = $_POST['client_phone'];
		$form = new Form;
		$fields = array(
			'last_name'=>'Фамилия',
			'first_name'=>'Имя',
			'second_name'=>'Отчество',
			'address'=>'Адрес',
			'phone'=>'Телефон');
		$query_str = "SELECT rowid,* FROM clients WHERE phone='$client_phone'";
		$client_data = $this->base->db()->querySingle($query_str,true);
		$data = array();

		// Create fields of form on clients data
		foreach ($fields as $key => $value){
			$disabled = '';
			if (isset($client_data[$key])) 
				$disabled = 'disabled';
			elseif ($key == 'phone') {	
				$client_data[$key]=$client_phone;
			} else 
				$client_data[$key]='';
			$data[$value] = $form -> createInputField($key, $client_data[$key], 20, $disabled);
		}
		if (isset($client_data['rowid'])){
			// for client exists add hidden field with id_client
			$addition = "<input name='rowid' type='hidden' value='{$client_data['rowid']}'>";
		} else {
			$addition = '';
		}
		return array($data, $addition);
	}
}