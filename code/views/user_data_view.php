<div class="container">
	<form method="post" action="">
		<?php $form = new Form;?>
		<table class="data_table" rules="rows">
			<tr>
				<th>Фамилия</th>
				<td><?=$form->createInputField('last_name',$data['content']['last_name'],'required');?></td>
			</tr>
			<tr>
				<th>Имя</th>
				<td><?=$form->createInputField('first_name',$data['content']['first_name'],'required');?></td>
			</tr>
			<tr>
				<th>Логин</th>
				<td><?=$form->createInputField('login',$data['content']['login'],'required');?></td>
			</tr>
			<tr>
				<th>Пароль</th>
				<td><?=$form->createInputField('password','','required');?></td>
			</tr>
			<tr>
				<th>Категория</th>
				<td><?=$form->createSelectField('type',$data['content']['type'], $staff_type);?></td>
			</tr>
		</table>
		<nav class="form_container">
			<button class="btn_form btn_edit_user" formaction="/admin/save/<?=$data['content']['id_auth']?>">Сохранить</button>
			<?php if (!empty($data['content']['id_auth'])):?>
				<a class="btn_form btn_remove_user" href="/admin/delete/<?=$data['content']['id_auth']?>">Удалить </a>
			<?php endif;?>
			<a class="btn_form btn_cancel" href="/admin/index">Отмена</a>
		</nav>
	</form>
</div>