<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

include_once 'helper.php';

spl_autoload_register('my_autoloader');

ob_start();

include_once 'views/header.php';

//урлы
include_once 'urlManager.php';

/**
 * Выведем нужный файл
 */
$path = explode("?", isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI']);

if(isset($path[0]) && $path[0] && isset($url_detect[$path[0]])){
    $controller = "controllers\\".$url_detect[$path[0]][0];

    if(class_exists($controller)){
        $objectController = new $controller();
        $name_function = "action".ucfirst($url_detect[$path[0]][1]);
        if(method_exists($objectController,$name_function)){
            $objectController->$name_function();
        }else{
            echo_404();
        }
    }else{
        echo_404();
    }
}else{
    echo_404();
}

include_once 'views/footer.php';

ob_flush();

session_write_close();