<?php
	class Controller_task extends Controller {

	function __construct(){
		$this->model = new Model_task;
		$this->view = new View;
	}
    
	function action_check(){
		if (!empty($_POST)){
			var_dump($_POST);
			extract($_POST);

			//if client not exists then create new record in Clients table. Next step is open task (create new record in Task table)
			if (!isset($rowid)){
				$id_client = ''; //change this value to current new client id
			} else {
				$id_client = $rowid;
			}
			$id_task = 1; //change this value to current new task id
			header("Location: ../$task_mode/index/$id_task");		
		}
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
    	if ($_POST['client_phone'] == '') {
			header('Location: ../task/search');
		}
    	$data=$this->model->get_data(); //$data is array with 2 elements
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
					'phone'=>'09612345678'),
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
				),
			'staff'=>array(
				array(
				'first_name'=>'Максим',
				'last_name'=>'Малык',
				'type'=>'2'),
				array(
				'first_name'=>'Алексей',
				'last_name'=>'Малык',
				'type'=>'2'),
				array(
				'first_name'=>'Алексей',
				'last_name'=>'Васютин',
				'type'=>'1'),
				array(
				'first_name'=>'Елена',
				'last_name'=>'Васютина',
				'type'=>'1')));
		foreach ($sql_test as $table => $content) {
			foreach ($content as $values) {
				$fields = implode(',', array_keys($values));
				$test_data = implode(',', array_map(array($this,'addQ')  ,$values));
				$sql_text = "INSERT INTO $table ($fields) VALUES ($test_data)";
				$db = new Dbase;
				$db->db()->exec($sql_text);
			}
		}
    	$this->view->generate('search_view.php', 'template_view.php');
    }

    function addQ($a){
    	return "'".$a."'";
    }
}