<?php include('code/views/spec_elem_view_class.php');?>
<div style="width:800px">
	<div class="title"><?=$this->data['title']?></div>
	<table class="spec_table" rules="all">
		<thead>
			<tr>
				<th colspan="2" align="center">Заказ №<?=$this->data['id_task']?></th>
			</tr>
		</thead>
		<?php foreach ($this->data['header']['client_info'] as $name=>$value):?>
			<tr>
				<th align='left' style='width: 200px'><?=$this->project_data['clients_data'][$name]?></th>
				<td align='left'><?=$value?></td>
			</tr>
		<?php endforeach?>
	</table>
	<br />
	<?php
	$elements_list = array(); 
	foreach ($this->data['content'] as $block):?>
		<?php 
		$block_door = new Block_view($block);
		$elements_list = array_merge($elements_list, $block_door->get_total_elem_list());?>
			<table class="spec_table" rules="all">
				<thead>
					<tr>
						<th colspan="2">Детализация полотна двери</th>
					</tr>
				</thead>
				<tr>
					<th>
						<b>
							<?=$block_door->get_model_name()?>
						</b>
					</th>
					<th>
						<b>
							<?=$block_door->get_size_str()?>
						</b>
					</th>
				</tr>
				<tr>
					<td>
						<?=$block_door->get_model_image()?>
					</td>
					<td style="padding:10px;">
						<table class="spec_table" rules="all">
							<tbody>
								<th colspan="4">Элементы двери</th>
								<tr>
									<td><b>Наименование</b></td>
									<td><b>Длина</b></td>
									<td><b>Ширина</b></td>
									<td><b>Кол-во</b></td>
								</tr>
								<?php foreach ($block_door->get_elem_list('main') as $elem):?>
									<tr>
										<td><?=$this->project_data['door_elements'][$elem['type']]?></td>
										<td><?=$elem['length']?></td>
										<td><?=$elem['width']?></td>
										<td><?=$elem['count']?></td>
									</tr>
								<?php endforeach?>
								<th colspan="4">Дополнительные элементы</th>
								<tr>
									<td><b>Наименование</b></td>
									<td><b>Длина</b></td>
									<td><b>Ширина</b></td>
									<td><b>Кол-во</b></td>
								</tr>
								<?php foreach ($block_door->get_elem_list('other') as $elem):?>
									<tr>
										<td><?=$this->project_data['door_elements'][$elem['type']]?></td>
										<td><?=$elem['length']?></td>
										<td><?=$elem['width']?></td>
										<td><?=$elem['count']?></td>
									</tr>
								<?php endforeach?>
							</tbody>	
						</table>
					</td>
				</tr>
			</table>
			<br/>
	<?php endforeach;?>
	<?php
	$elem_values = $material_values = array();
	foreach ($elements_list as $elem) {
		$elem_values[] = array(
			'type'=>$elem->type,
			'length'=>$elem->get_length(),
			'width'=>$elem->get_width(),
		);
		$material_values = array_merge($material_values, $elem->get_materials());
	}

	/* группировка по уникальным значениям */
	$total_elem = $total_materials = array();
	// сначала создаем массив уникальных значений для элементов
	foreach ($elem_values as $value) {
		if (!in_array($value, $total_elem))
			$total_elem[] = $value;
			
	}
	foreach ($total_elem as $key=>$value) {
		$count = array_keys($elem_values, $value);
		$total_elem[$key]['count'] = count($count);
	}
	// а теперь массив для материалов
	foreach ($material_values as $value) {
		if (!in_array($value, $total_materials))
			$total_materials[] = $value;
			
	}
	foreach ($total_materials as $key=>$value) {
		$count = array_keys($material_values, $value);
		$total_materials[$key]['count'] = count($count);
	}

	$sort_arr = function ($a, $b){	// алгоритм сортировки массива
		if ($a['type'] === $b['type']) {
			if ($a['length'] === $b['length']){
				if ($a['width'] === $b['width'])
					return 0;
				elseif ($a['width'] > $b['width'])
					return -1;
				else return 1;
			} elseif ($a['length'] > $b['length'])
				return -1;
			else return 1;
		} elseif ($a['type'] > $b['type'])
			return 1;
		else return -1;
	};
	usort($total_elem, $sort_arr);
	usort($total_materials, $sort_arr);
	$costs_material = array_fill_keys(array_unique(array_column($total_materials, 'type')),0);
	foreach ($total_materials as $each) {
		$costs_material[$each['type']] += $each['value'] * $each['count'];
	}
	// добавляем лак и клей в материалы
	if (isset($costs_material['veneer'])){
		$costs_material['lacquer'] = $costs_material['veneer'] * 0.2;
		if (isset($costs_material['wood'])){
			$costs_material['glue'] = ($costs_material['wood'] * 100 + $costs_material['veneer']) * 0.2;
		}
	}
	// общая стоимость материалов
	$total_cost = 0;
	?>
	<table class="spec_table" rules="all">
		<thead>
			<tr>
				<th colspan="4">Экспликация заказа</th>
			</tr>
			
		</thead>
		<tbody>
			<tr>
				<th colspan="4">Элементы полотна двери</th>
			</tr>
			<tr>
				<th>Наименование</th>
				<th>Длина</th>
				<th>Ширина</th>
				<th>Количество</th>
			<?php foreach($total_elem as $each):?>
				<tr>
					<td><?=$this->project_data['door_elements'][$each['type']]?></td>
					<td><?=$each['length']?></td>
					<td><?=$each['width']?></td>
					<td><?=$each['count']?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<th colspan="4">Материалы для элементов двери</th>
			</tr>
			<tr>
				<th>Наименование</th>
				<th>Длина</th>
				<th>Ширина</th>
				<th>Количество</th>
			</tr>
			<?php foreach($total_materials as $each):?>
				<tr>
					<td><?=$this->project_data['materials_array'][$each['type']]['type'].($each['type'] === 'wood' ?  ', '.$each['depth'].'мм': '')?></td>
					<td><?=$each['length']?></td>
					<td><?=$each['width']?></td>
					<td><?=$each['count']?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<th colspan="4">Смета по расходу материала</th>
			</tr>
			<tr>
				<th>Наименование</th>
				<th>Значение</th>
				<th>Стоимость</th>
				<th>Сумма</th>
			</tr>
			<?php foreach($costs_material as $name=>$value):?>
				<?php $total_cost += $this->project_data['materials_array'][$name]['price'] * $value?>
				<tr>
					<td><?=$this->project_data['materials_array'][$name]['type']?></td>
					<td><?=number_format($value, 2, '.', ' ').' '.$this->project_data['materials_array'][$name]['tag']?></td>
					<td><?=number_format($this->project_data['materials_array'][$name]['price'], 2, '.', ' ')?></td>
					<td><?=number_format($this->project_data['materials_array'][$name]['price'] * $value, 2, '.', ' ')?></td>
				</tr>

			<?php endforeach;?>
			<tr>
				<th colspan="3" align="right"><b>Итого</b></th>
				<th><?=number_format($total_cost, 2, '.', ' ');?></th>
			</tr>
		</tbody>
	</table>
	<br>
</div>