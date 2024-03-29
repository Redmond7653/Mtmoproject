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
      $user_array_messages[$key]['reply_check'] = check_for_reply_message($message['id']);
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

function check_for_reply_message($message_id) {
  $db = new Db();
  
  $result = $db->query("SELECT * FROM `messages` WHERE `id` = '$message_id'");
  
  $reply_array = $result->fetch_assoc();
  
  if (!empty($reply_array['reply_message'])) {
    return true;
  } else {
    return false;
  }
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

function one_message($message_id) {
  $db = new Db();
  $one_message_array = [];
  $result_message = $db->query("SELECT * FROM `messages` WHERE `id` = '$message_id'");
  $result_image = $db->query("SELECT * FROM `images` WHERE `message_id` = '$message_id'");
  $result_hashtags = $db->query("SELECT * FROM `hashtags` WHERE `message_id` = '$message_id'");
  
  $one_message_array = $result_message->fetch_assoc();
  $messages_image = $result_image->fetch_all(MYSQLI_ASSOC);
  $messages_hashtags = $result_hashtags->fetch_all(MYSQLI_ASSOC);
  
//  $one_message_array['message'] = $message_array['message'];
  
  
  foreach ($messages_image as $message_image) {
    $id = $message_image['id'];
    $one_message_array['img'][$id] = $message_image['img'];
  }
  foreach ($messages_hashtags as $message_hashtag) {
    $one_message_array['hashtags'][] = $message_hashtag['hashtag'];
  }
  
  $one_message_array['replies'] = load_reply_messages($one_message_array['id']);
  
  return $one_message_array;
}

function show_hashtags($message_id) {
  $db = new Db();
  
  $hashtags = [];
  $result_hashtags = $db->query("SELECT * FROM `hashtags` WHERE `message_id` = '$message_id'");
  
  $hashtags_arrays = $result_hashtags->fetch_all(MYSQLI_ASSOC);
  
  $special_character = '#';
  foreach ($hashtags_arrays as $hashtags_array) {
    if (mb_substr($hashtags_array['hashtag'],0,1) == '#') {
      $hashtags[] = $hashtags_array['hashtag'];
    } else {
      $hashtags_array['hashtag'] = $special_character.$hashtags_array['hashtag'];
      $hashtags[] = $hashtags_array['hashtag'];
    }
//    $test = mb_substr($hashtags_array['hashtag'],0,1);
  }
  return $hashtags;
}

function load_hashtags_for_edit($id) {
  $db = new Db();
  
  $hashtags = [];
  $result = $db->query("SELECT * FROM `hashtags` WHERE `message_id` = '$id'");
  
  $hashtags_data_array = $result->fetch_all(MYSQLI_ASSOC);
  
  foreach ($hashtags_data_array as $hashtags_array) {
    $hashtag_id = $hashtags_array['id'];
    $hashtags[$hashtag_id] = $hashtags_array['hashtag'];
  }
  
  return $hashtags;
}



function load_reply_messages($parent_id) {
  $db = new Db();
  
  $reply_messages_array = [];
  
  $result_messages = $db->query("SELECT id FROM `messages` WHERE `reply_message` = '$parent_id'");
  
  while ($row = $result_messages->fetch_assoc()) {
    $reply_messages_array[$row['id']] = one_message($row['id']);
  }
  
//  $result_messages_arrays = $result_messages->fetch_all(MYSQLI_ASSOC);
//
//  foreach ($result_messages_arrays as $result_array) {
//    $key = $result_array['id'];
//    $reply_messages_array[$key] = $result_array;
//
//    $result_img = $db->query("SELECT * FROM `images` WHERE `message_id` = '{$key}'");
//
//    $result_img_arrays = $result_img->fetch_all(MYSQLI_ASSOC);
//
//    $result_hashtags = $db->query("SELECT * FROM `hashtags` WHERE `message_id` = '{$key}'");
//
//    $result_hashtags_arrays = $result_hashtags->fetch_all(MYSQLI_ASSOC);
//
//    foreach ($result_img_arrays as $key => $result_img_array) {
//
//        $reply_messages_array[$key]['img'][] = $result_img_array['img'];
//
//    }
//
//    foreach ($result_hashtags_arrays as $result_hashtags_array) {
//
//      $reply_messages_array[$key]['hashtags'][] = $result_hashtags_array['hashtag'];
//
//    }
//
//  }
  
  return $reply_messages_array;
}