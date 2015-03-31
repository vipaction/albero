<?php
class Form{ 
/* Common functions which used to create any form in views*/
	function createInputField($name, $current_value, $required=""){
		return "<input type='text' name='$name' value='$current_value' $required>";
	}

	function createSelectField($name, $current_value, $list_value, $size=1){
		$to_string = "<select name='$name' size=$size>";
		foreach ($list_value as $value => $content) {
			$selected = ($value==$current_value) ? 'selected' : '';
			$is_value = ($value != '') ? "value=$value" : '';
			$to_string .= "<option $is_value $selected>$content</option>";
		}
		$to_string .= "</select>";
		return $to_string;
	}

	function createCheckboxField($name, $value = NULL){
		$checked = $value ? 'checked' : '';
		return "<input type='checkbox' name='$name' $checked value='1'>";
	}
}

class View{
	private function generate_main_menu($img){

	}

	private function generate_grid(){
		
	}

	function generate($content, $header=null, $data=null){
		include('data/constants.php');
		include('code/views/template_view.php');
	}
	function generate_spec($data){
		include('data/constants.php');
		include('code/views/template_spec_view.php');
	}
}