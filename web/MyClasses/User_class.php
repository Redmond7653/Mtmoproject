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
    public function load($login, $pass)
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

    public function loaduser($id)
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

    public function get_current_user_messages($id) {
//        include "connect.php";

        $db = new Db();
        $page = 1;
        $limit = 5;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        }

        $page = $page - 1;
        $offset = $page * $limit;
        if ($result = $db->query("SELECT * FROM `messages` WHERE `user_id` = '$id' ORDER BY `id` DESC LIMIT {$offset}, {$limit}"));
        {
            $user_rows_messages = $result->fetch_all(MYSQLI_ASSOC);
        }

        $this->messages = "<h2>Page ".($page + 1)."</h2>";
        foreach ($user_rows_messages as $message_row) {
            $this->messages .= "<div class='user_message'>".($message_row['message']) . "</div>";
        }
        return $this->messages;
    }

    public function getMessages() {
        return $this->messages;
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
        $new_pass = md5($new_pass);
        $this->pass = $new_pass;
        $db->query("UPDATE `users` SET `pass` = '$this->pass' WHERE `id` = '$this->id'");
    }
}





