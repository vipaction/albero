<div class="container">
<form method="post" action="">
	<table class="data_table" rules="rows">
		<tr>
			<?php 
				$disable = '';
				if (isset($data['content']['date'])): ?>
				<th>Доставлено заказчику:</th>
				<td>
					<?php $d_date=getdate($data['content']['date']);
						$disable = 'disabled';
						echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
				</td>
			<?php else:?>
				<th>Стоимость доставки:</th>
				<td><?=$data['content']['delivery_cost'];?></td>
			<?php endif;?>
		</tr>
	</table>
	<div class="container_buttons">
		<button formaction="/delivery/apply/<?=$data['id_task']?>" <?=$disable?>>
			<img src="/images/apply-icon.png">Подтвердить доставку
		</button>
	</div>
</form>
</div>