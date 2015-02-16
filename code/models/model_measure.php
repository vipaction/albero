<?php
class Model_measure extends Model{
	function __construct($id_task){ /* Get info about task and client*/
		parent::__construct();
		$info = new Info;
        $this->data = array(
            'header' => array(
                'client_info' => $info->get_client_info($id_task),
                'status_info' => $info->get_status_info($id_task)),
            'id_task' => $id_task);
	}
	/*
		Methods:
			get_data - get client's info, list of measured doors, comments and attached image
			measure_form - get form to edit or create measure 
			save_measure_data - save data of single measure to database
			save_image - save or update image in database
	*/

	function get_data($id_task){
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
		while ($content = $list_values->fetchArray(SQLITE3_ASSOC)) {
			if (!empty($content)) 
				$id_form = array_shift($content);
			else
				$id_form = '';
			
			foreach ($content as $key => $value) {
				if (is_null($value)) $content[$key] = '';
				if (in_array($key, array('door_step', 'cut_section', 'cut_block', 'cut_door')) && $content[$key] !='') {
					$content[$key]='✔';
				}
			}
			$this->data['content']['measurement'][$id_form]=$content;
		} 

		//get image name
		$addition = $this->base->querySingle("SELECT photo, comment FROM measure WHERE id_task='$id_task'", true);
		if (isset($addition['photo'])) {
			$this->data['content']['image']=$addition['photo'];
		}

		//get comment
		if (isset($addition['comment'])) {
			$this->data['content']['comment']=$addition['comment'];
		}

		return $this->data;

	}

	function measure_form($id_form=''){
		// get names of fields of measure
		$fields_all = $this->base->query("PRAGMA table_info(measure_content)");
		while ($fields = $fields_all->fetchArray(SQLITE3_ASSOC)){
			$fields_name[]=$fields['name'];
		}

		// at start fields are empty, but not for editing form
		$data = array_fill_keys($fields_name, null);
		if($id_form !== "") {
			$current_values=$this->base->querySingle("SELECT * FROM measure_content WHERE rowid=$id_form",true);
			foreach ($current_values as $key => $value) {
				$data[$key]=$value;
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