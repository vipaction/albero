<div class="container">
	<form method="post" action="">
		<?php $fields_name = array(
			'total_sum'=>'Сумма по заказу',
			'delivery_cost'=>'Доставка',
			'mount_cost'=>'Монтажные работы',
			'summary'=>'Всего',
			'prepaid_sum'=>'Оплачено',
			'balance'=>'Остаток'); 
			$fields_value = array();
			foreach ($data['content'] as $name => $value) {
				if (isset($_POST['edit'])) $fields_value[$name] = "<input type='number' value='$value' name='$name' />";
					else $fields_value[$name] = $value;
			}
			$fields_value['summary'] = $data['content']['total_sum']+$data['content']['delivery_cost']+$data['content']['mount_cost'];
			$fields_value['balance'] = $fields_value['summary']-$data['content']['prepaid_sum'];
		?>
		<table class="data_table" rules="rows">
			<?php foreach ($fields_name as $field_name => $field_value):?>
				<tr>
					<th><?=$field_value;?>:</th>
					<td>
						<?php if (($field_name == 'summary') || ($field_name) == 'balance'):?>
							<b><?=$fields_value[$field_name];?></b>
						<?php else: ?>
							<?=$fields_value[$field_name];?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<nav class="form_container">
			<?php if (isset($_POST['edit'])):?>
				<button class="btn_form btn_apply" formaction="/checkout/apply/<?=$data['id_task']?>">Сохранить</button>
				<button class="btn_form btn_cancel">Отмена</button>
			<?php else:?>
				<button class="btn_form btn_apply" formaction="/checkout/apply/<?=$data['id_task']?>">Подтвердить заказ</button>
				<button class="btn_form btn_edit" name="edit">Изменить данные</button>
			<?php endif;?>
		</nav>
	</form>
</div>