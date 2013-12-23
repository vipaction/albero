<a href='/clients/search'>Новая задача</a>
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
<a href="/fill">Filling from csv</a>