<div class="container">
<form method="post" action="">
	<?php 
		$fields_names = array(
			'courier_id' => 'Служба доставки',
			'declarate_num' => '№ декларации',
			'payment' => 'Стоимость услуги');
	?>
	<table class="data_table" rules="rows">
		<?php foreach ($this->data['content'] as $field_name => $field_value):?>
			<tr>
				<th><?=$fields_names[$field_name];?>:</th>
				<td>
					<?php 
					if (isset($_POST['edit']))
						if ($field_name == 'courier_id')
								echo $this->form->createSelectField($field_name, $field_value, $this->project_data['couriers_names'],1);
							else
								echo $this->form->createInputField($field_name, $field_value);
					else
						if ($field_name == 'courier_id')
							echo $this->project_data['couriers_names'][$field_value];
						else
							echo $field_value;
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<nav class="form_container">
		<?php if (!isset($_POST['edit'])):?>
			<?=$this->form->createButton('btn_form btn_apply','Подтвердить готовность',array("formaction='/postage/apply/".$this->data['id_task']."'"))?>
			<?=$this->form->createButton('btn_form btn_edit','Изменить данные',array("name='edit'"))?>
		<?php else:?>
			<?=$this->form->createButton('btn_form btn_apply','Сохранить',array("formaction='/postage/apply/".$this->data['id_task']."'"))?>
			<?=$this->form->createLink('','Отмена', array("class='btn_form btn_cancel'"))?>
		<?php endif;?>
	</nav>
</form>
</div>