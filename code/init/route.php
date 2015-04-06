<?php
/**
* 
*/
class Route {
	
	static function start(){
		// start values of control and action
        ob_start();
        session_start();

        $controller_name = 'main';
        $action_name = 'index';
        $current_id='';
        
        // check session data
        if (!isset($_SESSION['id_auth'])){
            $controller_name = 'auth';

        } else {
            
            //split route to variables
            $current_path = $_SERVER['REQUEST_URI'];
            $current_path = substr($current_path,0,strpos($current_path, '?'));
            if ($current_path == '')
                $routes = explode('/', $_SERVER['REQUEST_URI']);
            else
                $routes = explode('/', $current_path);
            
            // i can contol it - !!
            if ( !empty($routes[1])){   
                $controller_name = $routes[1];
            }
            
            // an action!
            if ( !empty($routes[2])){
                $action_name = $routes[2];
            }

            //for actions wich use id_client or id_task
            if ( !empty($routes[3])){
                $current_id = $routes[3];
            }
        }

        

        // add prefix to simply use
        $model_name = 'Model_'.$controller_name;
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;
        
        // use model if exists

        $model_file = strtolower($model_name).'.php';
        $model_path = "code/models/".$model_file;
        if(file_exists($model_path)){
            include "code/models/".$model_file;
        }

        // use controler or error
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "code/controllers/".$controller_file;
        if(file_exists($controller_path)){
            include "code/controllers/".$controller_file;
        } else {
            Route::ErrorPage404('Controller not exist');
        }
        
        // create controler
        $controller = new $controller_name($current_id);
        $action = $action_name;
        
        if(method_exists($controller, $action)){
            // and do action
            $controller->$action($current_id);
        } else {
            Route::ErrorPage404('Method not exist');
        }   
    }
    
    function ErrorPage404($mess) {
        echo "<h1>$mess</h1><h3>ROUTE</h3>";
        echo '<b>'.$_SERVER['REQUEST_URI'].'</b>';
        echo "<hr><h3>\$SERVER</h3>";
        var_dump($_SERVER);
        echo '</hr><h3>$POST</h3>';
        var_dump($_POST);
        exit;
    }
}