<?php if (isset($data['tasks'])):
	foreach ($data['tasks'] as $id_task=>$task): ?>
		<div class="container info_block">
			<section>
				<div class="title">Заказ №<?=$id_task;?></div>
				<?php if (is_null($task['closed'])):?>
					<img src="/images/task-info-icon.png" width="72" height="72">
				<?php else:?>
					<img src="/images/closed-icon.png" width="72" height="72">
					<p>Заказ в архиве</p>
				<?php endif;?>
			</section>
			<section>
				<table class="data_table" rules="rows">
				<?php foreach ($task['statuses'] as $status):?>
					<tr>
						<th><a href="/<?=$status['name'];?>/index/<?=$id_task;?>"><?=$status['value'];?></a></th>
						<td><?=$status['date']?></td>
					</tr>
				<?php endforeach;?>
				</table>
				<a href="/task/delete/<?=$id_task;?>">удалить заказ</a>
			</section>
		</div>
	<?php endforeach;
endif;?>