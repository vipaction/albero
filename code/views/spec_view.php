<div class="container info_block">
	<form method="post">
		<table class="data_table" rules="rows">
			<?php foreach ($data['content'] as $block):?>
				<tr>
					<th>Блок <?=$block['block_width'].'*'.$block['block_height']?></th>
					<td>
						<select name="block[<?=$block['rowid']?>]">
							<?php foreach ($door_models as $group_name => $model_name):?>
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
			<button class="btn_form btn_apply" formaction="/spec/calc/<?=$data['id_task']?>" formtarget="_blank">
				Выполнить расчет
			</button>
			<a href="/measure/index/<?=$data['id_task']?>" class="btn_form btn_cancel">Отмена</a>
		</nav>
	</form>
	<div id="door_view"></div>
</div>
<script type="text/javascript" src="/scripts/spec.js"></script>