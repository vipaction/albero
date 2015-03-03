<section>
	<div class="title"><?=$data['title']?></div>
	<form method="post" action="">
		<table class="data_table" rules="rows">
			<?php foreach ($clients_data as $name => $value): /* $clients info is constant from constants.php */?> 
				<tr>
					<th><?php echo $value; ?></th>
					<td>
						<?php if (isset($_POST['edit'])):?>
								<input name="<?=$name?>" value="<?=$data['client_info'][$name]?>">
						<?php else:?>
								<?=$data['client_info'][$name]?>
						<?php endif;?>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
		<nav class="form_container">
			<?php if (isset($_POST['edit'])):?>
				<button class="btn_form btn_apply" formaction="/clients/save/<?=$data['id_client']?>">Сохранить изменения</button>
				<button class="btn_form btn_cancel">Отмена</button>
			<?php else:?>
				<button class="btn_form btn_measure" formaction="/task/index/<?=$data['id_client']?>">Создать заявку</button>
				<button class="btn_form btn_edit" name="edit">Редактировать данные</button>
				<button class="btn_form btn_cancel" formaction="/clients/delete/<?=$data['id_client']?>">Удалить клиента</button>
			<?php endif;?>
		</nav>
	</form>
</section>
<img src="/images/user-info-icon.png" class="header_img">