<?php foreach ($addition as $value=> $content): ?>
	<div>
		<b>
			<?php echo $value.' :'; ?>
		</b> 
		<?php echo $content; ?>
	</div>
<?php endforeach; ?>
<hr>

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
		<th>тип двери</th>
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
	<?php 
	$i = 1;
	foreach ($data as $value): ?>	
		<tr>
			<td>
				<?php echo $i++; ?>
			</td>
			<?php foreach ($value as $content): ?>
				<td>
					<?php echo $content; ?>
				</td>
			<?php endforeach; ?> 
		</tr>
	<?php endforeach;?>
</table> 
<form method="post" action="/measure/measure_form/">
	<button>Добавить проем</button>
</form>
