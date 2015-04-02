<?php if (!empty($this->data['content'])):?>
<table class="lined_table">
	<thead>
		<tr align="left">
			<th>ФИО</th>
			<th>Адрес</th>
			<th>Телефон</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($this->data['content'] as $row): ?>
			<tr>
				<td>
					<?=$this->form->createLink('/clients/info/'.$row['rowid'], $row['full_name'])?>
				</td>
				<td>
					<?=$this->form->createLink('/clients/info/'.$row['rowid'], $row['address'])?>
				</td>
				<td>
					<?=$this->form->createLink('/clients/info/'.$row['rowid'], $row['phone'])?>
				</td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php else:?>
	<div class="container">Данные отсутствуют</div>
<?php endif;?>