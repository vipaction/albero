<section>
	<div class='title'><?=$data['title']?></div>
	<form method="post" action="" class="as_row">
		<nav>
			<input type="search" placeholder="Поиск задачи" class="search_field" name="search">
			<?php $fields_array = array(
				'all'=>'Все', 
				'measure'=>'Замер', 
				'checkout'=>'Оформление', 
				'postage'=>'Отправка со склада', 
				'ready'=>'Получение со склада', 
				'delivery'=>'Доставка', 
				'mount'=>'Установка');
			$form = new Form;
			$current_value = isset($_POST['sort']) ? $_POST['sort'] : '';
			echo $form->createSelectField('sort', $current_value, $fields_array);?>
			<input type="submit" value="Найти" class="btn_form btn_find">
		</nav>
	</form>	
</section>
<img src="/images/main-task-icon.png" class="header_img">
<form method="post">
	<div class="auth_panel">
		<div>Здравствуйте,</div>
		<div><?=$data['auth']['first_name']?></div>
		<div><button class="btn_auth" formaction="/auth/close">Выход</button></div>
		<?php if ($data['auth']['type'] == 1):?>
			<div><button class="btn_auth" formaction="/admin/index">Панель управления</button></div>
		<?php endif;?>
		
	</div>
</form>