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
        include 'template/messages.html';
        break;
    case 'edit_user_message':
        include 'template/change_message.html';
        break;
    case 'edit_message':
        include 'scripts/change.message.php';
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
             ]
           );
//            include 'template/messages.html';
        }
}
