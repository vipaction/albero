<?php
class Model 
{
	public $base;
	public $data;
	
	function __construct(){
		$this->base = new SQLite3('base.db');
	}
}
