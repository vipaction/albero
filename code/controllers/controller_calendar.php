<?php
	class Controller_calendar extends Controller {

	/*
	Methods:
		_index - save new task and task status
		_delete - delete all data about current task of current client
	*/

	function __construct(){
		$this->model = new Model_calendar;
	}

	function action_index(){	
    	$this->view = new View('calendar', 'calendar', $this->model->get_calendar());
    	$this->view->generate();
    }

    function action_event(){
        $this->view = new View('calendar', 'calendar_event', $this->model->get_event());
        $this->view->generate();
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