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

		// If choose 'add new row' then output array will $_POST data + row with empty values
		if (isset($_POST['add_new'])){		
			$rows = $_POST['add_new']+1; // 'add_new' return number of rows of existing form
			unset($_POST['add_new']);
			for ($i = 1; $i <= $rows ; $i++) { 
				$content = array_fill_keys($fields_keys, null); // for empty measure create array with empty values for each key
				foreach ($_POST as $key => $value) {
					if (isset($value[$i])){
						$content[$key] = $value[$i];
					}
				}
				$this->data['content']['measurement'][] = $content;
			}
		} else {	

			// For usualy output get data from DBase
			$list_values = $this->base->query("SELECT $fields_select FROM measure_content WHERE id_task=$id_task");
			while ($content = $list_values->fetchArray(SQLITE3_ASSOC)) {
				$this->data['content']['measurement'][] = $content;
			} 
		}
		//get images and thumbnails from images/task_{{$id_task}}/
		$img_path = "images/task_$id_task/";
		$this->data['content']['thumbs'] = glob($img_path."thumb_*.jpg");
		$this->data['content']['images'] = glob($img_path."orig_*.jpg");
		//get comment and header info
		$this->get_header_info($id_task);
		$this->data['content']['comment'] = $this->base->querySingle("SELECT comment FROM measure WHERE id_task=$id_task");
		return $this->data;

	}

	
	function save_measure_data($id_task){
		$form_data = $_POST;

		// clear all measure data before save new
		$this->base->exec("DELETE FROM measure WHERE id_task=$id_task; DELETE FROM measure_content WHERE id_task=$id_task");

		//Check choosen images and comments for delete
		if (isset($form_data['del_img'])){
			$img_list = array_keys($form_data['del_img']); // list of images for delete
			unset($form_data['del_img']);
			foreach ($img_list as $thumb_path) {
				$orig_path = str_replace('thumb_', 'orig_', $thumb_path);
				unlink($thumb_path);
				unlink($orig_path);
			}
		}

		// Save comment if not choose delete.
		if (!isset($form_data['del_txt'])){
			$this->base->exec("INSERT INTO measure (id_task, comment) VALUES ($id_task, '{$form_data['comment']}')");
		} else
			unset($form_data['del_txt']);
		unset($form_data['comment']); //clear data fields - must stay only measure_content fields

		// Previous save image in measure table
		$this->save_image($id_task);

		$form_keys = array_keys($form_data);
		$rows = max(array_map('count', $form_data)); // depth of array _POST

		for ($i = 1; $i <= $rows ; $i++) { 
			$data_content = array();
			foreach ($form_keys as $key ) {
				if (isset($form_data[$key][$i])) $data_content[$key]=$form_data[$key][$i];
			}
			if (!array_key_exists('delete', $data_content)){
				$data_keys = implode(', ',array_keys($data_content));
				$data_values = "'".implode("', '", array_values($data_content))."'";
				$this->base->exec("INSERT INTO measure_content (id_task, $data_keys) VALUES ($id_task, $data_values)");
			}
		}
	}

	function create_thumbnail($img_path, $path, $img_name){
		$new_width = 200;
		$img_size = getimagesize($img_path);
		$new_height = (int) floor($img_size[1]/($img_size[0]/$new_width));
  		$blank_img = imagecreatetruecolor($new_width, $new_height);
  		$true_img = imagecreatefromjpeg($img_path);
  		imagefill($blank_img, 0, 0, 0xFFFFFF);
  		imagecopyresampled($blank_img, $true_img, 0, 0, 0, 0, $new_width, $new_height, $img_size[0], $img_size[1]);
  		imagejpeg($blank_img, $path.'/thumb_'.$img_name);
  		imagedestroy($blank_img);
  		imagedestroy($true_img);
	}

	function save_image($id_task){
		$path = 'images/task_'.$id_task;
		if (!is_dir($path)){
			mkdir($path, 0777);
		}
		if (isset($_FILES['photo'])) {
			$upload_file = $_FILES['photo'];
			$img_path = $path.'/orig_'.$upload_file['name'];
			$img_orig = getimagesize($upload_file['tmp_name']);
			if ($img_orig['mime'] == 'image/jpeg') {
				if (!move_uploaded_file($upload_file['tmp_name'], $img_path)) 
					return;
				$this->create_thumbnail($img_path, $path, $upload_file['name']);
			}
		}
	}
}