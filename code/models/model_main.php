<?php
class Model_main extends Model{

	/*
		Methods:
			get_data - return list of tasks or empty message
	*/

	function get_data($active='IS NULL' /* it's needed to getting active tasks or closed tasks*/){
		$condition = "";
		if (isset($_POST['search'])) {
			if ($_POST['sort'] != 'all')
				$condition .= " AND tsn.name='{$_POST['sort']}'";
			$condition .= " AND (c.phone LIKE '%{$_POST['search']}%' OR c.address LIKE '%{$_POST['search']}%')";
		}
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
						WHERE t.is_closed $active $condition
						ORDER BY tsn.rowid DESC, t.rowid DESC
						";
		$result = $this->base->query($dbquery);
		while ($content = $result->fetchArray(SQLITE3_ASSOC)) {
			$this->data['content'][] = $content;
		}
		if ($active == 'IS NULL') 
			$this->data['title'] = "Список заказов";
		else
			$this->data['title'] = "Архив заказов";
		return $this->data;
	}
}