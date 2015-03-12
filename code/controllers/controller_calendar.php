<?php
	class Controller_calendar extends Controller {

	/*
	Methods:
		_index - save new task and task status
		_delete - delete all data about current task of current client
	*/

	function __construct(){
		$this->model = new Model_calendar;
        $this->view = new View;
	}

	function action_index(){	
    	$data = $this->model->get_calendar();
    	$this->view->generate('calendar_view.php', 'calendar', $data);
    }

    function action_event(){
    	$data = $this->model->get_event();
    	$this->view->generate('calendar_event_view.php', 'calendar', $data);
    }

    function action_add($day){
    	$this->model->add_event($day);
    	header("Location: /calendar");
    }

    function action_remove($day){
    	$this->model->remove_event($day);
    	header("Location: /calendar");
    }
}