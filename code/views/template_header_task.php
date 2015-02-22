<section>
	<div class='title'>Заказ №<?=$data['id_task']?></div>
	<!-- Information about client-->
	<table class="data_table" rules="rows">
		<?php foreach ($clients_data as $name => $value):?>		
			<tr>
				<th><?=$value?>:</th> 
				<td><?=$data['header']['client_info'][$name];?></td>
			</tr>	
		<?php endforeach; ?>
	</table>
	<nav>
		<?php foreach ($data['header']['status_info'] as $value):?>
			<a href="<?='/'.$value['name'].'/index/'.$value['id_task']; ?>">
				<?=$value['value'];?>
			</a>
		<?php endforeach; ?>
	</nav>
</section>
<a href="/clients/info/<?=$data['header']['id_client']?>"><img src="/images/user-info-icon.png" class="header_img"></a>