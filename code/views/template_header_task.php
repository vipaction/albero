<section>
	<div class='title'><?=$data['title']?></div>
	<!-- Information about client-->
	<table class="data_table" rules="rows">
		<?php foreach ($clients_data as $name => $value):?>		
			<tr>
				<th><?=$value?>:</th> 
				<td><?=$data['header']['client_info'][$name];?></td>
			</tr>	
		<?php endforeach; ?>
	</table>
	
	<nav class="nav_container">
		<?php foreach ($data['header']['status_info'] as $value):?>
			<a class="btn_nav" href="<?='/'.$value['name'].'/index/'.$value['id_task']; ?>">
				<?=$value['value'];?>
			</a>
		<?php endforeach; ?>
	</nav>
	
</section>
<a href="/clients/info/<?=$data['header']['id_client']?>" title="Данные о клиенте">
	<img src="/images/user-info-icon.png" class="header_img" alt="Данные о клиенте">
</a>