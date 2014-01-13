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
					<input type="checkbox" name="door_<?php echo $id_door; ?>" onChange="chooseDoors(<?php echo $id_door; ?>)">
				</td>
				<td>
					<?php echo $room_type[$content['room_type']]; ?>
				</td>
				<td>
					<?php echo $door_type[$content['door_type']]; ?>
				</td>
				<td>
					<?php echo $content['section']; ?>
				</td>
			</tr>
		<?php endforeach;?>
	</table>
</form>

<script src="/data/doors_data.js"></script>
<script src="/scripts/checkout.js"></script>
