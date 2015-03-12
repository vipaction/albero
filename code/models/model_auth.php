<?php
class Model_auth extends Model{

	/*
	*/

	function auth_session(){
		if (isset($_POST['auth'])){
			$login = $_POST['login'];
			$password = md5($_POST['password']);
			$staff = $this->base->querySingle("SELECT id_auth, last_name, first_name, type FROM staff 
									INNER JOIN auth ON auth.rowid=staff.id_auth
									WHERE auth.login='$login' AND auth.password='$password'", true);
			if (!empty($staff)){
				foreach ($staff as $name => $value) {
					$_SESSION[$name] = $value;
				}
				session_commit();
			}
		}
		$this->data['title'] = 'Авторизация пользователя';
		return $this->data;
	}

	function close_auth_session(){
		session_unset();
	    session_destroy();
	    $_SESSION = array();
	}
}