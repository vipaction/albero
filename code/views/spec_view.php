<div class="container">
	<form method="post">
		<table rules="rows" class="data_table" style="font-size: 13px">
			<tr>
				<th>Выбор</th>
				<th>Блок</th>
				<th>Модель</th>
				<th>Параметр</th>
				<th>Значение</th>
			</tr>
			<?php foreach ($this->data['content'] as $block):?>
				<tr>
					<td style='width:20px'><?=$this->form->createCheckboxField("door[{$block['rowid']}]", TRUE)?></td>
					<td><?=$this->project_data['door_type'][$block['door_type']].' '.$this->project_data['room_type'][$block['room_type']].', '.$block['block_width'].'*'.$block['block_height']?></td>
					<td>
						<?php if ($this->project_data['door_type'][$block['door_type']] !== 'фальшкоробка'):?>
							<select name="block[<?=$block['rowid']?>]">
								<?php foreach ($this->data['group'] as $name => $group_content):?>
									<optgroup label="<?=$name?>">
										<?php foreach ($group_content as $key=>$value):?>
											<option value="<?=$key?>">модель <?=$value['number']?></option>
										<?php endforeach;?>
									</optgroup>
								<?php endforeach;?>
							</select>
						<?php endif?>
					</td>
					
						<?php switch ($this->project_data['door_type'][$block['door_type']]) {
							case 'межкомнатная':
								echo '<td></td>';
								echo "<td><input type='hidden' name='frame[".$block['rowid']."]' value='1'></td>";
								break;
							case 'двухстворчатая':
								echo '<td>Основное полотно:</td>';
								echo "<td><input type='hidden' name='frame[".$block['rowid']."]' value='1'>".$this->form->createInputField("door_width[{$block['rowid']}]", 600).'</td>';
								break;
							case 'раздвижная':
								echo '<td>Упорный брус:</td>';
								echo '<td>'.$this->form->createCheckboxField("bumper[{$block['rowid']}]", TRUE).'</td>';
								break;
							default:
								echo '<td>'.''.'</td><td>'.''.'</td>';
								break;
						}?>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
		<nav class="form_container">
			<?=$this->form->createButton('btn_form btn_apply', 'Выполнить расчет', array("formaction='/spec/calc/{$this->data['id_task']}'","formtarget='_blank'"))?>
			<?=$this->form->createLink('/spec/choose/', 'Редактировать параметры', array("class='btn_form btn_edit'"))?>
			<?=$this->form->createLink('/measure/index/'.$this->data['id_task'], 'Отмена', array("class='btn_form btn_cancel'"))?>
		</nav>
	</form>
</div>