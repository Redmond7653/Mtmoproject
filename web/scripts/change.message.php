<?php

use MyClasses\Db;
use MyClasses\Template;
use MyClasses\Image;

$db = new Db;

$result = $db->query("UPDATE `messages` SET `message` = '{$_POST['message']}' WHERE `id` = '{$_REQUEST['id']}'");


$changed_hashtags_array = $_POST['hashtags'];

foreach ($changed_hashtags_array as $key => $hashtag) {
    $db->query("UPDATE `hashtags` SET `hashtag` = '$hashtag' WHERE `id` = '$key' AND `message_id` = '{$_REQUEST['id']}'");
}

  
$user_img = new Image;
$user_img->image_save(NULL,"{$_REQUEST['id']}");

_template('message_send');