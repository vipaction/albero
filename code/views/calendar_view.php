<table class="calendar_table" rules="all">
	<form method="post" action="/calendar/event/">
		<?php $this_day = getdate();
		$current_week = idate("W");
		for ($week=$current_week; $week < ($current_week+4); $week++){
			echo '<tr>';
			for ($day=1; $day<7 ; $day++) { 
				$week_day = $this_day[0]+(($week-$current_week)*7+$day-$this_day['wday'])*24*60*60;
				echo '<th>'.strftime('%a %d %B', $week_day).$this->form->createButton('btn_event btn_add_event','',array("name='day'", "value='$week_day'"))."</th>";
			}
			echo '</tr>';
			echo '<tr>';
			for ($day=1; $day<7 ; $day++){
				if (($day==$this_day['wday']) && ($week==$current_week))
					echo '<td style="background: #ddd">';
				else
					echo '<td>';
				if (isset($this->data['dates'][$week][$day])):
					foreach ($this->data['dates'][$week][$day] as $event):?>
						<section class='as_row event'>
							<?=$this->form->createLink("/measure/index/".$event['id_task'], "<div>{$event['address']}</div><div>{$event['value']}</div>")?> 
							<?=$this->form->createLink("/calendar/remove/".$event['date'], $this->form->createButton("btn_event btn_remove_event",'',array("type='button'")))?> 
						</section>
					<?php endforeach;
				endif;
				echo '</td>';
			}		
			echo '</tr>';
		}?>
	</form>
</table>
