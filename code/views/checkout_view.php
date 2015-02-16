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
		<ul>
			<?php foreach ($fields_name as $field_name => $field_value):?>
				<li>
					<span><?=$field_value;?>:</span>
					<?php if (($field_name == 'summary') || ($field_name) == 'balance'):?>
						<b><?=$fields_value[$field_name];?></b>
					<?php else: ?>
						<?=$fields_value[$field_name];?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<button formaction="/checkout/apply/<?=$data['id_task']?>">
			<img src="/images/apply-icon.png">Подтвердить заказ
		</button>
		<button name="edit">
		<img src="/images/add-notes-icon.png">Изменить данные
		</button>
	</form>
</div>