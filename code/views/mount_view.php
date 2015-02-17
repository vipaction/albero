<div class="container">
<form method="post" action="">
	<input type="hidden" name="mount_date" value="<?=date('U');?>">
	<ul>
		<li>
			<?php 
				$disable = '';
				if (isset($data['content']['mount_date'])): ?>
				<span>Установлено:</span>
				<?php $d_date=getdate($data['content']['mount_date']);
					$disable = 'disabled';
					echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
			<?php else:?>
				<span>Стоимость монтажа:</span><?=$data['content']['mount_cost'];?>
			<?php endif;?>
		</li>
	</ul>
	<button formaction="/mount/apply/<?=$data['id_task'].'" '.$disable?>>
		<img src="/images/apply-icon.png">Подтвердить установку
	</button>
</form>
</div>