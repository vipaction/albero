<?php
	function addQuotes($a){
		return "'".$a."'";
	}

	$sql_test = array(
		'clients'=>array(
			array(
				'first_name'=>'Петр',
				'second_name'=>'Петрович',
				'last_name'=>'Петров',
				'address'=>'ул. Тестовая 14/14',
				'phone'=>'09612345678'),
			array(
				'first_name'=>'Иван',
				'second_name'=>'Иванович',
				'last_name'=>'Иванов',
				'address'=>'ул. Космическая 19',
				'phone'=>'4011216'),
			array(
				'first_name'=>'Сидор',
				'second_name'=>'Сидорович',
				'last_name'=>'Сидоров',
				'address'=>'ул. Ленина 123/33',
				'phone'=>'0509201515'),
			array(
				'first_name'=>'Людмила',
				'second_name'=>'Николаевна',
				'last_name'=>'Яременко',
				'address'=>'ул. Косиора 12/115',
				'phone'=>'0631234568'),
			array(
				'first_name'=>'Константин',
				'second_name'=>'Павлович',
				'last_name'=>'Воробьев',
				'address'=>'пр. Металлургов 45/23',
				'phone'=>'0985689853')
			),
		'staff'=>array(
			array(
			'first_name'=>'Максим',
			'last_name'=>'Малык',
			'type'=>'2'),
			array(
			'first_name'=>'Алексей',
			'last_name'=>'Малык',
			'type'=>'2'),
			array(
			'first_name'=>'Алексей',
			'last_name'=>'Васютин',
			'type'=>'1'),
			array(
			'first_name'=>'Елена',
			'last_name'=>'Васютина',
			'type'=>'1')));
	foreach ($sql_test as $table => $content) {
		foreach ($content as $values) {
			$fields = implode(',', array_keys($values));
			$test_data = implode(',', array_map('addQuotes',$values));
			$sql_text = "INSERT INTO $table ($fields) VALUES ($test_data)";
			$db -> exec($sql_text);
		}
	}
?>