<table cellspacing="0" cellpadding="5">
	<thead>
		<tr align="left">
			<th>ФИО</th>
			<th>Адрес</th>
			<th>Телефон</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $row): ?>
		<tr>
			<!-- Deleted $row['row_id']-->
			<td>
				<a href="/clients/info/<?php  echo $row['rowid']; ?>">
					<?php echo $row['full_name']; ?>
				</a>
			</td>
			<td>
				<a href="/clients/info/<?php  echo $row['rowid']; ?>">
					<?php echo $row['address']; ?>
				</a>
			</td>
			<td>
				<a href="/clients/info/<?php  echo $row['rowid']; ?>">
					<?php echo $row['phone']; ?>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>