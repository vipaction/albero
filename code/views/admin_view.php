<div class="container">
	<?php if (!empty($this->data['content'])):?>	
		<table class="data_table">
			<thead>
				<tr align="left">
					<th>Фамилия</th>
					<th>Имя</th>
					<th>Категория</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($this->data['content'] as $row): ?>
				<tr>
					<td>
						<?=$this->form->createLink('/admin/edit/'.$row['id_auth'], $row['last_name'])?>
					</td>
					<td>
						<?=$this->form->createLink('/admin/edit/'.$row['id_auth'], $row['first_name'])?>
					</td>
					<td>
						<?=$this->form->createLink('/admin/edit/'.$row['id_auth'], $row['type'])?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else:?>
		<div class="title">Данные отсутствуют</div>
	<?php endif;?>
	<nav class="form_container">
		<?=$this->form->createLink('/admin/edit/', 'Добавить нового пользователя', array("class='btn_form btn_add_user'"))?>
	</nav>
</div>