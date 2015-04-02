<?php
class Form{ 
/* Common functions which used to create any form in views*/
	function createInputField($name, $current_value, $required=""){
		return "<input type='text' name='$name' value='$current_value' $required>";
	}

	function createSelectField($name, $current_value, $list_value, $size=1){
		$to_string = "<select name='$name' size=$size>";
		foreach ($list_value as $value => $content) {
			$selected = ($value==$current_value) ? 'selected' : '';
			$is_value = ($value != '') ? "value=$value" : '';
			$to_string .= "<option $is_value $selected>$content</option>";
		}
		$to_string .= "</select>";
		return $to_string;
	}

	function createCheckboxField($name, $value = NULL){
		$checked = $value ? 'checked' : '';
		return "<input type='checkbox' name='$name' $checked value='1'>";
	}

	function createButton($class, $value, $actions = array()){
		return "<button class='$class' ".implode(' ', $actions).">$value</button>";
	}
	function createLink($href, $value, $actions = array()){
		return "<a href='$href' ".implode(' ', $actions).">$value</a>";
	}
}

class View{
	public $data;
	public $action;
	public $target;
	public $header = null;
	public $form;
	public $project_data;	// Array with names and values of content's elements

	function __construct($target, $action, $data){
		$this->form = new Form;
		$this->target = $target;
		$this->data = $data;
		$this->action = $action;
		include('data/constants.php');
		$this->project_data = $project_data; // Use previous data for names and values contents from outside file
	}

	function generate(){
		include('code/views/template_view.php');
	}

	private function get_main_menu(){
		$str = "";
		if ($this->check_target()){
			$menu_item = array('main'=>'Список заказов', 'clients'=>'База клиентов', 'calendar'=>'Календарь', 'archive'=>'Архив');
			$str .= "<aside><img src='/images/".$this->target."-icon.png' class='header_img'>";
			foreach ($menu_item as $name => $value) {
				$str .= $this->form->createLink('/'.($name == 'archive' ? 'main/'.$name : $name), '<div>'.$value.'</div>', array("class='menu_icon menu_{$name}'"));
			}
			$str .= "</aside>";
		}
		return $str;
	}

	private function generate_header(){
		if ($this->check_target())
			include('code/views/template_header.php');
	}

	private function generate_main(){
		include('code/views/'.$this->action.'_view.php');
	}

	private function check_target(){
		if ((($this->target == 'spec') && $this->action == 'spec_result') || ($this->target == 'auth'))
			return FALSE;
		else
			return TRUE;
	}

	function get_title(){
		return "<div class='title'>".$this->data['title']."</div>";
	}
	
	function get_auth_panel(){
		$panel = "<form method='post'><div class='auth_panel'>";
		$panel .= "<div>Здравствуйте,</div>";
		$panel .= "<div>".$this->data['auth']['first_name']."</div>";
		$panel .= $this->form->createButton('btn_auth', 'Выход', array("formaction='/auth/close'"));
		if ($this->data['auth']['type'] == 1){
			$panel .= $this->form->createButton('btn_auth', 'Панель управления', array("formaction='/admin/index'"));
		}
		$panel .= "</div></form>";
		return $panel;
	}
	function get_target_content(){
		switch ($this->target) {
			case 'main':
				$fields_array = array(
					'all'=>'Все', 
					'measure'=>'Замер', 
					'checkout'=>'Оформление', 
					'postage'=>'Отправка со склада', 
					'ready'=>'Получение со склада', 
					'delivery'=>'Доставка', 
					'mount'=>'Установка');
				$str = $this->get_search_menu($fields_array);
				break;
			case 'task':
				$str = $this->get_header_info(TRUE);
				$str .= $this->get_task_nav();
				break;
			case 'client':
				$str = "<form method='post'>";
				$str .= $this->get_header_info();
				$str .= $this->get_client_nav();
				$str .= "</form>";
				break;
			case 'clients': 
				$fields_array = array(
					'all'=>'Все', 
					'no_orders'=>'без заказов');
				$str = $this->get_search_menu($fields_array, $this->form->createButton('btn_form btn_add_user', 'Добавить клиента', array("formaction='/clients/info'","name='edit'")));
				break;
			default:
				$str = '';
				break;
		}
		return $str;
	}
	function get_search_menu($list, $button = ""){
		$str = "<div class='as_row'><form method='post'><nav>";
		$str .= "<input type='search' placeholder='Поиск по базе' class='search_field' name='search'>";
		$current_value = isset($_POST['sort']) ? $_POST['sort'] : '';
		$str .= $this->form->createButton('btn_form btn_find', 'Найти в базе данных');
		$str .= $this->form->createSelectField('sort', $current_value, $list);
		$str .= $button;		
		$str .="</nav></form></div>";
		return $str;
	}
	function get_header_info($is_task = FALSE){
		$str = "<table class='data_table' rules='rows'>";
		foreach ($this->project_data['clients_data'] as $name => $value){	
			$str .= "<tr><th>".$value.":</th><td>";
			if ($is_task)
				$str .= $this->data['header']['client_info'][$name];
			elseif (isset($_POST['edit']))
				$str .= $this->form->createInputField($name,
					(isset($this->data['client_info'][$name]) ? $this->data['client_info'][$name] : ''),
					($name=='phone' ? 'required' : ''));
			else 
				$str .= $this->data['client_info'][$name];
			$str .= "</td></tr>";
		}
		if ($is_task){
			$str .= "<tr><th colspan='2' align='center' style='padding: 5px 10px'>";
			$str .= $this->form->createLink('/clients/info/'.$this->data['header']['id_client'],'Информация о клиенте', array("class='btn_nav'"));
			$str .= "</th>";
		}
		$str .= "</table>";
		return $str;
	}
	function get_task_nav(){
		$str = "<nav class='nav_container'>";
		foreach ($this->data['header']['status_info'] as $value)
			$str .= $this->form->createLink('/'.$value['name'].'/index/'.$value['id_task'], $value['value'], array("class='btn_nav'"));
		$str .= "</nav>";
		return $str;
	}
	function get_client_nav(){
		
		$str = "<nav class='form_container'>";
		if (isset($_POST['edit'])) {
			$str .= $this->form->createButton('btn_form btn_apply', 'Сохранить изменения',
				array("formaction='/clients/save/".($this->data['id_client'] !== null ? $this->data['id_client'] : '')."'"));
			$str .= $this->form->createLink(($this->data['id_client'] ? '' : '/clients/index'), 'Отмена', array("class='btn_form btn_cancel'"));
		} else {
			$str .= $this->form->createLink('/task/index/'.$this->data['id_client'], 'Создать заявку', array("class='btn_form btn_measure'"));
			$str .= $this->form->createButton('btn_form btn_edit', 'Редактировать данные',array("name='edit'"));
			$str .= $this->form->createLink('/clients/delete/'.$this->data['id_client'], 'Удалить клиента', array("class='btn_form btn_cancel'"));

		}

		return $str;
	}
}