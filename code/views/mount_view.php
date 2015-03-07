<div class="container">
<form method="post" action="">
	<table class="data_table" rules="rows">
	<?php 
		$disable = '';
		if (isset($data['content']['date'])): ?>
			<tr>
				<th>Установлено:</th>
				<td>
					<?php $d_date=getdate($data['content']['date']);
						$disable = 'disabled';
						echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
				</td>
			</tr>
		<?php else:?>
			<tr>
				<th>Стоимость монтажа:</th>
				<td><?=$data['content']['mount_cost'];?></td>
			</tr>
			<tr>
				<th>Остаток по договору</th>
				<td><?=$data['content']['total_sum']-$data['content']['prepaid_sum'];?></td>
			</tr>
		<?php endif;?>
	</table>
	<nav class="form_container">
		<button class="btn_form btn_apply" formaction="/mount/apply/<?=$data['id_task']?>" <?=$disable?>>
			Подтвердить установку
		</button>
	</nav>
</form>
</div>