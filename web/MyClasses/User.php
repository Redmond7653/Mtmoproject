<?php

namespace MyClasses;
use MyClasses\Db;


class User
{
    private $email;
    private $login;
    private $messages;
    private $pass;
    private $id;

    private $show_on_main_page_messages;
    public function register($login, $pass)
    {
        $db = new Db();
//        include "connect.php";
        $result = $db->query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
//        $result = mysqli_query($connect,"SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
        $user_data = $result->fetch_assoc();
        $user_data['email'] = $db->escape_string($user_data['email']);
        $user_data['login'] = $db->escape_string($user_data['login']);
        $user_data['pass'] = $db->escape_string($user_data['pass']);
        $user_data['id'] = $db->escape_string($user_data['id']);
        $this->email = $user_data['email'];
        $this->login = $user_data['login'];
        $this->pass = $user_data['pass'];
        $this->id = $user_data['id'];
    }

    public function load($id)
    {
//        include "connect.php";
        $db = new Db();
        $result = $db->query("SELECT * FROM `users` WHERE `id` = '$id'");
        $user_data = $result->fetch_assoc();
        $user_data['email'] = $db->escape_string($user_data['email']);
        $user_data['login'] = $db->escape_string($user_data['login']);
        $user_data['pass'] = $db->escape_string($user_data['pass']);
        $user_data['id'] = $db->escape_string($user_data['id']);
        $this->email = $user_data['email'];
        $this->login = $user_data['login'];
        $this->pass = $user_data['pass'];
        $this->id = $user_data['id'];
    }


    public function getEmail()
    {
        return $this->email;
    }
    public function getName()
    {
        return $this->login;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getPass()
    {
        return $this->pass;
    }
    public function getMessages($current_user_id)
    {
        $db = new Db();
        $result = $db->query("SELECT * FROM `messages` WHERE `user_id` = '$current_user_id'");
        $message_arrays = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($message_arrays as $message_array) {
            $messages[] = $message_array['message'];
        }
        $this->messages = $messages;
        return $this->messages;
    }
    public function setEmail($new_email)
    {
//        include "connect.php";
        $db = new Db();
        $new_email = $db->escape_string($new_email);
        $this->email = $new_email;
        $db->query("UPDATE `users` SET `email` = '$this->email' WHERE `id` = '$this->id'");
    }
    public function setName($new_name)
    {
//        include "connect.php";
        $db = new Db();
        $new_name = $db->escape_string($new_name);
        $this->login = $new_name;
        $db->query("UPDATE `users` SET `login` = '$this->login' WHERE `id` = '$this->id'");
    }
    public function setPass($new_pass)
    {
//        include "connect.php";
        $db = new Db();
        $new_pass = $db->escape_string($new_pass);
        $this->pass = $new_pass;
        $db->query("UPDATE `users` SET `pass` = '$this->pass' WHERE `id` = '$this->id'");
    }
}





