<h2>Подтверждение готовности на фабрике</h2>
<?php extract($data); ?>
<hr>
	Заказ №: 
	<?php echo $inner_id; ?>
	Фабричный номер: 
	<?php echo $order_num]; ?>
<hr>
<form method="post" action="/ready/close">
	<div>
		Курьер: <?php echo $form->createSelectField('courier_id', $couriers_data['courier_id'], array('')+$couriers, 1);?>
	</div>
	<div>
		№ декларации: <?php echo $form->createInputField('declarate_num', $couriers_data['declarate_num']);?>
	</div>
	<div>
		Стоимость доставки: <?php echo $form->createInputField('payment', $couriers_data['payment']);?>
	</div>
	<hr>
	<button>Сохранить</button>
	<button name="cancel">Отмена</button>
</form>

