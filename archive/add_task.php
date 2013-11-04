<?php
	if (isset($_POST['test_values'])) {
		include ('fill_test_values.php');
	}
	if (!isset($_POST['find_phone'])){
		include('form_search_client.php');
	} else {
		$client_phone = $_POST['client_phone'];
		$search_result = $db -> querySingle("SELECT * FROM clients WHERE phone='$client_phone'", true);
		if (empty($search_result)) 
			$client_name='нового клиента';
		else
			$client_name = $search_result['last_name'].' '.$search_result['first_name'].' '.$search_result['second_name'];
		include('form_create_task.php');
	}
?>
