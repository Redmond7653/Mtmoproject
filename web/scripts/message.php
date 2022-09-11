<?php

$name = $_POST['name'];
$message = $_POST['message'];
$file = "file.txt";
$user_name = "Ім'я - ";
$user_message = "Повідомлення - ";
$Saved_File = fopen($file, 'a+');
fwrite($Saved_File, $user_name . $message .  "\n" );
fwrite($Saved_File, $user_message. $message . "\n");
fwrite($Saved_File, date("F j, Y, g:i a") ."\n"."\n");
fclose($Saved_File);

$db = db_connect();

$date = date('Y-m-d h:m:s');
if ($result = $db->query("SELECT * FROM `messages` WHERE `name` = '$name'")) {
    $user = $result->fetch_assoc();
    $db->query("INSERT INTO `messages` (`name`, `message`, `createtime_message`) VALUES ( '$name', '$message', '$date')");
} else {
    echo db_error(__LINE__ . ':' . __FILE__, $db);
}

$db->close();

include 'template/auth.html';