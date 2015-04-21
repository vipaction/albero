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
		<?php endforeach;?>
	</table>
	<div><a href="/spec/load/<?=$this->data['id_task']?>">Скачать файл для раскроя</a></div>
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
							<?=$this->data['model_name'][$block_door->get_model_name()].'('.$block_door->get_model_name().')'?>
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
									<td><b>Размер</b></td>
									<td><b>Кол-во</b></td>
									<td><b>Состав</b></td>
								</tr>
								<?php foreach ($block_door->get_elem_list('main') as $elem):?>
									<tr>
										<td><?=$this->data['elem_name'][$elem['type']]['content']?></td>
										<td><?=$elem['length'].'*'.$elem['width']?></td>
										<td><?=$elem['count']?></td>
										<td>
											<?php $names_array = array('wood', 'mdf_3', 'mdf_10', 'mdf_12', 'mdf_16', 'veneer');
											foreach ($elem['materials'] as $em){
												if (in_array($em['type'], $names_array)){
													if ($em['type'] === 'wood')
														echo $this->data['material_name'][$em['type']]['content'].': '.$em['width'].'*'.$em['length'].'*'.$em['depth'].'-'.$em['count']*$elem['count'].'шт.<br/>';
													else
														echo $this->data['material_name'][$em['type']]['content'].': '.$em['width'].'*'.$em['length'].'-'.$em['count']*$elem['count'].'шт.<br/>';
												}
											}?>
										</td>	
									</tr>
								<?php endforeach?>
								<th colspan="4">Дополнительные элементы</th>
								<tr>
									<td><b>Наименование</b></td>
									<td><b>Размер</b></td>
									<td><b>Кол-во</b></td>
									<td><b>Состав</b></td>
								</tr>
								<?php foreach ($block_door->get_elem_list('other') as $elem):?>
									<tr>
										<td><?=$this->data['elem_name'][$elem['type']]['content']?></td>
										<td><?=$elem['length'].'*'.$elem['width']?></td>
										<td><?=$elem['count']?></td>
										<td>
											<?php
											foreach ($elem['materials'] as $em){
												if (in_array($em['type'], $names_array)){
													if ($em['type'] === 'wood')
														echo $this->data['material_name'][$em['type']]['content'].': '.$em['width'].'*'.$em['length'].'*'.$em['depth'].'-'.$em['count']*$elem['count'].'шт.<br/>';
													else
														echo $this->data['material_name'][$em['type']]['content'].': '.$em['width'].'*'.$em['length'].'-'.$em['count']*$elem['count'].'шт.<br/>';
												}
											}?>
										</td>
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
	$names_material = array_map(function($arg){return $arg['type'];},$total_materials);
	$costs_material = array_fill_keys(array_unique($names_material),0);
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
					<td><?=$this->data['elem_name'][$each['type']]['content']?></td>
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
			<?php 
			// xml writer
			$xml_dom = new DomDocument('1.0', 'utf-8');
			$xml_data = $xml_dom->appendChild($xml_dom->createElement('data'));
			$xml_data_order = $xml_data->appendChild($xml_dom->createElement('data_order'));
			$xml_data_sheet = $xml_data->appendChild($xml_dom->createElement('data_sheet'));
			$xml_data_order->setAttribute('name', 'Заказ №'.$this->data['id_task']);
			$xml_list_materials = $xml_data_order->appendChild($xml_dom->createElement('list_materials'));
			$xml_sheet_list_materials = $xml_data_sheet->appendChild($xml_dom->createElement('list_materials'));
			$material_type = '';
			foreach($total_materials as $each):
				if(!in_array($each['type'], array('wood','glass','triplex'))){
					if ($material_type !== $this->data['material_name'][$each['type']]['content']){
						$xml_material = $xml_list_materials->appendChild($xml_dom->createElement('material'));
						$xml_sheet_material = $xml_sheet_list_materials->appendChild($xml_dom->createElement('material'));
						$material_type = $this->data['material_name'][$each['type']]['content'];
						$xml_material->setAttribute('name', $material_type);
						$xml_sheet_material->setAttribute('name', $material_type);
						$xml_sheet_material->setAttribute('sheet_border', '0;0;0;0');
						$xml_list_sheets = $xml_sheet_material->appendChild($xml_dom->createElement('list_sheets')); 
						$xml_sheet = $xml_list_sheets->appendChild($xml_dom->createElement('sheet'));
						if ($each['type'] === 'veneer') { 
							$xml_sheet->setAttribute('width', $this->data['door_param']['veneer_width']['value']);
							$xml_sheet->setAttribute('length', $this->data['door_param']['veneer_length']['value']);
							$xml_sheet_material->setAttribute('wid_cut', '0');	
						} else {
							$xml_sheet->setAttribute('width', $this->data['door_param']['mdf_width']['value']);
							$xml_sheet->setAttribute('length', $this->data['door_param']['mdf_length']['value']);
						}
						$xml_sheet->setAttribute('thick','10.0');
						$xml_sheet->setAttribute('quantity', '100');
						//$xml_sheet->setAttribute('fibre','3');
						$xml_list_parts = $xml_material->appendChild($xml_dom->createElement('list_parts'));
					}
					$xml_part = $xml_list_parts->appendChild($xml_dom->createElement('part'));
					$xml_part->setAttribute('width', $each['width']);
					$xml_part->setAttribute('length', $each['length']);
					$xml_part->setAttribute('thick','10.0');
					//$xml_part->setAttribute('fibre','3');
					$xml_part->setAttribute('quantity', $each['count']);
				}
				?>
				<tr>
					<td><?=$this->data['material_name'][$each['type']]['content'].($each['type'] === 'wood' ?  ', '.$each['depth'].'мм': '')?></td>
					<td><?=$each['length']?></td>
					<td><?=$each['width']?></td>
					<td><?=$each['count']?></td>
				</tr>
			<?php endforeach;
			$xml_dom->formatOutput = true;
			$xml_dom->save('spec/spec_'.$this->data['id_task'].'.xml');
			?>
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
				<?php $total_cost += $this->data['material_name'][$name]['price'] * $value?>
				<tr>
					<td><?=$this->data['material_name'][$name]['content']?></td>
					<td><?=number_format($value, 2, '.', ' ').' '.$this->data['material_name'][$name]['tag']?></td>
					<td><?=number_format($this->data['material_name'][$name]['price'], 2, '.', ' ')?></td>
					<td><?=number_format($this->data['material_name'][$name]['price'] * $value, 2, '.', ' ')?></td>
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