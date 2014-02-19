<form method="post" action="/measure/save">
	<fieldset>
		<legend>Размеры проема</legend>
		<div>ширина: <?php echo $form->createInputField('section_width', $data['section_width'],5); ?> </div>
		<div>высота: <?php echo $form->createInputField('section_height', $data['section_height'],5); ?> </div>
		<div>толщина: <?php echo $form->createInputField('section_thickness', $data['section_thickness'],5); ?> </div>
	</fieldset>
	<fieldset>
		<legend>Размеры дверного блока</legend>
		<div>ширина: <?php echo $form->createInputField('block_width', $data['block_width'],5); ?> </div>
		<div>высота: <?php echo $form->createInputField('block_height', $data['block_height'],5); ?> </div>
		<div>расширитель: <?php echo $form->createInputField('block_add', $data['block_add'],5); ?>  </div>
	</fieldset>
	<fieldset>
		<legend>Описание двери</legend>
		<div>комната: <?php echo $form->createSelectField('room_type', $data['room_type'], $room_type, 1); ?></div>
		<div>тип двери: <?php echo $form->createSelectField('door_type', $data['door_type'], $door_type, 1); ?></div>
		<div>открывание: <?php echo $form->createSelectField('door_openning', $data['door_openning'], $door_openning, 1); ?></div>
		<div>тип ручки: <?php echo $form->createSelectField('door_handle', $data['door_handle'], $door_handle, 1); ?></div>
		<div>количество наличников: <?php echo $form->createInputField('door_jamb', $data['door_jamb'],3); ?></div>
		<div>порог: <?php echo $form->createCheckboxField('door_step', $data['door_step']); ?></div>
	</fieldset>
	<fieldset>
		<legend>Дополнительно</legend>
		<div>расширение проема: <?php echo $form->createCheckboxField('cut_section', $data['cut_section']); ?></div>
		<div>подрезка полотна: <?php echo $form->createCheckboxField('cut_block', $data['cut_block']); ?></div>
		<div>врезка элементов: <?php echo $form->createCheckboxField('cut_door', $data['cut_door']); ?></div>
	</fieldset>	
	<button name='send'>Отправить</button>
	<button>Отмена</button>
</form>