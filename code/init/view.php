<?php
class View
{
	function generate($content, $header=null, $data=null){
		include('data/constants.php');
		include('code/views/template_view.php');
	}
}