<div class="container">
<form method="post" action="">
	<table class="data_table" rules="rows">
		<tr>
			<?php 
				$disable = '';
				if (isset($data['content']['date'])): ?>
				<th>Установлено:</th>
				<td>
					<?php $d_date=getdate($data['content']['date']);
						$disable = 'disabled';
						echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
				</td>
			<?php else:?>
				<th>Стоимость монтажа:</th>
				<td><?=$data['content']['mount_cost'];?></td>
			<?php endif;?>
		</tr>
	</table>
	<div class="container_buttons">
		<button formaction="/mount/apply/<?=$data['id_task']?>" <?=$disable?>>
			<img src="/images/apply-icon.png">Подтвердить установку
		</button>
	</div>
</form>
</div>