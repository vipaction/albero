<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
    <title>Albero di Vito</title>
</head>
<?php $form = new Form;?>
<body>
	<div>
		<a href="/main">Список задач</a>
		<a href='/clients'>Список клиентов</a>
	</div>
	<?php 
		$task_info = new Info;
		foreach ($task_info->client_info($id_task) as $value=> $content): ?>
		<div>
			<b><?php echo $value.' :'; ?></b> <?php echo $content; ?>
		</div>
	<?php endforeach; ?>
	<hr>
	<?php foreach ($task_info->status_info($id_task) as $status): ?>
			<?php echo $form->create_link_elem($status['name'], $status['value'],$status['id_task']); ?>
	<?php endforeach;?>
	<hr>
	<?php include ('code/views/'.$view_file); ?>	
	<div>
		<a href="/main">Список задач</a>
		<a href='/clients'>Список клиентов</a>
	</div>
</body>
</html>