<?php

require_once 'user_class.php';

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

include "connect.php";


//$result = mysqli_query($connect,"SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
//$user = $result->fetch_assoc();



$user = new User;
$user->load($login, $pass);
//$test->setName('Denchik');
//$user->setname('yasya');
//
//
//$user->load($id);

$good = true;
if (is_null($user->getName())) {
    echo "Такий користувач не знайдений";
    $good = false;
}
if(!$good) {
    exit;
}


$_SESSION['user'] = $user;

//$test1 = new Messages();
//$test2 = $test1->get_current_user_messages($_SESSION['user']->getId());
require_once 'tools.php';
include 'template/messages.html';