<?php 
	foreach ($addition as $value=> $content) {
		echo "<div><b>$value :</b> $content</div>";
	}
?>
<hr>

<form method='post'>
	<table border="1" cellspacing="0" cellpadding="2">
		<tr>
			<th colspan="2">Дверь</th>
			<th colspan="3">Проем</th>
			<th colspan="3">Блок</th>
			<th colspan="3">Особенности</th>
			<th colspan="4">Дополнительно</th>
			<th rowspan="2">Действия</th>
		</tr>
		<tr>
			<th>№</th>
			<th>тип</th>
			<th>ширина</th>
			<th>высота</th>
			<th>толщина</th>
			<th>ширина</th>
			<th>высота</th>
			<th>расширитель</th>
			<th>открывание</th>
			<th>ручка</th>
			<th>наличник</th>
			<th>порог</th>
			<th>расширение</th>
			<th>подрезка</th>
			<th>врезка</th>
		</tr>

	</table>
	<?php
		foreach ($data as $key => $value) {
			echo $key.'_'.$value;
		}
	?>	
	
</form>