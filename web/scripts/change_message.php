<?php

$message = $_POST['message'];

$test = $_REQUEST['id'];

$db = db_connect();

$change_message = $db->query("UPDATE `messages` SET `message` = '$message' WHERE `id` = '$test'");


$db->close();

include 'template/change_message.html';