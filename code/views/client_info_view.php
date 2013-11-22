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
<div>
	<form method="post" action="/clients/edit">
		<button>Редактировать данные</button>
	</form>
	<form method="post" action="/clients/delete">
		<button>Удалить клиента</button>
	</form>
</div>
</form>
<hr>
<h3>Заказы клиента</h3>
	<?php foreach ($addition as $value): ?>
		<div>
			<a href="/task/info/<?php echo $value['rowid'] ?>">
				<?php echo $value['rowid'] ?>
			</a>
			- текущий статус:
				<?php if ($value['name'] == 'close'): 
							echo $value['value'];
				else: ?>
					<a href="/<?php echo $value['name'] ?>/index/<?php echo $value['rowid'] ?>">
						<?php echo $value['value'] ?>
					</a>
				<?php endif ?>
			<br>
			<a href="/task/delete/<?php echo $value['rowid'] ?>">удалить заказ</a>
		</div>
	<?php endforeach ?>
<hr>
<h3>Новый заказ</h3>
<form action="/task/" method="post">
	<button name="mode" value="measure">Сделать замер</button>
	<button name="mode" value="payment">Оформить покупку</button>
	<button name="mode" value="delivery">Доставить заказ</button>
	<button name="mode" value="mount">Выполнить монтаж</button>
	
</form>