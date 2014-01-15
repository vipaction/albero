<h2>Подтверждение заказа от фабрики</h2>
<?php extract($data); ?>
<hr>
Заказ № <?php echo $inner_id; ?>
<form method="post" action="/order/close">
	Номер заказа от фабрики: 
	<?php echo $form->createInputField('order_num', $order_num)?>
	<hr>
	<button>Сохранить</button>
	<button name="cancel">Отмена</button>
</form>

