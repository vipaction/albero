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
					<th rowspan="2">Удалить</th>
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
				$i = 0;
				$form = new Form;
				if (isset($data['content']['measurement'])):
					foreach ($data['content']['measurement'] as $column): ?>	
						<tr>
							<td>
								<?php echo ++$i; ?>
							</td>
							<?php foreach ($column as $key=>$content): ?>
								<td>
									<?php switch ($key){
										case 'door_type': 
										case 'room_type': 
										case 'door_openning': 
										case 'door_handle':
											echo $form->createSelectField($key."[$i]", $content, ${$key}, $size=1);
											break;
										case 'door_step':
										case 'cut_section':
										case 'cut_block':
										case 'cut_door':
											echo $form->createCheckboxField($key."[$i]", $content);
											break;
										default:
											echo $form->createInputField($key."[$i]", $content, "size='3'");
										}?>
								</td>
							<?php endforeach;?>
							<td><input type="checkbox"></td>
						</tr>
					<?php endforeach;
				endif;?>
			</tbody>
		</table> 
		<nav class="form_container">
			<button class="btn_form btn_apply" formaction="/measure/save/<?=$data['id_task']?>">Сохранить изменения</button>
			<button class="btn_form btn_add_new">Добавить проём</button>
			<button class="btn_form btn_add_img">Добавить фото</button>
			<button class="btn_form btn_add_txt">Добавить описание</button>
			<button class="btn_form btn_cancel">Удалить отмеченные</button>
		</nav>
	</form>
</div>