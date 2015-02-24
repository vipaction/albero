<div class="container">
<form method="post" action="">
	<?php 
		$form = new Form;
		$fields_names = array(
			'courier_id' => 'Служба доставки',
			'declarate_num' => '№ декларации',
			'payment' => 'Стоимость услуги');
		$couriers_names = array(null=>'',1=>'Новая Почта', 'Деливери', 'Первый Курьер', 'Интайм', 'другой')
	?>
	<table class="data_table" rules="rows">
		<?php $disable = '';
				if (isset($data['content']['date'])): ?>
				<tr>
					<th>Получено со склада:</th>
					<td>
						<?php $d_date=getdate($data['content']['date']);
							$disable = 'disabled';
							echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
					</td>
				</tr>
		<?php else:?> 
		<?php foreach ($data['content'] as $field_name => $field_value):?>
			<tr>
				<th><?=$fields_names[$field_name];?>:</th>
				<td>
					<?php 
						if ($field_name == 'courier_id')
							echo $couriers_names[$field_value];
						else
							echo $field_value;
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</table>
	<nav class="form_container">
		<button class="btn_form btn_apply" formaction="/ready/apply/<?=$data['id_task']?>" <?=$disable?>>
			Подтвердить получение
		</button>
	</nav>
</form>
</div>