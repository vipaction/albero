<?php
class Model 
{
	public $base;

	public function __construct(){
		$this->base = new SQLite3('base.db');
	}
}
