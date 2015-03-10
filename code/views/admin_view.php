<div class="container">
	<?php if (!empty($data['content'])):?>	
		<table class="data_table">
			<thead>
				<tr align="left">
					<th>Фамилия</th>
					<th>Имя</th>
					<th>Категория</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($data['content'] as $row): ?>
				<tr>
					<td>
						<a href="/admin/edit/<?=$row['id_auth']?>">
							<?=$row['last_name']?>
						</a>
					</td>
					<td>
						<a href="/admin/edit/<?=$row['id_auth']?>">
							<?=$row['first_name']?>
						</a>
					</td>
					<td>
						<a href="/admin/edit/<?=$row['id_auth']?>">
							<?=$staff_type[$row['type']]?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else:?>
		<div class="title">Данные отсутствуют</div>
	<?php endif;?>
	<nav class="form_container">
		<a href="/admin/edit" class="btn_form btn_add_user">Добавить нового пользователя</a>
	</nav>
</div>