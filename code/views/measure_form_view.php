<form method='post'>
	<?php 
		foreach ($data as $value=> $content) {
			echo "<fieldset><legend>$value</legend>";
			foreach ($content as $name => $param) {
				echo "<div>$name: $param</div>";
			}
			echo "</fieldset>";
		}
	?>
	
</form>