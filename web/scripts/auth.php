<?php

use MyClasses\User;
use MyClasses\Db;
use MyClasses\Template;
use MyClasses\Message;

$login = $_POST['login'] ?? '';
$pass = $_POST['pass'] ?? '';

if (!empty($_POST)) {
    $good = true;
    if (strlen($login) < 5 || strlen($login) > 100) {
        echo "Недопустима довжина емейлу<br>";
        $good = false;
    }
    if (strlen($pass) < 2 || strlen($pass) > 8) {
        echo "Недопустима довжина пароля<br>";
        $good = false;
    }
    if (!$good) {
        exit;
    }
}

$pass = md5($pass."Russia_is_a_terrorist");




//$result = mysqli_query($connect,"SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
//$user = $result->fetch_assoc();



$user = new User;
$user->load($login, $pass);



$good = true;
if (empty($user->getName())) {
    echo "Такий користувач не знайдений";
    $good = false;
}
if(!$good) {
    exit;
}


$_SESSION['user'] = $user;

//$test1 = new Messages();
//$test2 = $test1->get_current_user_messages($_SESSION['user']->getId());
//require_once 'tools.php';
//include 'template/messages.html';

//$template = new Template();
//$template->include('template/messages.html',$user_array_messages, $page_number, $user_name);
_template(
  'messages', [
    'message_list' => array_part_of_user_messages(),
    'messages_number' => get_messages_number($_SESSION['user']->getId()),
    'page_number' => get_pages_number($_SESSION['user']->getId()),
    'page_header' => get_page_header(),
    ]
);