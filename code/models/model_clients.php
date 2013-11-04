<?php
class Model_clients extends Model
{
	public function get_data()
	{
		$result=$this->base->db()->querySingle('SELECT * FROM clients', true);
		return !empty($result) ? $result : 'Нет записей';
	}
}