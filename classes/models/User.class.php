<?php

namespace models;

use PDO;
use abstracts\AModel;

/**
 * ����� ����������� � ����
 */
class User extends AModel {

    public $table = 'users';

    /**
     * ����� �� ������
     */
    public function findByEmail(){

    }

}