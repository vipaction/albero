<table>
	<thead>
		<tr align="left">
			<th>№ заказа</th>
			<th>Адрес</th>
			<th>Телефон</th>
			<th>Статус</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $row): ?>
		<tr>
			<th>
				<a href="/task/info/<?php  echo $row['rowid']; ?>" title="Информация о заказе №<?php echo $row['rowid']; ?>">
					<?php echo $row['rowid']; ?>
				</a>
			</th>
			<td>
				<a href="/<?php  echo $row['name'].'/index/'.$row['rowid']; ?>">
					<?php echo $row['address']; ?>
				</a>
			</td>
			<td>
				<a href="/<?php  echo $row['name'].'/index/'.$row['rowid']; ?>">
					<?php echo $row['phone']; ?>
				</a>
			</td>
			<td>
				<?php if ($row['name'] == 'close'): 
					echo $row['value'];
				else: ?>
					<a href="/<?php  echo $row['name'].'/index/'.$row['rowid']; ?>">
						<?php echo $row['value']; ?>
					</a>
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>