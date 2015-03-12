<div class="container">
<form method="post" action="">
	<div class="event_select">
		<?php $form = new Form;
		echo $form->createSelectField('task',  '', $data['content']['task']);
		echo $form->createSelectField('status',  '', $data['content']['status'])?>
	</div>
	<nav class="form_container"> 
		<button class="btn_form btn_apply" formaction="/calendar/add/<?=$data['date']?>">Сохранить</button>
		<a href="/calendar"class="btn_form btn_cancel">Отмена</a>
	</nav>
</form>
</div>