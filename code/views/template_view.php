<!DOCTYPE html>
<?php $form = new Form;?>

<html lang="ru">
<head>
	<meta charset="utf-8">
    <title>Albero di Vito</title>
    <link rel="stylesheet" type="text/css" href="/css/template.css">
</head>
<body>
	<aside>
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