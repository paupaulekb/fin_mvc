<?php

namespace abstracts;

use PDO;
use system\Db;

/**
 * Êëàññ ïîäêëş÷åíèÿ ê áàçå
 */
class AModel {

    public $db;
    public $table;

    public function __construct(){
        $this->db = new Db();
    }

    /**
     * Íàéäåì çàïèñü ïî id
     *
     * @param $id
     *
     * @return false
     */
    public function findById($id){
        if(!$id){
            return false;
        }

        return $this->db->fetch("SELECT * FROM $this->table WHERE id = :id",['id' => $id]);
    }
}