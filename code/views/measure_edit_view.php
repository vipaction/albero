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
				if (isset($this->data['content']['measurement'])):
					foreach ($this->data['content']['measurement'] as $column): ?>	
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
											echo $form->createSelectField($key."[$i]", $content, $this->project_data[$key], $size=1);
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
							<?php if (!empty($this->data['content']['thumbs'])):?>
								<?php foreach ($this->data['content']['thumbs'] as $key=>$images):?>
									<div class="thumb_container as_column"> 
										<img border="1" src="/<?=$images?>">
										<input type="checkbox" name="del_img[<?=$images?>]">
									</div>
								<?php endforeach;?>
							<?php endif;?>	
						</section>
					</td>
					<td colspan="8">
						<?php if (!empty($this->data['content']['comment'])) $style_txt="display: flex;"?>
							<div class="thumb_container as_column" id="add_txt" style="<?=$style_txt?>"> 
								<textarea name="comment"><?=$this->data['content']['comment']?></textarea>
								<input type="checkbox" name="del_txt">
							</div>

					</td>
				</tr>
			</tfoot>
		</table> 
		<nav class="form_container">
			<?=$this->form->createButton('btn_form btn_apply', 'Сохранить изменения', array("formaction='/measure/save/".$this->data['id_task']."'"))?>
			<?=$this->form->createButton('btn_form btn_add_new', 'Добавить проём', array("name='add_new'", "value='$i'"))?>
			<?=$this->form->createButton('btn_form btn_add_img', 'Добавить фото', array("onClick='display_block(\"img\")'", "type='button'"))?>
			<?=$this->form->createButton('btn_form btn_add_txt', 'Добавить описание', array("onClick='display_block(\"text\")'", "type='button'"))?>
		</nav>
	</form>
</div>
<script src="/scripts/measure.js"></script>