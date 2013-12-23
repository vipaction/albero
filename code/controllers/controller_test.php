<?php
	class Controller_test extends Controller {

	/*
		Methods:
			_index - get list of unclosed tasks
	*/

	
    
    function action_index()
    {	
    	$old = new SQLite3('base.db');
    	$array = $old->query("SELECT rowid, id_task FROM measure");
    	while ($query = $array->fetchArray(SQLITE3_ASSOC)) {
    		echo $query['rowid'].' '.$query['id_task'].'<br>';
    		$old->exec("UPDATE measure_content SET id_measure='{$query['rowid']}' WHERE id_task='{$query['id_task']}'");
    	}
    	
    }
}