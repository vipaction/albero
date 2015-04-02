<div class="container">
<form method="post" action="">
	<div class="event_select">
		<?php
		echo $this->form->createSelectField('task',  '', $this->data['content']['task']);
		echo $this->form->createSelectField('status',  '', $this->data['content']['status'])?>
	</div>
	<nav class="form_container"> 
		<?=$this->form->createButton('btn_form btn_apply', 'Сохранить', array("formaction='/calendar/add/{$this->data['date']}'"))?>
		<?=$this->form->createLink('/calendar', 'Отмена', array("class='btn_form btn_cancel'"))?>
	</nav>
</form>
</div>