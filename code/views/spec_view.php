<div class="container info_block">
	<form method="post">
		<table class="data_table" rules="rows">
			<?php foreach ($this->data['content'] as $block):?>
				<tr>
					<th>Блок <?=$block['block_width'].'*'.$block['block_height']?></th>
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
			<?=$this->form->createLink('/measure/index/'.$this->data['id_task'], 'Отмена', array("class='btn_form btn_cancel'"))?>
		</nav>
	</form>
	<div id="door_view"></div>
</div>
<script type="text/javascript" src="/scripts/spec.js"></script>