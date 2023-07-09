<?php

use \MyClasses\Message;
use MyClasses\Image;
use MyClasses\Template;

$user_id = $_SESSION['user']->getId();
$message = $_POST['message'];

$user_message = new Message;
$user_message->save_message($message,$user_id);

$user_img = new Image;
$user_img->image_save($_SESSION['user']->getId());

//$test1 = new Messages();
//$test1->get_current_user_messages($_SESSION['user']->getId());

$template = new Template();
$template->include('template/message_send.html');

//blablabla('template/message_send.html');
//
//function blablabla($template) {
//  include $template;
//
//}