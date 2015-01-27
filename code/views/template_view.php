<!DOCTYPE html>
<?php $form = new Form;?>
<html lang="ru">
<head>
	<meta charset="utf-8">
    <title>Albero di Vito</title>
    <link rel="stylesheet" type="text/css" href="css/template.css">
</head>
<body>
	<div class="main">
		<div class="left_side">
			<form method="post">
				<button class="menu_icon" formaction="/main">
					<img src="/images/tasks-icon.png">
					<pre>Список задач</pre>
				</button>
				<button class="menu_icon" formaction="/clients">
					<img src="/images/phonebook-icon.png">
					<pre>Клиенты</pre>
				</button>
				<button class="menu_icon">
					<img src="/images/calendar-icon.png">
					<pre>Календарь</pre>
				</button>
			</form>
		</div>
		<div class="right_side">
			<?php include ("code/views/".$content); ?>	
		</div>
	</div>
	<!--<div>
		<a href="/main">Список задач</a>
		<a href='/clients'>Список клиентов</a>
	</div>-->
	
</body>
</html>