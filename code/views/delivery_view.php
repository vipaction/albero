<div class="container">
<form method="post" action="">
	<table class="data_table" rules="rows">
	<?php $is_delivered = FALSE;
	if (isset($this->data['content']['date'])): ?>
		<tr>
			<th>Доставлено заказчику:</th>
			<td>
				<?php $d_date=getdate($this->data['content']['date']);
					$is_delivered = TRUE;
					echo $d_date['mday'].'.'.$d_date['mon'].'.'.$d_date['year'];?>
			</td>
		</tr>
	<?php else:?>
		<tr>
			<th>Стоимость доставки:</th>
			<td><?=$this->data['content']['delivery_cost'];?></td>
		</tr>
		<tr>
			<th>Остаток по договору</th>
			<td><?=$this->data['content']['total_sum']-$this->data['content']['prepaid_sum'];?></td>
		</tr>
	<?php endif;?>
	</table>
	<?php if (!$is_delivered):?>
		<nav class="form_container">
			<?=$this->form->createButton('btn_form btn_apply','Подтвердить доставку',array("formaction='/delivery/apply/".$this->data['id_task']."'"))?>
		</nav>
	<?php endif?>
</form>
</div>