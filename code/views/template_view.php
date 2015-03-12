<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
    <title>Albero di Vito</title>
    <link rel="stylesheet" type="text/css" href="/css/template.css">
</head>
<body>
	<aside>
		<form method="post">
			<a class="menu_icon" href="/main">
				<img src="/images/tasks-icon.png">
				<pre>Список заказов</pre>
			</a>
			<a class="menu_icon" href="/clients">
				<img src="/images/phonebook-icon.png">
				<pre>Клиенты</pre>
			</a>
			<a class="menu_icon" href="/calendar">
				<img src="/images/calendar-icon.png">
				<pre>Календарь</pre>
			</a>
			<a class="menu_icon" href="/main/archive">
				<img src="/images/archive-icon.png">
				<pre>Архив заказов</pre>
			</a>
		</form>
	</aside>
	<main>
		<header>
			<?php include ("code/views/template_header_".$header.".php"); ?>
		</header>
		<div class="main">
			<?php include ("code/views/".$content); ?>	
		</div>
		<footer>
			MAK$, 2015
		</footer>
	</main>	
</body>
</html>