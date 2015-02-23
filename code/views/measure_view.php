<div class="container measure_block">
	<form method="post" action="">
	<table border="1">
		<thead>
			<tr>
				<th colspan="3">Дверь</th>
				<th colspan="3">Проем</th>
				<th colspan="3">Блок</th>
				<th colspan="3">Особенности</th>
				<th colspan="4">Дополнительно</th>
				<?php if (isset($_POST['edit'])):?><th rowspan="2">Действия</th><?php endif;?>
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
			if (isset($data['content']['measurement'])):
				foreach ($data['content']['measurement'] as $id=>$value): ?>	
					<tr>
						<td>
							<?php echo $i++; ?>
						</td>
						<?php foreach ($value as $key=>$content): ?>
							<td>
								<?php if (in_array($key, array('door_type', 'room_type', 'door_openning', 'door_handle'))) 
										echo ${$key}[$content]; // Values of this keys in /data/constant.php
									else 
										echo $content; ?>
							</td>
						<?php endforeach; ?> 
						<?php if (isset($_POST['edit'])):?><td><input type="checkout"></td><?php endif;?>
					</tr>
				<?php endforeach;
			endif;?>
		</tbody>
	</table> 
	<nav class="form_container">
		<button class="butt_form butt_apply">Отправить замер</button>
		<button class="butt_form butt_add_new">Добавить проём</button>
		<button class="butt_form butt_add_img">Добавить фото</button>
		<button class="butt_form butt_add_txt">Добавить описание</button>
	</nav>
</div>