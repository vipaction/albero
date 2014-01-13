<h2>Подтверждение заказа от фабрики</h2>
<hr>
<form method="post" action="/order/close">
	Фабричный номер заказа: <input type="text" value="<?php echo $data?>" name="order_num">
	<hr>
	<button>Сохранить</button>
	<button name="cancel">Отмена</button>
</form>

