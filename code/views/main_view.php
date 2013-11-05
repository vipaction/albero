<div>
	<a href='../task/search'>Создать зявку</a>
	<a href='../clients/index'>Просмотр данных клиента</a>
</div>
<table>
	<tr>
		<th>Фамилия</th>
		<th>Имя</th>
		<th>Отчество</th>
		<th>Адрес</th>
		<th>Телефон</th>
		<th>Статус заявки</th>
	</tr>
<?php 
	if (is_array($data)){
		foreach ($data as $value) {
			echo '<tr>';
			foreach ($value as $content) {
				echo "<td>$content</td>";
			}
			echo '</tr>';
		}
	} else {
		echo $data;
	}
?>
</table>