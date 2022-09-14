<?php

$user_id = $_SESSION['user']['id'];
$message = $_POST['message'];


$db = db_connect();

$date = date('Y-m-d h:m:s');
if ($tweet = $db->query("SELECT * FROM `messages` WHERE `message` = '$message'")) {
    $message_row = $tweet->fetch_assoc();
    $db->query("INSERT INTO `messages` ( `user_id`, `message`, `createtime_message`) VALUES ( '$user_id', '$message', '$date')");
} else {
    echo db_error(__LINE__ . ':' . __FILE__, $db);
}

if ($user_message_array = $db->query("SELECT * FROM `messages` WHERE `user_id` = '$user_id' ORDER BY `id` DESC LIMIT 3")) {
    $show_user_message = $user_message_array->fetch_assoc();
}

if ($user_name_array = $db->query("SELECT `id`, `name` FROM `users` WHERE `id` = '$user_id'")) {
    $show_user_name = $user_name_array->fetch_assoc();
}


$user_name = $show_user_name['name'];
$user_message = $show_user_message['message'];

$db->close();

include 'template/auth.html';