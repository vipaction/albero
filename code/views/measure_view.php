<?php extract($data); ?>

<table border="1" cellspacing="0" cellpadding="2">
	<tr>
		<th colspan="3">Дверь</th>
		<th colspan="3">Проем</th>
		<th colspan="3">Блок</th>
		<th colspan="3">Особенности</th>
		<th colspan="4">Дополнительно</th>
		<th rowspan="2">Действия</th>
	</tr>
	<tr>
		<th>№</th>
		<th>комната</th>
		<th>тип двери</th>
		<th>ширина</th>
		<th>высота</th>
		<th>толщина</th>
		<th>ширина</th>
		<th>высота</th>
		<th>расширитель</th>
		<th>открывание</th>
		<th>ручка</th>
		<th>наличник</th>
		<th>порог</th>
		<th>расширение</th>
		<th>подрезка</th>
		<th>врезка</th>
	</tr>
	<?php 
	$i = 1;
	foreach ($measurement as $id=>$value): ?>	
		<tr>
			<td>
				<?php echo $i++; ?>
			</td>
			<?php foreach ($value as $key=>$content): ?>
				<td>
					<?php if (in_array($key, array('door_type', 'room_type', 'door_openning', 'door_handle'))) 
							echo ${$key}[$content]; 
						else 
							echo $content; 
						// replace integer value to russian text?>
				</td>
			<?php endforeach; ?> 
			<td>
				<?php if ($id !== ''): ?>
					<a href="/measure/edit/<?php echo $id ?>">редактировать</a>
					<a href="/measure/delete/<?php echo $id ?>">удалить</a>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach;?>
</table> 
<form method="post" action="/measure/form/">
	<button>Добавить проем</button>
</form>
<hr>
<form method="post" action="/measure/comment/">
	<textarea name="comment"><?php if (isset($comment)) echo $comment; ?></textarea>
	<button>Сохранить комментарий</button>
	<?php if (isset($comment)): ?>
		<button name='delete'>Удалить комментарий</button>
	<?php endif; ?>

</form>
<hr>
<?php if (isset($image)): ?>
	<a href="/images/<?php echo $image; ?>" target="_blanc"><?php echo $image; ?></a>
<?php endif; ?>
	<form method="post" action="/measure/image/" enctype="multipart/form-data">
		<?php if (isset($image)): ?>
			<button name='delete'>Удалить фото</button>
		<?php endif; ?>
		<input type="file" name="photo">
		<button>
			<?php if (isset($image)): ?>
				Изменить фото
			<?php else: ?>
				Сохранить фото
			<?php endif; ?>
		</button>
	</form>
<hr>
<form method="post" action="/measure/close/">
	<button>Отправить замер</button>
</form>