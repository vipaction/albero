<h2>Оформление заказа</h2>
<hr>
<form>
	<table>
		<tr>
			<th></th>
			<th>Комната</th>
			<th>тип двери</th>
			<th>размеры проема</th>
		</tr>
		<?php foreach ($data['list'] as $id_door => $content): ?>
			<tr>
				<td>
					<input type="button" value="Выбрать" name="door_<?php echo $id_door; ?>">
				</td>
				<?php foreach ($content as $column): ?>
					<td>
						<?php echo $column; ?>
					</td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	</table>
</form>
<script src="/data/doors_data.js"></script>
