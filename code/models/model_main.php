<?php
class Model_main extends Model
{
	public function get_data() // return list of tasks or empty message
	{
		$records = $this->base->query('SELECT rowid, id_client FROM tasks');
		$result_list = array();
		while ($content = $records->fetchArray(SQLITE3_ASSOC)) {
			$dbquery = "SELECT c.last_name, c.first_name, c.second_name, c.address, c.phone, t.rowid, tsn.name, tsn.value 
						FROM clients AS c
						INNER JOIN tasks AS t
						ON c.rowid=t.id_client
						INNER JOIN task_status AS ts
						ON ts.id_task=t.rowid
						INNER JOIN task_status_names AS tsn
						ON tsn.rowid=ts.status 
						WHERE c.rowid={$content['id_client']} AND t.rowid={$content['rowid']}
						ORDER BY ts.status
						";
			$result = $this->base->querySingle($dbquery, true);
			$client_name = $result['last_name'].' '.$result['first_name'].' '.$result['second_name'];
			$result_list[] = "<a href='../{$result['name']}/index/{$result['rowid']}'>
								<div>
									<div>{$client_name}</div>
									<div>{$result['address']}</div>
									<div>{$result['phone']}</div>
									<div>{$result['value']}</div>
								</div>
							  </a>";
		}
		return empty($result_list) ? array('Нет заявок') : $result_list;
	}
}