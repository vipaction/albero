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
			foreach ($this->data['content'] as $name => $value) {
				if (isset($_POST['edit'])) $fields_value[$name] = "<input type='number' value='$value' name='$name' />";
					else $fields_value[$name] = $value;
			}
			$fields_value['summary'] = $this->data['content']['total_sum']+$this->data['content']['delivery_cost']+$this->data['content']['mount_cost'];
			$fields_value['balance'] = $fields_value['summary']-$this->data['content']['prepaid_sum'];
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
			<?php if (!isset($_POST['edit'])):?>
				<?=$this->form->createButton('btn_form btn_apply','Подтвердить заказ',array("formaction='/checkout/apply/".$this->data['id_task']."'"))?>
				<?=$this->form->createButton('btn_form btn_edit','Изменить данные',array("name='edit'"))?>
			<?php else:?>
				<?=$this->form->createButton('btn_form btn_apply','Сохранить',array("formaction='/checkout/apply/".$this->data['id_task']."'"))?>
				<?=$this->form->createLink('','Отмена', array("class='btn_form btn_cancel'"))?>
			<?php endif;?>
		</nav>
	</form>
</div>