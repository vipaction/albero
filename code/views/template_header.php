<header>
	<section>
		<?=$this->get_title()?>
		<?=$this->get_target_content()?>
	</section>
	<?php if ($this->target == 'main') echo $this->get_auth_panel()?>
</header>