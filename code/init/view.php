<?php
class Form{ 
/* Common functions which used to create any form in views*/
	function createInputField($name, $current_value, $size = 20){
		return "<input type='text' name='$name' value='$current_value' size=$size>";
	}

	function createSelectField($name, $current_value, $list_value, $size = 3){
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

class View
{
	function generate($content, $header=null, $data=null){
		include('data/constants.php');
		include('code/views/template_view.php');
	}
}