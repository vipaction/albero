<?php
	class Controller_task extends Controller {

	function __construct(){
		$this->model = new Model_task;
		$this->view = new View;
	}
    
	function action_check(){
		if ($_POST['task_mode'] == 'main'){
			header("Location: /main/index");
			return;
		}
		$status = $this->model->open_task(); //add new client if it need, create new task and save choosen status of task)
		$this->view->generate('confirmation_view.php', 'template_view.php', $status);
	}

    function action_index()
    {	
    	$data=$this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_search()
    {
    	$this->view->generate('search_view.php', 'template_view.php');
    }

    function action_create()
    {	
    	// repeat to input phone number if it empty
    	if ($_POST['client_phone'] == '') {
			header('Location: /task/search');
		}
    	$data=$this->model->get_data(); //$data is array with 2 elements (client's info and hidden field with id_client)
        $this->view->generate('create_task_view.php', 'template_view.php', $data[0], $data[1]);
    }

    function action_fill()
    {
    	$sql_test = array(
			'clients'=>array(
				array(
					'first_name'=>'Петр',
					'second_name'=>'Петрович',
					'last_name'=>'Петров',
					'address'=>'ул. Тестовая 14/14',
					'phone'=>'0961234567'),
				array(
					'first_name'=>'Иван',
					'second_name'=>'Иванович',
					'last_name'=>'Иванов',
					'address'=>'ул. Космическая 19',
					'phone'=>'4011216'),
				array(
					'first_name'=>'Сидор',
					'second_name'=>'Сидорович',
					'last_name'=>'Сидоров',
					'address'=>'ул. Ленина 123/33',
					'phone'=>'0509201515'),
				array(
					'first_name'=>'Людмила',
					'second_name'=>'Николаевна',
					'last_name'=>'Яременко',
					'address'=>'ул. Косиора 12/115',
					'phone'=>'0631234568'),
				array(
					'first_name'=>'Константин',
					'second_name'=>'Павлович',
					'last_name'=>'Воробьев',
					'address'=>'пр. Металлургов 45/23',
					'phone'=>'0985689853')
				));
		foreach ($sql_test as $table => $content) {
			foreach ($content as $values) {
				$fields = implode(',', array_keys($values));
				$test_data = implode(',', array_map(array($this,'addQ')  ,$values));
				$sql_text = "INSERT INTO $table ($fields) VALUES ($test_data)";
				$db = new SQLite3('base.db');
				$db->exec($sql_text);
			}
		}
    	$this->view->generate('search_view.php', 'template_view.php');
    }

    function addQ($a){
    	return "'".$a."'";
    }
}