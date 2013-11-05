<?php
class Model_main extends Model
{
	public function get_data() // return list of tasks or empty message
	{
		$records = $this->base->query('SELECT id_client FROM tasks');
		$result = array();
		while ($content = $records->fetchArray(SQLITE3_ASSOC)) {
			$result[] = $this->base->querySingle("SELECT last_name, first_name, second_name, address, phone FROM clients 
													 WHERE rowid={$content['id_client']}", true);
		}
		return empty($result) ? 'Нет заявок' : $result;
	}
}