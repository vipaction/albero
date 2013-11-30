<?php
class Model_measure extends Model
{
	/*
		Methods:
			get_data - get client's info, list of measured doors, comments and attached image
			measure_form - get form to edit or create measure 
			save_measure_data - save data of single measure to database
			save_image - save or update image in database
	*/

	function get_data($id_task){
		$content_select = array(
			'door_type'=>array('межкомнатная', 'входная', 'фальшкоробка', 'двухстворчатая', 'раздвижная', 'другое'),
			'door_openning'=>array('левое', 'правое'),
			'door_handle'=>array('обычная', 'с фиксатором', 'с ключом'),
			'room_type'=>array('кухня', 'зал', 'санузел', 'туалет', 'спальня', 'детская', 'коридор', 'холл', 'прихожая', 'кладовая', 'другое'));

		// Array with optimal position of fields
		$fields_keys = array(
			'room_type',
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

		$fields_select = implode(",", $fields_keys);
		
		$list_values = $this->base->query("SELECT mc.rowid, $fields_select FROM measure_content AS mc INNER JOIN measure ON mc.id_measure=measure.rowid WHERE measure.id_task=$id_task");
		$data = array();
		while ($content = $list_values->fetchArray(SQLITE3_ASSOC)) {
			if (!empty($content)) 
				$id_form = array_shift($content);
			else
				$id_form = '';
			foreach ($content_select as $key => $value) {
				
				// change values of select field to russian value
				if (!is_null($content[$key])) 
					$content[$key]=$value[$content[$key]-1];
			}
			foreach ($content as $key => $value) {
				if (is_null($value)) $content[$key] = '';
				if (in_array($key, array('door_step', 'cut_section', 'cut_block', 'cut_door')) && $content[$key] !='') {
					$content[$key]='x';
				}
			}
			$data[$id_form]=$content;
		} 

		$returned['measurement']=$data;

		// get client info
		$client = new Client_info;
		$returned['client'] = $client->getInfo($id_task);			

		//get image name
		$addition = $this->base->querySingle("SELECT photo, comment FROM measure WHERE id_task='$id_task'", true);
		if ($addition['photo'] !== '') {
			$returned['image']=$addition['photo'];
		}

		//get comment
		if ($addition['comment'] !== '') {
			$returned['comment']=$addition['comment'];
		}

		return $returned;

	}

	function measure_form($id_form=''){
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
			'Размеры дверного блока'=>array(
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
					'value'=>'расширитель',
					'type'=>'Input',
					'size'=>5)),
			'Описание двери'=>array(
				array(
					'name'=>'room_type',
					'value'=>'комната',
					'type'=>'Select',
					'list'=>array('', 'кухня', 'зал', 'санузел', 'туалет', 'спальня', 'детская', 'коридор', 'холл', 'прихожая', 'кладовая', 'другое'),
					'size'=>1),
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
					'name'=>'cut_section',
					'value'=>'расширение проема',
					'type'=>'Checkbox',
					'size'=>NULL),
				array(
					'name'=>'cut_block',
					'value'=>'подрезка полотна',
					'type'=>'Checkbox',
					'size'=>NULL),
				array(
					'name'=>'cut_door',
					'value'=>'врезка элементов',
					'type'=>'Checkbox',
					'size'=>NULL))
			);
		if($id_form !== "") {
			setcookie('id_form',$id_form, 0, '/');

			$current_values=$this->base->querySingle("SELECT * FROM measure_content WHERE rowid=$id_form",true);
		}
		$data = array();
		
		// create form measure use 'form' class
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

	function save_measure_data($id_task){
		$form_data = $_POST;

		// 'send' - is a button value and don't need in next step
		unset($form_data['send']);

		// filter empty fields of form
		$form_data = array_filter($form_data);

		// add value of id_measure to table's content
		$id_measure = $this->base->querySingle("SELECT rowid FROM measure WHERE id_task='$id_task'");

		// insert measure to 'measure' table if not exists
		if ($id_measure == '') {
			$this->base->exec("INSERT INTO measure (id_task) VALUES ($id_task)");
			$id_measure = $this->base->lastInsertRowID();
		}
		$form_data['id_measure'] = $id_measure;

		// for isset form data use 'update' values in database, for new form use 'insert'
		if (isset($_COOKIE['id_form'])){
    		$id_form = $_COOKIE['id_form'];
    		foreach ($form_data as $key => $value) {
				$form_values[] = $key."='".$value."'";
			}
			$form_set = implode(",", $form_values);

			// clear old values from current row
			$form_names = $this->base->query("SELECT * FROM measure_content WHERE rowid=$id_form");
			$cols = $form_names->numColumns();

			// get name since second column (first column is id_task which can't be null)
			for ($i=1; $i<$cols ; $i++) { 
				$form_clear[] = $form_names->columnName($i)."=NULL";
			}
			$form_clear_str = implode(", ", $form_clear);
			$this->base->exec("UPDATE measure_content SET $form_clear_str WHERE rowid=$id_form");

			// save new values to current row
    		$this->base->exec("UPDATE measure_content SET $form_set WHERE rowid=$id_form");
		} else {
			$form_set = implode(",", array_keys($form_data));
			$form_values = "'".implode("','", array_values($form_data))."'";
			$this->base->exec("INSERT INTO measure_content ($form_set) VALUES ($form_values)");
		}
	}

	function save_image($id_task){
		// upload file to 'images' folder like img_{{ id_task }}.{{ extention }}
		$upload_file = $_FILES['photo'];
        $img_name = 'img_'.$id_task.strrchr($upload_file['name'], '.');
        if (!move_uploaded_file($upload_file['tmp_name'], 'images/'.$img_name)) {
          return;
        }

        $id_measure = $this->base->querySingle("SELECT rowid FROM measure WHERE id_task='$id_task'");

		// insert measure to 'measure' table if not exists
		if ($id_measure == '') {
			$this->base->exec("INSERT INTO measure (id_task) VALUES ($id_task)");
			$id_measure = $this->base->lastInsertRowID();
		}

		$this->base->exec("UPDATE measure SET photo='$img_name' WHERE rowid=$id_measure");
	}

	function save_comment($id_task){
		$comment = $_POST['comment'];
		$id_measure = $this->base->querySingle("SELECT rowid FROM measure WHERE id_task='$id_task'");

		// insert measure to 'measure' table if not exists
		if ($id_measure == '') {
			$this->base->exec("INSERT INTO measure (id_task) VALUES ($id_task)");
			$id_measure = $this->base->lastInsertRowID();
		}

		$this->base->exec("UPDATE measure SET comment='$comment' WHERE rowid=$id_measure");
	}
}