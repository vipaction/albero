<?php
class View
{
	public function generate($content, $template, $data=null, $addition=null){
		
		include('code/views/'.$template);
	}
}