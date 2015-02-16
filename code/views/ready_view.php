<div class="container">
<form method="post" action="">
	<?php 
		$form = new Form;
		$fields_names = array(
			'courier_id' => 'Служба доставки',
			'declarate_num' => '№ декларации',
			'payment' => 'Стоимость услуги');
		$couriers_names = array(null=>'',1=>'Новая Почта', 'Деливери', 'Первый Курьер', 'Интайм', 'другой')
	?>
	<ul>
		<?php foreach ($data['content'] as $field_name => $field_value):?>
			<li>
				<span><?=$fields_names[$field_name];?>:</span>
				<?php 
				if (isset($_POST['edit']))
					if ($field_name == 'courier_id')
							echo $form->createSelectField($field_name, $field_value, $couriers_names,1);
						else
							echo $form->createInputField($field_name, $field_value);
				else
					if ($field_name == 'courier_id')
						echo $couriers_names[$field_value];
					else
						echo $field_value;
				?>
			</li>
		<?php endforeach; ?>
	</ul>
	<button formaction="/ready/apply/<?=$data['id_task']?>">
		<img src="/images/apply-icon.png">Подтвердить готовность
	</button>
	<button name="edit">
	<img src="/images/add-notes-icon.png">Изменить данные
	</button>
</form>
</div>