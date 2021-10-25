<?php

namespace controllers;

use abstracts\AController;
use models\User;

/**
 * Класс контроллера
 */
class HomeController extends AController {

    /**
     * Главная
     */
    public function actionIndex(){
        $error = "";
        if(!isset($_SESSION['auth']) || !$_SESSION['auth']){
            $this->redirect('auth');
        }

        $user = new \models\User();
        $row = $user->findById($_SESSION['auth']);

        if(!$row){
            $this->redirect('auth');
        }else{
            $balance = $row->balance;
        }

        view_template("homeIndex",[
            'balance'=>$balance,
            'error'=>$error,
            'drop_access'=>isset($_REQUEST['drop_access']) ? $_REQUEST['drop_access'] : 0]
        );
    }

    /**
     * Вычтем из баланс
     */
    public function actionDropMoney(){
        $error = "";
        if(!isset($_SESSION['auth']) || !$_SESSION['auth']){
            $this->redirect('auth');
        }

        $user = new \models\User();
        $row = $user->findById($_SESSION['auth']);

        if(!$row){
            $this->redirect('auth');
        }elseif($_REQUEST['count']){
            $balance = $row->balance;
            $new_balance = $row->balance - $_REQUEST['count'];
            if($new_balance >= 0){


                /**
                 * Здесь обрабатываем списание
                 */


                //TODO: По хорошему, надо вынести все подобные вещи в отдельные функции
                /**
                 * TODO: Если бы у нас использовались несколько моделей,
                 * тут можно сделать транзакцию по типу:
                 * $user->db->db->beginTransaction();
                 * $user->db->db->fetch("UPDATE $user->table ...")
                 * $user->db->db->fetch("UPDATE $balance->table ...")
                 * $user->db->db->fetch("UPDATE $orders->table ...")
                 * $user->db->db->rollBack()
                 */
                $user->db->fetch(
                    "UPDATE $user->table SET balance = $new_balance WHERE id = ?",
                    [$_SESSION['auth']]
                );
                $balance = $new_balance;

                $this->redirect('home?drop_access='.$_REQUEST['count']);
            }else{
                $error = "Не указан баланс";
            }
        }

        view_template("homeIndex",['balance'=>$balance,'error'=>$error]);
    }

    /**
     * Авторизация
     */
    public function actionAuth(){
        view_template("homeAuth");
    }

    /**
     * Проверка авторизации
     */
    public function actionAuthCheck(){
        if(!isset($_REQUEST['name']) || !$_REQUEST['name'] || !isset($_REQUEST['password']) || !$_REQUEST['password']){
            $this->redirect('auth');
        }

        $name = $_REQUEST['name'];
        $password = $_REQUEST['password'];

        $user = new \models\User();
        $row = $user->db->fetch(
            "SELECT * FROM $user->table WHERE name = ? AND password = ?",
            [$name, md5($password)]
        );
        if(!$row){
            echo "email or password not valid!";
        }else{
            //конечно это не безопасно, но в современных фреймворках есть более
            //продинутые и удобные механизмы (хранение в сессии хеш ключа, допустим),
            //которые можно, и !нужно использовать
            $_SESSION['auth'] = $row->id;
            $this->redirect('home');
        }

        view_template("homeAuth");
    }
}