<section>
	<div class="title"><?=$data['title']?></div>
	<form method="post" action="">
		<nav>
			<input type="search" value="" placeholder="Поиск клиента" class="search_field" name="search">
			<?php $fields_array = array(
					'all'=>'Все', 
					'no_orders'=>'без заказов');
				$form = new Form;
				$current_value = isset($_POST['sort']) ? $_POST['sort'] : '';
				echo $form->createSelectField('sort', $current_value, $fields_array);?>
			<input type="submit" value="Найти" class="btn_form btn_find">
			<button class="btn_form btn_add_user" formaction="/clients/info" name="edit">Добавить клиента</button>
		</nav>
	</form>
</section>
<img src="/images/users-icon.png" class="header_img">