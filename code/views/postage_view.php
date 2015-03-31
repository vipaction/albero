<div class="container">
<form method="post" action="">
	<?php 
		$form = new Form;
		$fields_names = array(
			'courier_id' => 'Служба доставки',
			'declarate_num' => '№ декларации',
			'payment' => 'Стоимость услуги');
	?>
	<table class="data_table" rules="rows">
		<?php foreach ($data['content'] as $field_name => $field_value):?>
			<tr>
				<th><?=$fields_names[$field_name];?>:</th>
				<td>
					<?php 
					if (isset($_POST['edit']))
						if ($field_name == 'courier_id')
								echo $form->createSelectField($field_name, $field_value, $couriers_names,1);
							else
								echo $form->createInputField($field_name, $field_value);
					else
						if ($field_name == 'courier_id')
							echo $couriers_names[$field_value];
						else
							echo $field_value;
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<nav class="form_container">
		<button class="btn_form btn_apply" formaction="/postage/apply/<?=$data['id_task']?>">Подтвердить готовность</button>
		<?php if (!isset($_POST['edit'])):?>
			<button class="btn_form btn_edit" name="edit">Изменить данные</button>
		<?php else:?>
			<button class="btn_form btn_cancel">Отмена</button>
		<?php endif;?>
	</nav>
</form>
</div>