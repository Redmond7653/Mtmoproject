<?php
error_reporting(E_ALL & ~E_NOTICE);

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
    include $class_name . '.php';
});



use MyClasses\User;
use MyClasses\Template;

session_start();

include 'tools.php';



$action = NULL;
if (!empty($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'register':
        include 'scripts/register.php';
        break;
    case 'login':
        include 'scripts/auth.php';
        break;
    case 'logout':
        include 'scripts/logout.php';
        break;
    case 'message':
        include 'scripts/messages.php';
        break;
    case 'main':
      _template('messages',
        [
          'message_list' => array_part_of_user_messages(),
          'messages_number' => get_messages_number($_SESSION['user']->getId()),
          'page_number' => get_pages_number($_REQUEST['key']),
          'page_header' => get_page_header(),
          'message_preview' => one_message($_REQUEST['message_id'])
          ]
      );
        break;
    case 'edit_user_message':
//        include 'template/change_message.html';
      _template('change_message');
        break;
    case 'edit_message':
        include 'scripts/change.message.php';
        break;
    case 'delete_image':
        include 'scripts/delete_img.php';
        _template('change_message');
        break;
    case 'change_user_data':
        _template('change_user_data');
        break;
    case 'change_confirm':
        include 'scripts/change_data.php';
        break;
    case 'message_form':
        _template('message_form');
        break;
    default:
        if (empty($_SESSION['user'])) {
            include 'template/auth.html';
        } else
         {
           _template(
             'messages',
             [
               'message_list' => array_part_of_user_messages(),
               'messages_number' => get_messages_number($_SESSION['user']->getId()),
               'page_number' => get_pages_number($_REQUEST['key']),
               'page_header' => get_page_header(),
               'user_id' => $_REQUEST['key'],
               'message_preview' => one_message($_REQUEST['message_id'])
             ]
           );
//            include 'template/messages.html';
        }
}
