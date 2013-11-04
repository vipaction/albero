<?php
class Model_main extends Model
{
	public function get_data()
	{
		$result=$this->base->db()->querySingle('SELECT * FROM tasks', true);
		return !empty($result) ? $result : 'Нет записей';
	}
}