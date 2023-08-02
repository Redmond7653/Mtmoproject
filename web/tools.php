<?php

use MyClasses\User;
use MyClasses\Db;
use MyClasses\Message;
use MyClasses\Template;



function array_part_of_user_messages() {
  if ($_SESSION['user']) {
    
    $show_part_of_messages = new Message();
    $user_array_messages = $show_part_of_messages->show_current_user_messages($_REQUEST['key']); // $olsdjfgoljnsgrouyt83745683475
    foreach ($user_array_messages as $key => $message) {
      $user_array_messages[$key]['image_src'] = get_image_for_message($message['id']);
    }
    
    return $user_array_messages;
  }
  return [];
}

//function part_of_user_messages() {
//  $template = new Template();
//  $template->include('template/one_message.html');
//}

  function _template($file, $render = []) {
    $template = new Template();
    $template->include("template/".$file.".html", $render);
  }
  
function get_pages_number($user_id = NULL, $limit = 5)
{

    $page_number = get_messages_number($user_id) / $limit;
    $what_left = get_messages_number($user_id) % $limit;
    if ($what_left) {
        $page_number = $page_number + 1;
        return $page_number;
    } else {
        return $page_number;
    }
}

function get_messages_number($user_id)
{
    $db = new Db();
    if ($user_message_array1 = $db->query("
            SELECT COUNT(id) AS cnt
            FROM `messages` 
            WHERE `user_id` = '{$user_id}'
            "
    )) {
        $user_count_messages = $user_message_array1->fetch_array()[0];
    }

    return $user_count_messages;
}


function get_page_header() {
    $page = 1;
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    }
    $page = $page - 1;
    $page_number = "<h2>Page ".($page + 1)."</h2>";
    return $page_number;
}

function get_image_for_message($message_id) {
    $db = new Db();

    $result = $db->query("SELECT * FROM `images` WHERE `message_id` = '$message_id'");

    $image_arrays = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($image_arrays as $image_array ) {
      $image_path[] = $image_array['img'];
    }
    return $image_path;

}

function load_message_for_edit($id) {
  $edit = new Message();
  $edit->load_data_message($id);
  $data = $edit->getUserArray();
  return $data['message'];
}
  
function load_image_for_edit($id) {
    $edit = new Message();
    $edit->load_data_message($id);
    $data = $edit->getUserArray();
    
    return $data['img'];
}

function all_users() {
  $db = new Db();
  
  $result = $db->query("SELECT * FROM `users`");
  $users_array = $result->fetch_all(MYSQLI_ASSOC);
  $user_login_array = [];
  foreach ($users_array as $user_array) {
    $key_id = $user_array['id'];
    $user_login_array[$key_id] = $user_array['login'];
  }
  return $user_login_array;
}




