<?php
class Model_admin extends Model{

	function get_list(){
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
			$this->base->exec("UPDATE auth SET login='$new_login', password='$new_password'");
		} else {
			$this->base->exec("INSERT INTO auth (login, password) VALUES ('$new_login', '$new_password')");
			$id_auth = $this->base->lastInsertRowID();
		}
		$this->save_data($id_auth, 'staff', 'id_auth');
	}

	function remove_user($id_user){
		$this->base->exec("DELETE FROM staff WHERE id_auth='$id_user'; DELETE FROM auth WHERE rowid='$id_user'");
	}

	/*
			if (!empty($_POST['login']) && !empty($_POST['password'])){
				$login = $_POST['login'];
				$password = password_hash($_POST['password'],PASSWORD_BCRYPT);
				$this->base->exec("INSERT INTO auth (login, password) VALUES ('$login', '$password')");
				$id_auth = $this->base->lastInsertRowID();
				$this->base->exec("INSERT INTO staff (id_auth, first_name, last_name, type)
					VALUES ('$id_auth', 'Максим', 'Малык', '1')");
			}
	*/
}