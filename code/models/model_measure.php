<?php
class Model_measure extends Model
{
	public function measure($id){
		$data = $this->measure_list($id);
		return $data;
	}

	//Output measured doors list
	public function measure_list($id){
		$content_select = array(
			'door_type'=>array('межкомнатная', 'входная', 'фальшкоробка', 'двухстворчатая', 'раздвижная', 'другое'),
			'door_openning'=>array('левое', 'правое'),
			'door_handle'=>array('обычная', 'с фиксатором', 'с ключом'));
		$fields_keys = array(
			'door_type',
			'section_width',
			'section_height',
			'section_thickness',
			'block_width',
			'block_height',
			'block_add',
			'door_openning',
			'door_handle',
			'door_jamb',
			'door_step',
			'cut_section',
			'cut_block',
			'cut_door');
		
		$list_values = $this->base->db()->query("SELECT mc.rowid,mc.* FROM measure_content AS mc INNER JOIN measure AS m ON mc.id_measure=m.rowid WHERE m.rowid=$id");
		$data = array();
		while ($content = $list_values->fetchArray(SQLITE3_ASSOC)) {
			$data[]=$content;
		}

		$client_info = new Client_info;
		$addition = $client_info->getInfo($id); //change it value to client id!!
		return array($data, $addition);

	}

	// Create form to measure of single door.
	public function measure_form($id){
		$form = new Form;
		$content_form = array(
			'Размеры проема'=>array(
				array(
					'name'=>'section_width',
					'value'=>'ширина',
					'type'=>'Input',
					'size'=>5),
				array(
					'name'=>'section_height',
					'value'=>'высота',
					'type'=>'Input',
					'size'=>5),
				array(
					'name'=>'section_thickness',
					'value'=>'толщина',
					'type'=>'Input',
					'size'=>5)),
			'Размеры блока'=>array(
				array(
					'name'=>'block_width',
					'value'=>'ширина',
					'type'=>'Input',
					'size'=>5),
				array(
					'name'=>'block_height',
					'value'=>'высота',
					'type'=>'Input',
					'size'=>5),
				array(
					'name'=>'block_add',
					'value'=>'толщина',
					'type'=>'Input',
					'size'=>5)),
			'Описание двери'=>array(
				array(
					'name'=>'door_type',
					'value'=>'тип двери',
					'type'=>'Select',
					'list'=>array('', 'межкомнатная', 'входная', 'фальшкоробка', 'двухстворчатая', 'раздвижная', 'другое'),
					'size'=>1),
				array(
					'name'=>'door_openning',
					'value'=>'открывание',
					'type'=>'Select',
					'list'=>array('', 'левое', 'правое'),
					'size'=>1),
				array(
					'name'=>'door_handle',
					'value'=>'тип ручки',
					'type'=>'Select',
					'list'=>array('', 'обычная', 'с фиксатором', 'с ключом'),
					'size'=>1),
				array(
					'name'=>'door_jamb',
					'value'=>'количество наличников',
					'type'=>'Input',
					'size'=>3),
				array(
					'name'=>'door_step',
					'value'=>'порог',
					'type'=>'Checkbox',
					'size'=>NULL)),
			'Дополнительно'=>array(
				array(
					'name'=>'door_type',
					'value'=>'тип двери',
					'type'=>'Checkbox',
					'size'=>NULL),
				array(
					'name'=>'door_jamb',
					'value'=>'количество наличников',
					'type'=>'Checkbox',
					'size'=>NULL),
				array(
					'name'=>'door_step',
					'value'=>'порог',
					'type'=>'Checkbox',
					'size'=>NULL))
			);
		$current_values=$this->base->db()->querySingle("SELECT rowid, * FROM measure_content WHERE id_measure=$id",true);
		$data = array();
		foreach ($content_form as $key => $value) {
			foreach ($value as $content) {
				$method = 'create'.$content['type'].'Field';
				$current = isset($current_values[$content['name']]) ? $current_values[$content['name']] : '';
				if ($content['type'] == 'Select') 
					$data[$key][$content['value']] = $form->$method($content['name'], $current , $content['list'], $content['size']);
				else 
					$data[$key][$content['value']] = $form->$method($content['name'], $current , $content['size']);
			}
		}
		return $data;
	}	
}