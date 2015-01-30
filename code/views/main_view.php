<form method="post">
	<header>
		<pre>Список задач</pre>
		<button formaction="clients/search">
			<img src="/images/add-new-icon.png" width="24">
			Создать новую задачу
		</button>
		<input type="search" value="" placeholder="Поиск задачи" class="search_field">
		<div>
			Показывать: 
			<label>
				<input type="radio">
				все
			</label>
			<label>
				<input type="radio">
				замер
			</label>
			<label>
				<input type="radio">
				оформление
			</label>
			<label>
				<input type="radio">
				доставка
			</label>
			<label>
				<input type="radio">
				монтаж
			</label>
		</div>
	</header>
</form>
<table cellpadding="5">
	<tr align="left">
		<th>№ заказа</th>
		<th>Адрес</th>
		<th>Телефон</th>
		<th>Статус</th>
	</tr>
	<?php foreach ($data as $row): ?>
		<tr>
			<th>
				<a href="/task/info/<?php  echo $row['rowid']; ?>">
					<?php echo $row['rowid']; ?>
				</a>
			</th>
			<td>
				<?php echo $row['address']; ?>
			</td>
			<td>
				<?php echo $row['phone']; ?>
			</td>
			<td>
				<?php if ($row['name'] == 'close'): 
					echo $row['value'];
				else: ?>
					<a href="/<?php  echo $row['name']; ?>/index/<?php  echo $row['rowid']; ?>">
						<?php echo $row['value']; ?>
					</a>
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
