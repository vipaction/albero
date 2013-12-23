<?php
class Model 
{
	public $base;
	public $door_type = array('межкомнатная', 'входная', 'фальшкоробка', 'двухстворчатая', 'раздвижная', 'другое'),
			$door_openning = array('левое', 'правое'),
			$door_handle = array('обычная', 'с фиксатором', 'с ключом'),
			$room_type = array('кухня', 'зал', 'санузел', 'туалет', 'спальня', 'детская', 'коридор', 'холл', 'прихожая', 'кладовая', 'другое');


	function __construct(){
		$this->base = new SQLite3('base.db');
	}
}
