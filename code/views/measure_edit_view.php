<script src="/scripts/measure.js"></script>
<div class="container measure_block">
	<form method="post" action="" enctype="multipart/form-data">
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
							<td><input name="delete[<?=$i?>]" type="checkbox"></td>
						</tr>
					<?php endforeach;
				endif;?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="9">
						<div id="add_img">
							<p>К загрузке допускаются только файлы с расширением jpg/jpeg</p>
							<input type="file" name="photo">
						</div>
						<section class="as_row thumbs">
							<?php if (!empty($data['content']['thumbs'])):?>
								<?php foreach ($data['content']['thumbs'] as $key=>$images):?>
									<div class="thumb_container as_column"> 
										<img border="1" src="/<?=$images?>">
										<input type="checkbox" name="del_img[<?=$images?>]">
									</div>
								<?php endforeach;?>
							<?php endif;?>	
						</section>
					</td>
					<td colspan="8">
						<?php if (!empty($data['content']['comment'])) $style_txt="display: flex;"?>
							<div class="thumb_container as_column" id="add_txt" style="<?=$style_txt?>"> 
								<textarea name="comment"><?=$data['content']['comment']?></textarea>
								<input type="checkbox" name="del_txt">
							</div>

					</td>
				</tr>
			</tfoot>
		</table> 
		<nav class="form_container">
			<button class="btn_form btn_apply" formaction="/measure/save/<?=$data['id_task']?>">Сохранить изменения</button>
			<button class="btn_form btn_add_new" name="add_new" value="<?=$i?>">Добавить проём</button>
			<button class="btn_form btn_add_img" onClick="display_block('img')" type="button">Добавить фото</button>
			<button class="btn_form btn_add_txt" onClick="display_block('text')" type="button">Добавить описание</button>
		</nav>
	</form>
</div>