<?php if (!empty($data['content'])):?>
<table class="lined_table">
	<thead>
		<tr align="left">
			<th>ФИО</th>
			<th>Адрес</th>
			<th>Телефон</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data['content'] as $row): ?>
			<tr>
				<td>
					<a href="/clients/info/<?=$row['rowid']; ?>">
						<?=$row['full_name']; ?>
					</a>
				</td>
				<td>
					<a href="/clients/info/<?=$row['rowid']; ?>">
						<?=$row['address']; ?>
					</a>
				</td>
				<td>
					<a href="/clients/info/<?=$row['rowid']; ?>">
						<?=$row['phone'];?>
					</a>
				</td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php else:?>
	<div class="container">Данные отсутствуют</div>
<?php endif;?>