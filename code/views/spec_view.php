<div class="container">
	<form method="post">
		<table rules="rows" class="data_table">
			<tr>
				<th>Блок</th>
				<th>Модель</th>
			</tr>
			<?php foreach ($this->data['content'] as $block):?>
				<tr>
					<td><?=$this->project_data['room_type'][$block['room_type']].' '.$block['block_width'].'*'.$block['block_height']?></td>
					<td>
						<select name="block[<?=$block['rowid']?>]">
							<?php foreach ($this->project_data['door_models'] as $group_name => $model_name):?>
								<optgroup label="<?=$group_name?>">
									<?php foreach ($model_name as $value):?>
										<option value="<?=$value?>">модель <?=$value?></option>
									<?php endforeach;?>
								</optgroup>
							<?php endforeach;?>
						</select>
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