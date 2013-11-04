<h3>
	Создание заявки для <?php echo $client_name;?>
</h3>
<hr>
<form method='post'>
<?php
	$form_fields=array(
		'last_name'=>'Фамилия',
		'first_name'=>'Имя',
		'second_name'=>'Отчество',
		'address'=>'Адрес',
		'phone'=>'Телефон');
	foreach ($form_fields as $field => $value) {
		$disabled='';
		if (isset($search_result[$field])) 
			$disabled='disabled';
		elseif ($field == 'phone') 
			$search_result[$field]=$client_phone;
		else 
			$search_result[$field]='';
		echo "<div>$value: <input type='text' name='$field' value='{$search_result[$field]}' $disabled></div>";
	}
?>	
	<hr>
	<div>
		Менеджер:

		<select>
			<?php mangrSelect(); ?>
		</select>
	</div>
	<hr>
	<div>
		<button name='create_task' value="sample">Сделать замер</button>
		<button name='create_task' value="delivery">Доставка дверей</button>
		<button name='create_task' value="mount">Монтаж дверей</button>
		<button name='create_task' value="claim">Рекламация</button>
		<button name='create_task' value="cancel">Отмена</button>
	</div>
</form>

