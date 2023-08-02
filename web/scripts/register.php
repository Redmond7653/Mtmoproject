<?php

use MyClasses\Template;
if (!isset($_POST['email'])) {
//    include 'template/register.html';
  _template('register');
    return;
}

$email = $_POST['email'] ?? '';
$login = $_POST['login'] ?? '';
$pass = $_POST['pass'] ?? '';

if (!empty($_POST)) {
    $good = true;
    if (strlen($email) < 10 || strlen($email) > 50) {
        echo ' Недопустима довжина почти';
        $good = false;
    }
    if (strlen($login) < 3 || strlen($login) > 50) {
        echo 'Недопустима довжина імені';
        $good = false;
    }
    if (strlen($pass) < 2 || strlen($pass) > 30) {
        echo 'Недопустима довжина паролю';
        $good = false;
    }
    if (!$good) {
        exit;
    }
}

$pass = md5($pass."Russia_is_a_terrorist");

include 'connect.php';

$result = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email' AND `login` = '$login'");
$user_exist = $result->fetch_assoc();
if ($user_exist) {
    echo 'Такий користувач уже існує';
} else {
    $time = date('Y-m-d h:m:s');
    $data = mysqli_query($connect, "INSERT INTO `users`(`email`, `login`, `pass`, `create_user_data`) VALUES ('$email','$login', '$pass', '$time')");
}


//$template = new Template();
//$template->include('template/auth.html',$user_array_messages, $page_number, $user_name);
//$template->first_line('template/auth,html');
_template('auth');