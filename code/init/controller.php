<?php
	class Controller {
    
    public $model;
    public $view;
    public $id_task;
    
    function action_index(){
    }

    function status_up($id_task, $status){
        /*
            Save level-up status to base if it non-exists.
        */
        $check_status = $this->model->base->querySingle("SELECT status FROM task_status 
                                                         INNER JOIN task_status_names 
                                                         ON task_status_names.rowid = task_status.status
                                                         WHERE id_task=$id_task AND name='$status'");
        if (!$check_status){
            $this->model->base->exec("INSERT INTO task_status (id_task, status) 
                                VALUES ($id_task, (SELECT rowid FROM task_status_names WHERE name='$status'))");
        }
    }
}