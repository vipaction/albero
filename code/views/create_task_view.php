	<h2>Создание заявки</h2>
	<hr>
	<form method='post' action='../task/check'>
		<?php 
			foreach ($data as $key => $value) {
				echo "<div><div>$key:</div><div>$value</div>";
			}
			echo $addition;
		?>
		<hr>
		<div>
			<button name="task_mode" value="measure">Сделать замер</button>
			<button name="task_mode" value="delivery">Доставка дверей</button>
			<button name="task_mode" value="mount">Монтаж дверей</button>
			<button name="task_mode" value="main">Отмена</button>
		</div>
	</form>