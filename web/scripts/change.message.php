<?php

use MyClasses\Db;
use MyClasses\Template;

$db = new Db;

$result = $db->query("UPDATE `messages` SET `message` = '{$_POST['message']}' WHERE `id` = '{$_REQUEST['id']}'");
  
  $template = new Template();
  $template->include('template/message_send.html');