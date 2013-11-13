<div>
	<a href='/task/search'>Создать новую зявку</a>
	<a href='/clients/index'>Смотреть список клиентов</a>
</div>
<br>
<table cellspacing="0" border="1" bordercolor="grey" cellpadding="5">
	<tr>
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
				<a href="/<?php  echo $row['name']; ?>/index/<?php  echo $row['rowid']; ?>">
					<?php echo $row['value']; ?>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>