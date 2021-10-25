<?php
/**
 * Функция подключает все классы которые лежат в папке Classes
 */
function my_autoloader( $className ) {
    $className = str_replace( "..", "", $className );
    $className = str_replace( "\\", "/", $className );
    require_once( $_SERVER['DOCUMENT_ROOT']."/classes/$className.class.php" );
}

/**
 * Функция для вывода данных
 */
function ep($str = ""){
    echo"<pre>";print_r($str);echo"</pre>";
}

/**
 * Функция для вывода 404
 */
function echo_404(){
    echo "Такой страницы не существует";
    exit();
}

/**
 * Функция для вывода шаблона
 *
 * @param string $name_template - название файла
 * @param array $ar_param - переменные
 */
function view_template($name_template, $param = []){
    $path = $_SERVER['DOCUMENT_ROOT']."/views/$name_template.php";
    if(file_exists($path)) {
        require_once $path;
    }else{
        echo "Такого шаблона нет";
    }
}