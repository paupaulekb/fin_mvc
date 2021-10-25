<?php

//вынес в отдельный, т.к. обычно используется ОРМ
namespace system;

use PDO;

/**
 * Класс подключения к базе
 */
class Db {

    // $db - объект класса PDO
    public $db;
    //$stmt - дополнительный объект класс PDO
    private $stmt;
    private $name_base = "p61506_testfin";
    private $pass_base = "Ks7EMtAyiT";

    public function __construct() {
        $this->db = new PDO(
            'mysql:host=p61506.mysql.ihc.ru;dbname='.$this->name_base,
            $this->name_base,
            $this->pass_base
        );

        $this->db->exec("set names utf8");
    }

    /**
     * execute для PDO
     *
     * @param string $query - запрос SQL
     * @param array  $ar    - массив параметров
     *
     * @return void PDO - возвращаем объект PDO
     */
    private function execute($query, $ar = []){
        try{
            $this->stmt = $this->db->prepare($query);
            $this->stmt->execute($ar);
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * Обертка для PDO, чтобы получить нужные данные из базы в виде объекта
     *
     * @param string $query - запрос SQL
     * @param array  $ar    - массив параметров
     *
     * @return object - возвращаем 1 объект из базы
     */
    function fetch($query, $ar = []){
        $this->execute($query, $ar);
        return $this->stmt->fetchObject();
    }

    /**
     * Обертка для PDO, чтобы получить нужные данные из базы в виде массива объектов
     *
     * @param string $query - запрос SQL
     * @param array  $ar    - массив параметров
     *
     * @return array - возвращаем массив объектов из базы
     */
    function fetchAll($query, $ar = []){
        $this->execute($query, $ar);

        $res = [];
        foreach($this->stmt->fetchAll(PDO::FETCH_ASSOC) as $f){
            $res[] = (object)$f;
        }
        return $res;
    }
    
    /**
     * Вызываем нашу функцию fetchAll, чтобы получить список столбцов таблицы
     * 
     * @param string $table - название нужной таблицы
     * @return array/bool
     */
    function getColumnName($table = ""){
        if($table){
            $query = "SELECT column_name,column_comment FROM information_schema.columns WHERE table_schema='p61506_hello_w' and table_name=?";
            return $this->fetchAll($query,[$table]);
        }

        return false;
    }
    
    /**
     * 
     * Получает последний id внесенной записи в базу, пока не особо нужно
     * 
     * @return int id записи
     */
    function lastInsertId(){
        return $this->db->lastInsertId();
    }
}
