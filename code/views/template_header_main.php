<section>
	<div class='title'><?=$data['title']?></div>
	<nav class="as_column">
		<form method="post" action="" class="as_row">
			<input type="search" placeholder="Поиск задачи" class="search_field" name="search">
			<input type="submit" value="Найти" class="btn_form btn_apply">
		</form>
		<div>
			Показывать: 
			<select>
				<option>Все</option>
				<option>Замер</option>
				<option>Оформление</option>
				<option>Отправка со склада</option>
				<option>Получение со склада</option>
				<option>Доставка</option>
				<option>Установка</option>
			</select>
		</div>
	</nav>
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