<div class="container">
<form method="post" action="">
	<table class='data_table'>
		<tr>
			<th>Выбор таблицы</th>
			<td><?=$this->form->createSelectField('table','',$this->data['content'])?></td>
		</tr>
	</table>
	<nav class="form_container">
		<?=$this->form->createButton('btn_form btn_apply','Редактировать таблицу',array("formaction='/admin/table/'"))?>
		<?=$this->form->createLink('/admin/index', 'Отмена', array("class='btn_form btn_cancel'"))?>
	</nav>
</form>
</div>