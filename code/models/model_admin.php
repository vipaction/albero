<?php
class Model_admin extends Model{
	private $tables;

	function __construct(){
		parent::__construct();
		$this->tables = new DTable();
	}

	function get_users_list(){
		$this->data['title'] = 'Список пользователей';
		$users = $this->base->query("SELECT staff.*, auth.login FROM staff INNER JOIN auth ON staff.id_auth=auth.rowid");
		while ($user = $users->fetchArray(SQLITE3_ASSOC)){
			$this->data['content'][]=$user;
		}
		return $this->data;
	}

	function get_user_info($id_user){
		$user = $this->base->querySingle("SELECT staff.*, auth.login FROM staff 
						INNER JOIN auth ON staff.id_auth=auth.rowid WHERE staff.id_auth = '$id_user'", TRUE);
		if (empty($user)){
			$this->data['title'] = 'Новый пользователь';
			$this->data['content'] = array_fill_keys(array('last_name', 'first_name', 'id_auth', 'login', 'password', 'type'), '');
		} else {
			$this->data['title'] = $user['first_name'].' '.$user['last_name'];
			$this->data['content'] = $user;
		}
		return $this->data;
	}

	function save_user($id_user){
		$id_auth = $this->base->querySingle("SELECT auth.rowid FROM auth 
						INNER JOIN staff ON staff.id_auth=auth.rowid 
						WHERE staff.id_auth='$id_user'");
		$new_login = $_POST['login'];
		$new_password = md5($_POST['password']);
		unset($_POST['login']);
		unset($_POST['password']);
		if (!empty($id_auth)){
			$this->base->exec("UPDATE auth SET login='$new_login', password='$new_password' WHERE rowid='$id_auth'");
		} else {
			$this->base->exec("INSERT INTO auth (login, password) VALUES ('$new_login', '$new_password')");
			$id_auth = $this->base->lastInsertRowID();
		}
		$this->save_data($id_auth, 'staff', 'id_auth');
	}

	function remove_user($id_user){
		$this->base->exec("DELETE FROM staff WHERE id_auth='$id_user'; DELETE FROM auth WHERE rowid='$id_user'");
	}

	function get_tables(){
		$this->data['title'] = 'Редактирование таблиц';
		$names = $this->tables->get_values('sqlite_master',"type='table'");
		$names = array_values(array_map(function($arg){return $arg['name'];}, $names));
		$this->data['content'] = array_combine($names, $names);
		return $this->data;
	}

	function view_table(){
		$table_name = $_POST['table'];
		$this->data['table'] = $table_name;
		$this->data['title'] = 'Просмотр таблицы '.$table_name;
		$this->data['content']['names'] = $this->tables->get_fields($table_name);
		$this->data['content']['data'] = $this->tables->get_values($table_name);
		return $this->data;
	}

	function edit_table($id_row){
		$this->data['id_row'] = $id_row;
		$this->data['table'] = $_POST['table'];
		$this->data['title'] = 'Редактирование записи';
		if ($id_row == ''){
			$this->data['content'] = array_fill_keys($this->tables->get_fields($this->data['table']), '');
		} else {
			$this->data['content'] = array_shift($this->tables->get_values($this->data['table'], 'rowid='.$id_row));
		}
		return $this->data;
	}

	function save_row($id_row){
		$data = $_POST;
		$name = $data['table'];
		unset($data['table']);
		$this->tables->set_values($name, $data, $id_row);
	}

	function delete_row($id_row){
		$this->tables->remove_values($_POST['table'], $id_row);
	}

}