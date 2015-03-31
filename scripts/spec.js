function display_door(){
	model = document.getElementById('door_view')
	model.style.background = '#eee'				
}

document.querySelector('table.data_table').addEventListener('change', display_door, true)