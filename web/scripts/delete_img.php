<?php

$db = db_connect();

$q = "DELETE FROM `images` WHERE `message_id` = '{$_REQUEST['message_id']}' AND `img` = '{$_REQUEST['message_img']}'";
$delete_img = $db->query($q);

//echo "<pre>";
//echo $q;
//echo "</pre>";
//die;



$db->close();

include 'template/change_message.html';