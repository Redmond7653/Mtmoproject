<?php

require_once 'message_load_class.php';




$user_id = $_SESSION['user']->getId();
$message = $_POST['message'];

$user_message = new Message;
$user_message->load($message,$user_id);

//$test1 = new Messages();
//$test1->get_current_user_messages($_SESSION['user']->getId());

include 'template/message_send.html';