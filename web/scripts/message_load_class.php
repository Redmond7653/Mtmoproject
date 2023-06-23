<?php

class Message
{
    private $message;

    private $user_id;

    public function load($message, $user_id)
    {
        include 'connect.php';
        $user_id = $connect->real_escape_string($user_id);
        $message = $connect->real_escape_string($message);
        $date = date('Y-m-d h:m:s');
//        $result = mysqli_query($connect,"SELECT * FROM `messages` WHERE `message` = '$message'");
//        $message_row = $result->fetch_assoc();
        mysqli_query($connect,"INSERT INTO `messages`(`user_id`,`message`,`time`) VALUES ('$user_id','$message','$date')");
        $this->message = $message;
        $this->user_id = $user_id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getId() {
        return $this->user_id;
    }
}