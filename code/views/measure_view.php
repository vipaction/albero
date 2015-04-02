<div class="container measure_block">
	<table border="1">
		<thead>
			<tr>
				<th colspan="3">Дверь</th>
				<th colspan="3">Проем</th>
				<th colspan="3">Блок</th>
				<th colspan="3">Особенности</th>
				<th colspan="4">Дополнительно</th>
			</tr>
			<tr>
				<th>№</th>
				<th>комн.</th>
				<th>тип</th>
				<th>W</th>
				<th>H</th>
				<th>D</th>
				<th>W</th>
				<th>H</th>
				<th>D+</th>
				<th>откр.</th>
				<th>ручка</th>
				<th>нал.</th>
				<th>порог</th>
				<th>расш.</th>
				<th>подр.</th>
				<th>врез.</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$i = 1;
			if (isset($this->data['content']['measurement'])):
				foreach ($this->data['content']['measurement'] as $id=>$value): ?>	
					<tr>
						<td>
							<?php echo $i++; ?>
						</td>
						<?php foreach ($value as $key=>$content): ?>
							<td>
								<?php if (in_array($key, array('door_type', 'room_type', 'door_openning', 'door_handle'))) 
										echo $this->project_data[$key][$content]; // Values of this keys in /data/constant.php
									elseif (in_array($key, array('door_step', 'cut_section', 'cut_block', 'cut_door')) && $content !='') 
										echo '✔'; //For values of checkbox
									else
										echo $content; ?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach;
			endif;?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="9">
					<section class="as_row thumbs">
						<?php if (!empty($this->data['content']['thumbs'])):?>
							<?php foreach ($this->data['content']['thumbs'] as $key=>$images):?>
								<a target="_blank" href="/<?=$this->data['content']['images'][$key]?>">
									<img class="thumb_container" src="/<?=$images?>">
								</a>
							<?php endforeach;?>
						<?php endif;?>	
					</section>
				</td>
				<td colspan="8" align="center" valign="center">
					<?php if (!empty($this->data['content']['comment'])):?>
						<p class="thumb_container">
							<?=$this->data['content']['comment']?>
						</p>
					<?php endif;?>
				</td>
			</tr>
		</tfoot>
	</table> 
	<form method="post" action="">
		<nav class="form_container">
			<?php $check_content = array_filter($this->data['content']);
			if (!empty($check_content)):?>
				<?=$this->form->createButton('btn_form btn_apply', 'Отправить замер', array("formaction='/measure/apply/".$this->data['id_task']."'"))?>
				<?php if ($this->data['auth']['type'] !== 2):?>
					<?=$this->form->createLink('/spec/index/'.$this->data['id_task'], 'Создать спецификацию', array("class='btn_form btn_spec'"))?>
				<?php endif;?>
			<?php endif;?>
			<?=$this->form->createLink('/measure/edit/'.$this->data['id_task'], 'Редактировать замер', array("class='btn_form btn_edit'"))?>
		</nav>
	</form>
</div>