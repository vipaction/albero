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
	<form method="post">
		<nav class="nav_container">
			<?php foreach ($data['header']['status_info'] as $value):?>
				<button class="btn_nav" formaction="<?='/'.$value['name'].'/index/'.$value['id_task']; ?>">
					<?=$value['value'];?>
				</button>
			<?php endforeach; ?>
		</nav>
	</form>
</section>
<a href="/clients/info/<?=$data['header']['id_client']?>"><img src="/images/user-info-icon.png" class="header_img"></a>