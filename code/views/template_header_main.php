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