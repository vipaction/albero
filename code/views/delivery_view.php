<div class="container">
<form method="post" action="">
	<input type="hidden" name="delivery_date" value="<?=date('U');?>">
	<ul>
		<li>
			<?php 
				$disable = '';
				if (isset($data['content']['delivery_date'])): ?>
				<span>Доставлено заказчику:</span>
				<?php $d_date=getdate($data['content']['delivery_date']);
					$disable = 'disabled';
					echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
			<?php else:?>
				<span>Стоимость доставки:</span><?=$data['content']['delivery_cost'];?>
			<?php endif;?>
		</li>
	</ul>
	<button formaction="/delivery/apply/<?=$data['id_task'].'" '.$disable?>>
		<img src="/images/apply-icon.png">Подтвердить доставку
	</button>
</form>
</div>