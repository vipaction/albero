<div class="container">
<form method="post" action="">
	<input type='hidden' name='table' value='<?=$this->data['table']?>'>
	<table class='data_table' rules="row">
		<?php foreach($this->data['content'] as $name=>$value):?>	
			<tr>
				<th><?=$name?></th>
				<td>
					<?=$this->form->createInputField($name, $value)?>
				</td>
			</tr>
		<?php endforeach?>
	</table>
	<nav class="form_container">
		<?=$this->form->createButton('btn_form btn_apply','Сохранить запись',array("formaction='/admin/save/".$this->data['id_row']."'"))?>
		<?php if ($this->data['id_row'] != '') 
			echo $this->form->createButton('btn_form btn_remove','Удалить запись',array("formaction='/admin/delete/".$this->data['id_row']."'"))?>
		<?=$this->form->createLink('/admin/choose', 'Отмена', array("class='btn_form btn_cancel'"))?>
	</nav>
</form>
</div>