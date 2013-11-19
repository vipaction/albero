<?php
class Model_main extends Model
{
	function get_data() // return list of tasks or empty message
	{
		$dbquery = "SELECT c.address, c.phone, t.rowid, tsn.name, tsn.value
						FROM clients AS c
						INNER JOIN tasks AS t
						ON c.rowid=t.id_client
						INNER JOIN task_status AS ts
						ON ts.id_task=t.rowid
						INNER JOIN task_status_names AS tsn
						ON tsn.rowid=ts.status
						INNER JOIN (SELECT rowid, id_task, max(status) FROM task_status GROUP BY id_task) AS sel
						ON sel.rowid = ts.rowid
						ORDER BY tsn.name
						";
		$result = $this->base->query($dbquery);
		while ($content = $result->fetchArray(SQLITE3_ASSOC)) {
			$result_list[] = $content;
		}
		
		return empty($result_list) ? array(array('address'=>'','phone'=>'','rowid'=>'','name'=>'','value'=>'')) : $result_list;
	}
}