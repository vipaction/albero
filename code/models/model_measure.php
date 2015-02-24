<?php
class Model_measure extends Model{
	/*
		Methods:
			get_content - get client's info, list of measured doors, comments and attached image
			save_measure_data - save data of measure to database
			save_image - save or update image in database
	*/

	function get_content($id_task){
		// Array with optimal position of fields
		$fields_keys = array('room_type','door_type','section_width','section_height','section_thickness','block_width','block_height','block_add','door_openning','door_handle','door_jamb','door_step','cut_section','cut_block','cut_door');
		$fields_select = implode(",", $fields_keys);
		
		$list_values = $this->base->query("SELECT $fields_select FROM measure_content WHERE id_task=$id_task");
		while ($content = $list_values->fetchArray(SQLITE3_ASSOC)) {
			$this->data['content']['measurement'][] = $content;
		} 

		//get image name
		$this->data['content']['addition'] = $this->get_data('id_task', $id_task, 'measure', array('photo', 'comment'));
		return $this->data;

	}

	
	function save_measure_data($id_task){
		$form_data = $_POST;
		$form_keys = array_keys($form_data);
		$rows = max(array_map('count', $form_data)); // depth of array _POST

		// clear all measure data before save new
		$this->base->exec("DELETE FROM measure WHERE id_task=$id_task; DELETE FROM measure_content WHERE id_task=$id_task");

		for ($i = 1; $i <= $rows ; $i++) { 
			$data_content = array();
			foreach ($form_keys as $key ) {
				if (isset($form_data[$key][$i])) $data_content[$key]=$form_data[$key][$i];
			}
			$data_keys = implode(', ',array_keys($data_content));
			$data_values = "'".implode("', '", array_values($data_content))."'";
			$this->base->exec("INSERT INTO measure_content (id_task, $data_keys) VALUES ($id_task, $data_values)");
		}
	}
/*
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
	*/
}