<section>
	<div class='title'>Заказ №<?php echo $data['id_task']?></div>
	<!-- Information about client-->
	<ul>
	<?php foreach ($data['header']['client_info'] as $key=>$value):?>		
		<li><span><?php echo $key; ?>:</span> <?php echo $value; ?></li>	
	<?php endforeach; ?>
	</ul>
	<nav>
		<?php foreach ($data['header']['status_info'] as $value):?>
			<a href="<?php echo '/'.$value['name'].'/index/'.$value['id_task']; ?>">
				<?php echo $value['value']; ?>
			</a>
		<?php endforeach; ?>
	</nav>
</section>
<img src="/images/user-info-icon.png">