<section>
	<div class="title"><?=$data['title']?></div>
	<form method="post" action="">
		<input type="search" value="" placeholder="Поиск клиента" class="search_field" name="search">
		<input type="submit" value="Найти">
		<button class="btn_form btn_add_user" formaction="/clients/info" name="edit">Добавить клиента</button>
	</form>
</section>
<img src="/images/users-icon.png" class="header_img">