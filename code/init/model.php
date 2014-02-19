<?php
class Model 
{
	public $base;
	
	function __construct(){
		$this->base = new SQLite3('base.db');
	}
}
