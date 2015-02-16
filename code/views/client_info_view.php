<?php extract($data); ?>
<div class="card_field">
	<h3>Данные клиента</h3>
	<ul>
		<?php foreach ($clients_data as $name => $value):?>
			<li><span><?php echo $value; ?></span><?php echo $clients_info[$name]; ?></li>
		<?php endforeach;?>
	</ul>
	<div>
		<form method="post">
			<button formaction="/clients/edit"><img src="/images/edit-user-icon.png">Редактировать данные</button>
			<button formaction="/clients/delete"><img src="/images/remove-user-icon.png">Удалить клиента</button>
		</form>
	</div>
</div>
<hr>
<h3>Заказы клиента</h3>
	<?php foreach ($all_tasks as $value): ?>
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
	<button name="mode" value="measure"><img src="/images/add-notes-icon.png">Сделать замер</button>
	<button name="mode" value="checkout"><img src="/images/cart-icon.png">Оформить покупку</button>
</form>