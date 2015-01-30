<header>
	<pre>Список клиентов</pre>
	<input type="search" value="" placeholder="Поиск клиента" class="search_field">
</header>
<table cellspacing="0" cellpadding="5">
	<tr align="left">
		<th>ФИО</th>
		<th>Адрес</th>
		<th>Телефон</th>
	</tr>
	<?php foreach ($data as $row): ?>
		<tr>
			<!-- Deleted $row['row_id']-->
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