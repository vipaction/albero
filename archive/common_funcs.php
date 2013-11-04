<?php
	function mangrSelect(){
		global $db;
		$staff_types = array(1=>'Салон', 2=>'Монтажный отдел');
		$staff = $db -> query("SELECT * FROM staff");
		$staff_group=array();
		while ($staff_res = $staff -> fetchArray(SQLITE3_ASSOC)){
			$staff_type=$staff_res['type'];
			unset($staff_res['type']);
			$staff_group[$staff_type][]=$staff_res;
		}
		foreach ($staff_types as $key => $value) {
			echo "<optgroup label='$value'>";
				foreach ($staff_group[$key] as $staff_data) {
					echo "<option value='{$staff_data['id']}'>{$staff_data['last_name']} {$staff_data['first_name']}</option>";
				}
			echo "</optgroup>";
		}
		
	}
?>
