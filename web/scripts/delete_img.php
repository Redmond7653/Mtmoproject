<?php

$db = db_connect();

$q = "DELETE FROM `images` WHERE `message_id` = '{$_REQUEST['message_id']}' AND `img` = '{$_REQUEST['message_img']}'";
$delete_img = $db->query($q);

//echo "<pre>";
//echo $q;
//echo "</pre>";
//die;



$db->close();

//include 'template/change_message_old.html';
$_SESSION['render'][] = [
    '#template' => 'change_message',
    '#data' => [
        // todo: $message_id, $user_message are undefined
        'message_id' => $message_id,
        'user_message' => $user_message,
        // todo: wrong function naming
        'user_images' => edit_user_image(),
    ],

];
