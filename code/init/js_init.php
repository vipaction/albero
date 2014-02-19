<?php
	if (!file_exists("data/items_tech.js")){
		$js_tech=fopen("data/items_tech.js","w+");
		$js_file_content = "";
		$js_file_content .= "var doors_models_names = { \n";
		foreach ($doors_models_names as $type => $value) {
			if (is_array($value)) {
				$js_file_content .= "\t'$type': { \n";
				foreach ($value as $fabric => $models) {
					if (is_array($models)) {
						$js_file_content .= "\t\t'$fabric': [";
							foreach ($models as $model) {
								$js_file_content .= "'$model',";
							}
						$js_file_content .= "], \n";
					} else {
						$js_file_content .= "\t\t '$models': '', \n";
					}
				}
				$js_file_content .= "\t } \n";
			}
		}
		$js_file_content .= "}";
		fwrite($js_tech, $js_file_content);
		fclose($js_tech);
	}