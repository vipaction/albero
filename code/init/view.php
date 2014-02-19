<?php
class View
{
	function generate($content, $data=null, $addition=null){
		include('data/constants.php');
		include('code/views/template_view.php');
	}

	function generate_task($view_file, $id_task, $data=null){
		include('data/constants.php');
		include('code/views/template_task_view.php');
	}
}