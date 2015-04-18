<div class="container measure_block">
<form method="post" action="">
	<input type='hidden' name='table' value='<?=$this->data['table']?>'>
	<table class='lined_table' rules="all">
		<thead>
			<tr>
				<th>№п/п</th>
				<th></th>
				<?php foreach($this->data['content']['names'] as $name):?>
					<th><?=$name?></th>
				<?php endforeach?>
			</tr>
		</thead>
		<tbody style="font-size:12px;">
		<?php foreach($this->data['content']['data'] as $num=>$string):?>	
			<tr>
				<td><?=$num?></td>
				<td><?=$this->form->createButton('btn_event btn_edit_row','',array("formaction='/spec/edit/".$num."'"))?></td>
				<?php foreach($string as $content):?>
					<td><?=$content?></td>
				<?php endforeach?>
			</tr>
		<?php endforeach?>
		</tbody>
	</table>
	<nav class="form_container">
		<?=$this->form->createButton('btn_form btn_apply','Создать запись',array("formaction='/spec/edit/'"))?>
		<?=$this->form->createLink('/spec/choose', 'Отмена', array("class='btn_form btn_cancel'"))?>
	</nav>
</form>
</div>