<?php
	class Controller {
    
    public $model;
    public $view;

    function action_index(){
    }

    function save_status_date($id_task, $status){
        $this->model->base->exec("UPDATE task_status SET date='".date('U')."' 
                                  WHERE id_task=$id_task AND status=(SELECT rowid FROM task_status_names WHERE name='$status')");
    }

    function status_up($id_task, $status){
        /*
            Save level-up status to base if it non-exists.
        */
        $this->save_status_date($id_task, $status);
        $this->model->base->exec("INSERT INTO task_status (id_task, status) 
                                VALUES ($id_task, (SELECT rowid FROM task_status_names WHERE name='$status')+1)");
    }
}