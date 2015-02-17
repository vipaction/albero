<section>
	<div class='title'>Заказ №<?=$data['id_task']?></div>
	<!-- Information about client-->
	<ul>
	<?php foreach ($data['header']['client_info'] as $key=>$value):?>		
		<li><span><?=$key; ?>:</span> <?=$value; ?></li>	
	<?php endforeach; ?>
	</ul>
	<nav>
		<?php foreach ($data['header']['status_info'] as $value):?>
			<a href="<?='/'.$value['name'].'/index/'.$value['id_task']; ?>">
				<?=$value['value'];?>
			</a>
		<?php endforeach; ?>
	</nav>
</section>
<a href="/clients/info/<?=$data['header']['id_client']?>"><img src="/images/user-info-icon.png" class="header_img"></a>