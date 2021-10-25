<?php

namespace abstracts;

use PDO;

/**
 * Абстракция контроллеров
 */
class AController {

    public function redirect($url){
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: ' . $url);

        die();
    }
}