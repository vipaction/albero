<!DOCTYPE html>
<?php $form = new Form;?>
<html lang="ru">
<head>
	<meta charset="utf-8">
    <title>Albero di Vito</title>
</head>
<body>
	<div>
		<a href="/main">Список задач</a>
		<a href='/clients'>Список клиентов</a>
	</div>
	<?php 
		$task_info = new Info;
		foreach ($task_info->client_info() as $value=> $content): ?>
		<div>
			<b>
				<?php echo $value.' :'; ?>
			</b> 
			<?php echo $content; ?>
		</div>
	<?php endforeach; ?>
	<hr>
	<?php foreach ($task_info->status_info() as $status): ?>
			<?php echo $form->create_link_elem($status['name'], $status['value']); ?>
	<?php endforeach;?>
	<hr>
	<?php include ('code/views/'.$view_file); ?>	
	<div>
		<a href="/main">Список задач</a>
		<a href='/clients'>Список клиентов</a>
	</div>
</body>
</html>