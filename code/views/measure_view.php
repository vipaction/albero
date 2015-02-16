<?php extract($data['content']); ?>
<table border="1">
	<thead>
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
			<th>комн.</th>
			<th>тип</th>
			<th>W</th>
			<th>H</th>
			<th>D</th>
			<th>W</th>
			<th>H</th>
			<th>D+</th>
			<th>откр.</th>
			<th>ручка</th>
			<th>нал.</th>
			<th>порог</th>
			<th>расш.</th>
			<th>подр.</th>
			<th>врез.</th>
		</tr>
	</thead>
	<tbody>
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
						<a href="/measure/edit/<?php echo $id ?>">
							<button class="min_button">
								<img src="/images/edit-icon.png" width="16px">
							</button>
						</a>
						<a href="/measure/delete/<?php echo $id ?>">
							<button class="min_button">
							<img src="/images/delete-icon.png" width="16px">
							</button>
						</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table> 
<form method="post" action="/measure/form/">
	<button><img src="/images/add-new-icon.png">Добавить проем</button>
</form>
<hr>
<form method="post" action="/measure/comment/">
	<textarea name="comment"><?php if (isset($comment)) echo $comment; ?></textarea>
	<button><img src="/images/add-notes-icon.png"> Сохранить комментарий</button>
	<?php if (isset($comment)): ?>
		<button name='delete'><img src="/images/delete-notes-icon.png"> Удалить комментарий</button>
	<?php endif; ?>

</form>
<hr>
<?php if (isset($image)): ?>
	<a href="/images/<?php echo $image; ?>" target="_blanc"><?php echo $image; ?></a>
<?php endif; ?>
	<form method="post" action="/measure/image/" enctype="multipart/form-data">
		<?php if (isset($image)): ?>
			<button name='delete'><img src="/images/delete-image-icon.png">Удалить фото</button>
		<?php endif; ?>
		<input type="file" name="photo">
		<button>
			<img src="/images/image-icon.png">
			<?php if (isset($image)): ?>
				Изменить фото
			<?php else: ?>
				Сохранить фото
			<?php endif; ?>
		</button>
	</form>
<hr>
<form method="post" action="/measure/apply/">
	<button><img src="/images/apply-icon.png">Отправить замер</button>
</form>