<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
    <title>Albero di Vito</title>
    <link rel="stylesheet" type="text/css" href="/css/template.css">
</head>
<body>
	<?=$this->get_main_menu()?>
	<main>
		<?php $this->generate_header()?>
		<div class="main">
			<?php $this->generate_main()?>	
		</div>
	</main>	
</body>
</html>