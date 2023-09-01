<?php

namespace MyClasses;

use MyClasses\Db;

class Message
{
    private $message;

    private $user_id;

    private $part_of_messages;
    
    private $data_array;

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
        $limit = 10;
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
    
    public function load_data_message($message_id) {
      $db = new Db();
      
      $result = $db->query("SELECT * FROM `messages` WHERE `id` = '$message_id'");
      $table_message_row = $result->fetch_assoc();
      $result1 = $db->query("SELECT * FROM `images` WHERE `message_id` = '$message_id'");
      $table_image_rows = $result1->fetch_all(MYSQLI_ASSOC);
      $this->data_array = [];
      foreach ($table_image_rows as  $table_image_row) {
        $image_key = $table_image_row['id'];
        $image_item = $table_image_row['img'];
        $this->data_array['img'][$image_key] = $image_item;
      }
      
      $this->data_array['message'] = $table_message_row['message'];
      
    }
    
    public function getUserArray() {
      return $this->data_array;
    }
    
    public function save_hashtags($hashtags, $id) {
      $db = new Db();
      
      $result = $db->query("SELECT * FROM `messages` WHERE `user_id` = '$id' ORDER BY `id` DESC LIMIT 1");
      $user_last_message_array = $result->fetch_assoc();
      
      $id_message = $user_last_message_array['id'];
      
      $hashtags_array = explode(',', $hashtags);
      
      if (!empty($hashtags)) {
        foreach ($hashtags_array as $hashtag) {
          $hashtag = str_replace(' ', '', $hashtag);
          $hashtags_data = $db->query("INSERT INTO `hashtags` (`hashtag`, `message_id`) VALUES ('$hashtag','$id_message')");
        }
      }
    }
}