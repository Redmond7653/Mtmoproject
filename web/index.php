<?php

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
    include $class_name . '.php';
});


//require_once 'scripts/Message.php';
require_once 'MyClasses/User_class.php';
session_start();

include 'scripts/connect.php';


if ($_SESSION['user']) {
    require_once 'tools.php';
}

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
    default:
        if (empty($_SESSION['user'])) {
            include 'template/auth.html';
        } else
         {
            include 'template/messages.html';
        }
}
