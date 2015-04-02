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
		<?php $is_getting = FALSE;
				if (isset($this->data['content']['date'])): ?>
				<tr>
					<th>Получено со склада:</th>
					<td>
						<?php $d_date=getdate($this->data['content']['date']);
							$is_getting = TRUE;
							echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
					</td>
				</tr>
		<?php else:?> 
		<?php foreach ($this->data['content'] as $field_name => $field_value):?>
			<tr>
				<th><?=$fields_names[$field_name];?>:</th>
				<td>
					<?php 
						if ($field_name == 'courier_id')
							echo $this->project_data['couriers_names'][$field_value];
						else
							echo $field_value;
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</table>
	<?php if (!$is_getting):?>
		<nav class="form_container">
			<?=$this->form->createButton('btn_form btn_apply','Подтвердить получение',array("formaction='/ready/apply/".$this->data['id_task']."'"))?>
		</nav>
	<?php endif?>
</form>
</div>