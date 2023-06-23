<?php

class Loaduser
{
    private $email;
    private $login;
    private $pass;
    private $id;

    public function load($login, $pass)
    {
        include "connect.php";
        $result = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
        $user_data = $result->fetch_assoc();
        $user_data['email'] = $connect->real_escape_string($user_data['email']);
        $user_data['login'] = $connect->real_escape_string($user_data['login']);
        $user_data['pass'] = $connect->real_escape_string($user_data['pass']);
        $user_data['id'] = $connect->real_escape_string($user_data['id']);
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
}