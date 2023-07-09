<?php

namespace MyClasses;

use MyClasses\Db;

class Message
{
    private $message;

    private $user_id;

    private $part_of_messages;

    public function save_message($message, $user_id)
    {
        $db = new Db();
//        include 'connect.php';

//        $user_id = $connect->real_escape_string($user_id);
        $user_id = $db->escape_string($user_id);
//        $message = $connect->real_escape_string($message);
        $message = $db->escape_string($message);


        $date = date('Y-m-d h:m:s');

        $db->query("INSERT INTO `messages`(`user_id`,`message`,`time`) VALUES ('$user_id','$message','$date')");


        $this->message = $message;
        $this->user_id = $user_id;
    }

    public function show_current_user_messages($id) {
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
            $this->part_of_messages = $result->fetch_all(MYSQLI_ASSOC);
        }

        return $this->part_of_messages;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getId() {
        return $this->user_id;
    }
}