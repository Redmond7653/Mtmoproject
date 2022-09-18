<?php

$user_id = $_SESSION['user']['id'];
$message = $_POST['message'];


$db = db_connect();

$date = date('Y-m-d h:m:s');
if ($tweet = $db->query("SELECT * FROM `messages` WHERE `message` = '$message'")) {
    $message_row = $tweet->fetch_assoc();
    $db->query("INSERT INTO `messages` ( `user_id`, `message`, `createtime_message`) VALUES ( '$user_id', '$message', '$date')");
} else {
    echo db_error(__LINE__ . ':' . __FILE__, $db);
}

if ($user_name_array = $db->query("SELECT `id`, `name` FROM `users` WHERE `id` = '$user_id'")) {
    $show_user_name = $user_name_array->fetch_assoc();
}


$user_name = $show_user_name['name'];
//$test_array = $user_array;
//foreach ($test_array as $user_elements) {
//    $user_message = $user_elements[2];
//}



$db->close();

//for ($show_user_message['id'] = $show_user_message['id'] - 10; $show_user_message['id'] <= $show_user_message['id'] + 10; $show_user_message['id']++) {
//    $user_message = $show_user_message['message'];
//}


//$test_array = $show_user_message;
//foreach ($test_array as $show_user_message['id']) {
//    foreach ($show_user_message['id'] as $show_user_message['message']){
//        $user_message = $show_user_message['message'];
//    }
//}

include 'template/auth.html';