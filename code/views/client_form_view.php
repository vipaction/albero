	<h2>Редактирование анкеты клиента</h2>
	<hr>
	<form method='post' action='/clients/save'>
		<?php foreach ($data as $key => $value): ?>
			<div>
				<div>
					<?php echo $key.':'; ?>
				</div>
				<div>
					<?php echo $value; ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php echo $addition; ?>
		<hr>
		<div>
			<button>Сохранить</button>
			<button name='cancel'>Отмена</button>
		</div>
	</form>