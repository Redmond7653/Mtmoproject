<?php

require_once 'scripts/user_class.php';
include "scripts/connect.php";


$user_messages_object = new User();
$user_messages = $user_messages_object->get_current_user_messages($_SESSION['user']->getId());

$user_name = $_SESSION['user']->getName();

$user_messages_object->loaduser($_SESSION['user']->getId());

function get_pages_number($user_id = NULL, $limit = 5)
{
    $page_number = get_messages_number($user_id) / $limit;
    return $page_number;
}

function get_messages_number($user_id = NULL)
{
    include "scripts/connect.php";
    if ($user_message_array1 = mysqli_query($connect,"
            SELECT COUNT(id) AS cnt
            FROM `messages` 
            WHERE `user_id` = '{$user_id}'
            "
    )) {
        $user_count_messages = $user_message_array1->fetch_array()[0];
    }

    return $user_count_messages;
}

