<h2>Подтверждение готовности на фабрике</h2>
<hr>
<form method="post" action="/ready/close">
	<div>
		Курьер: <?php echo $form->createSelectField('courier_id', $data['courier_id'], array('')+$couriers, 1);?>
	</div>
	<div>
		№ декларации: <?php echo $form->createInputField('declarate_num', $data['declarate_num']);?>
	</div>
	<div>
		Стоимость доставки: <?php echo $form->createInputField('payment', $data['payment']);?>
	</div>
	<hr>
	<button>Сохранить</button>
	<button name="cancel">Отмена</button>
</form>

