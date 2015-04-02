<div class="container">
	<form method="post" action="">
		<table class="data_table" rules="rows">
			<?php
			$user_data = array('last_name'=>'Фамилия', 'first_name'=>'Имя', 'login'=>'Логин', 'password'=>'Пароль');
			foreach ($user_data as $key=>$value):?>
				<tr>
					<th><?=$value?></th>
					<td><?=$this->form->createInputField($key,($key == 'password') ? '' : $this->data['content'][$key],'required');?></td>
				</tr>
			<?php endforeach?>
			<tr>
				<th>Категория</th>
				<td><?=$this->form->createSelectField('type',$this->data['content']['type'], $this->project_data['staff_type']);?></td>
			</tr>
		</table>
		<nav class="form_container">
			<?=$this->form->createButton('btn_form btn_edit_user','Сохранить',array("formaction='/admin/save/{$this->data['content']['id_auth']}'"))?>
			<?php if (!empty($this->data['content']['id_auth']))
				echo $this->form->createLink('/admin/delete/'.$this->data['content']['id_auth'], 'Удалить', array("class='btn_form btn_remove_user'"))?>
			<?=$this->form->createLink('/admin/index', 'Отмена', array("class='btn_form btn_cancel'"))?>
		</nav>
	</form>
</div>