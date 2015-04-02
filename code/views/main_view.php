<?php if (!empty($this->data['content'])):?>	
	<table class="lined_table">
		<thead>
			<tr align="left">
				<th>Адрес</th>
				<th>Телефон</th>
				<th>Статус</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($this->data['content'] as $row): ?>
			<tr>
				<td>
					<?=$this->form->createLink('/'.$row['name'].'/index/'.$row['rowid'], $row['address'])?>
				</td>
				<td>
					<?=$this->form->createLink('/'.$row['name'].'/index/'.$row['rowid'], $row['phone'])?>
				</td>
				<td>
					<?=$this->form->createLink('/'.$row['name'].'/index/'.$row['rowid'], $row['value'])?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php else:?>
	<div class="container">Данные отсутствуют</div>
<?php endif;?>