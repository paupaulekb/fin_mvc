<?php

namespace models;

use PDO;
use abstracts\AModel;

/**
 *  ласс подключени€ к базе
 */
class User extends AModel {

    public $table = 'users';

    /**
     * ѕќиск по емейлу
     */
    public function findByEmail(){

    }

}