<h2>Список клиентов</h2>
<table cellspacing="0" border="1" bordercolor="grey" cellpadding="5">
	<tr>
		<th>№ Клиента</th>
		<th>ФИО</th>
		<th>Адрес</th>
		<th>Телефон</th>
	</tr>
	<?php foreach ($data as $row): ?>
		<tr>
			<td>
				<?php echo $row['rowid']; ?>
			</td>
			<td>
				<a href="/clients/info/<?php  echo $row['rowid']; ?>">
					<?php echo $row['full_name']; ?>
				</a>
			</td>
			<td>
				<?php echo $row['address']; ?>
			</td>
			<td>
				<?php echo $row['phone']; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>