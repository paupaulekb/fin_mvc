<?php

namespace abstracts;

use PDO;

/**
 * ���������� ������������
 */
class AController {

    public function redirect($url){
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: ' . $url);

        die();
    }
}