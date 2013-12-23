<?php
class Steel {
	public $list;

	function __construct(){
		$steel_handler = fopen("mills/steel.csv", "r");
		while ($row = fgetcsv($steel_handler)) {
			$this->list[]= array('fabric' => $row[0], 'models' => explode(',', $row[1]));
		}
		fclose($steel_handler);
	}
}

class Model_fill extends Model
{

	/*
		Methods:
	*/

	function get_data(){
		$steel_doors = new Steel;
		$js_handler = fopen("data/doors_data.js", "w");
		$js_str = "var doors = { \n type: 'steel_doors', \n fabric: { \n";

		foreach ($steel_doors->list as $door) {
			$js_str .= "  '{$door['fabric']}': ['".implode("', '", $door['models'])."'], \n";
		}
		$js_str .= " }\n} \n alert(doors.fabric['Lacossta'][2]);";
		fwrite($js_handler, $js_str);
		fclose($js_handler);
	}
}