<section>
	<div class="title">Информация о клиенте</div>
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
		<div>
			<?php if (isset($_POST['edit'])):?>
				<button formaction="/clients/save/<?=$data['id_client']?>">
					<img src="/images/edit-user-icon.png">Сохранить изменения
				</button>
				<button><img src="/images/cancel-icon.png">Отмена</button>
			<?php else:?>
				<button name="mode" value="measure"><img src="/images/add-notes-icon.png">Сделать замер</button>
				<button name="mode" value="checkout"><img src="/images/cart-icon.png">Оформить покупку</button>
				<button name="edit"><img src="/images/edit-user-icon.png">Редактировать данные</button>
				<button formaction="/clients/delete"><img src="/images/remove-user-icon.png">Удалить клиента</button>
			<?php endif;?>
		</div>
	</form>
</section>
<img src="/images/user-info-icon.png" class="header_img">