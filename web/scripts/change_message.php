<?php


$db = db_connect();

$change_message = $db->query("UPDATE `messages` SET `message` = '{$_POST['message']}' WHERE `id` = '{$_REQUEST['id']}'");



$db->close();

include 'template/change_message.html';