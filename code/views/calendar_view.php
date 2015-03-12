
<table class="calendar_table" rules="all">
	<form method="post" action="/calendar/event/">
		<?php $this_day = getdate();
		$current_week = idate("W");
		for ($week=$current_week; $week < ($current_week+4); $week++){
			echo '<tr>';
			for ($day=1; $day<7 ; $day++) { 
				$week_day = $this_day[0]+(($week-$current_week)*7+$day-$this_day['wday'])*24*60*60;
				echo '<th>'.strftime('%a %d %B', $week_day)." <button class='btn_event btn_add_event' name='day' value='$week_day'></button></th>";
			}
			echo '</tr>';
			echo '<tr>';
			for ($day=1; $day<7 ; $day++){
				echo '<td>';
				if (isset($data['dates'][$week][$day])):
					foreach ($data['dates'][$week][$day] as $event):?>
						<section class="as_row event">
							<a href='/measure/index/<?=$event['id_task']?>'>
								<div><?=$event['address']?></div>
								<div><?=$event['value']?></div>
							</a>
							<a href='calendar/remove/<?=$event['date']?>'>
								<input type="button" class="btn_event btn_remove_event">
							</a>
						</section>
					<?php endforeach; 
				endif;
				echo '</td>';
			}		
			echo '</tr>';
		}?>
	</form>
</table>
