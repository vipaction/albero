<?php
class View
{
	function generate($content, $data=null, $addition=null){
		include('data/constants.php');
		include('code/views/template_view.php');
	}
}