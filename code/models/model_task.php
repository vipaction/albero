<?php
class Model_task extends Model
{
	public function open_task(){
		extract($_POST);	//get all data as variables;
		if (empty($rowid)){
			// add new client to base
			$this->base->exec("INSERT INTO clients (last_name, first_name, second_name, phone, address) 
							VALUES ('$last_name','$first_name','$second_name','$phone','$address')");
			$id_client = $this->base->lastInsertRowID();
		} else {
			// client exist
			$id_client = $rowid;
		}

		$this->base->exec("INSERT INTO tasks (id_client) VALUES ('$id_client')");
		$id_task = $this->base->lastInsertRowID();
		
		return $id_task;
	}


	public function get_data() //Get data for form to create task.
	{
		$client_phone = $_POST['client_phone'];
		$form = new Form;
		$fields = array(
			'last_name'=>'Фамилия',
			'first_name'=>'Имя',
			'second_name'=>'Отчество',
			'address'=>'Адрес',
			'phone'=>'Телефон');
		$query_str = "SELECT rowid,* FROM clients WHERE phone='$client_phone'";
		$client_data = $this->base->querySingle($query_str,true);
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