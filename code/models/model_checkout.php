<?php
class Model_checkout extends Model
{
	/*
	Methods:
		get_list - get list of measured doors for checkout
	*/
	function get_measure_data($id_task){
		$measure = $this->base->query("SELECT mc.rowid, *
										FROM measure_content AS mc 
										INNER JOIN measure ON mc.id_measure=measure.rowid 
										WHERE measure.id_task=$id_task");
		while ($measure_content = $measure->fetchArray(SQLITE3_ASSOC)) {
			var_dump($measure_content, '<br>');
		}
		
	}

	function get_list($id_task){
		$this->get_measure_data($id_task);
		return;
	}
}