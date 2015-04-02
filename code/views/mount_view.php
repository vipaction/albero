<div class="container">
<form method="post" action="">
	<table class="data_table" rules="rows">
	<?php 
		$is_mount = FALSE;
		if (isset($this->data['content']['date'])): ?>
			<tr>
				<th>Установлено:</th>
				<td>
					<?php $d_date=getdate($this->data['content']['date']);
						$is_mount = TRUE;
						echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
				</td>
			</tr>
		<?php else:?>
			<tr>
				<th>Стоимость монтажа:</th>
				<td><?=$this->data['content']['mount_cost'];?></td>
			</tr>
			<tr>
				<th>Остаток по договору</th>
				<td><?=$this->data['content']['total_sum']-$this->data['content']['prepaid_sum'];?></td>
			</tr>
		<?php endif;?>
	</table>
	<?php if (!$is_mount):?>
		<nav class="form_container">
			<?=$this->form->createButton('btn_form btn_apply','Подтвердить установку',array("formaction='/mount/apply/".$this->data['id_task']."'"))?>
		</nav>
	<?php endif?>
</form>
</div>