<?php include('code/views/spec_elem_view_class.php');?>
<div style="width:800px">
	<table class="data_table" rules="all">
		<tr>
			<th colspan="2" align="center">Заказ №<?=$this->data['id_task']?></th>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=$this->data['title']?></td>
		</tr>
		<?php foreach ($this->data['header']['client_info'] as $name=>$value):?>
			<tr>
				<th><?=$this->project_data['clients_data'][$name]?></th>
				<td><?=$value?></td>
			</tr>
		<?php endforeach?>
	</table>
	<?php foreach ($this->data['content'] as $block):?>
	<?php $block_door = new Block_view($block)?>
		<table class="spec_table" rules="all">
			<tr>
				<th>
					<b>
						<?=$block_door->get_model_name()?>
					</b>
				</th>
				<th>
					<b>
						<?=$block->get_param_str()?>
					</b>
				</th>
			</tr>
			<tr>
				<td>
					<?=$block_door->get_model_image()?>
				</td>
				<td style="padding:10px;">
					<table class="spec_table" rules="all">
						<thead>
							<tr>
								<th>Наименование</th>
								<th>Ширина</th>
								<th>Высота</th>
							</tr>
						</thead>
						<tbody>
							<?=$block_door->get_spec_table()?>
							<tr>
								<th colspan="3" style="text-align: center">Дополнительные элементы</th>
							</tr>
							<?=$block_door->get_addition()?>
							<tr>
								<th colspan="3" style="text-align: center">Расход материала</th>
							</tr>
							<?=$block_door->get_materials_data()?>
						</tbody>	
					</table>
				</td>
			</tr>
		</table>
		<br/>
	<?php endforeach;?>
</div>