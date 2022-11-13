<?php


$db = db_connect();

$change_message = $db->query("UPDATE `messages` SET `message` = '{$_POST['message']}' WHERE `id` = '{$_REQUEST['id']}'");



$db->close();

//include 'template/messages.html';
$_SESSION['render'][] = [
    '#template' => 'messages',
    '#data' => [
        'user_messages' => show_user_messages($_SESSION['user']['id']),
    ],
    '#weight' => 0,
];
