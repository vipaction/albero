<h3>Данные клиента</h3>
<div>
	<b>Фамилия:</b> 
	<?php echo $data['last_name'] ?>
</div>
<div>
	<b>Имя:</b> 
	<?php echo $data['first_name'] ?>
</div>
<div>
	<b>Отчество:</b> 
	<?php echo $data['second_name'] ?>
</div>
<div>
	<b>Адрес:</b> 
	<?php echo $data['address'] ?>
</div>
<div>
	<b>Телефон:</b>
	<?php echo $data['phone'] ?>
</div>
<hr>
<h3>Статусы заказа</h3>
	<?php foreach ($addition as $value): ?>
		<div>
			<a href="/<?php echo $value['name'] ?>/index/<?php echo $value['id_task'] ?>">
				<?php echo $value['value'] ?>
			</a>
		</div>
	<?php endforeach ?>
<hr>
<a href="/main">Вернуться к списку задач</a>