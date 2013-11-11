<form method="post" action="/measure/save_measure">
	<?php foreach ($data as $value=> $content): ?>
		<fieldset>
			<legend>
				<?php echo $value; ?>
			</legend>
			<?php foreach ($content as $name => $param): ?> 
				<div>
					<?php echo "$name: $param"; ?>
				</div>
			<?php endforeach;?>
		</fieldset>
	<?php endforeach; ?>	
	<button name='send'>Отправить</button>
	<button>Отмена</button>
</form>