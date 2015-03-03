<?php if (!empty($data['content'])):?>	
	<table class="lined_table">
		<thead>
			<tr align="left">
				<th>Адрес</th>
				<th>Телефон</th>
				<th>Статус</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($data['content'] as $row): ?>
			<tr>
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
<?php else:?>
	<div class="container">Данные отсутствуют</div>
<?php endif;?>