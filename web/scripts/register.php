<?php

if (!isset($_POST['login'])) {
   include 'template/register.html';
    return;
}



$login = $_POST['login'] ?? '';
$name = $_POST['name'] ?? '';
$pass = $_POST['pass'] ?? '';

if (!empty($_POST)) {
    $all_ok = TRUE;
    if (strlen($login) < 3 || strlen($login) > 100) {
        echo "Недопустима довжина логіна<br>";
        $all_ok = FALSE;
    }
    if (strlen($name) < 3 || strlen($name) > 50) {
        echo "Недопустима довжина імені<br>";
        $all_ok = FALSE;
    }
    if (strlen($pass) < 2 || strlen($pass) > 8) {
        echo "Недопустима довжина пароля<br>";
        $all_ok = FALSE;
    }
    if (!$all_ok) {
        exit;
    }
}

$pass = md5($pass."goodluckhavefun");

$db = db_connect();


if ($result = $db->query("SELECT * FROM `users` WHERE `login` = '$login'")) {
    $userExists = $result->fetch_assoc();
    if ($userExists) {
        echo 'Такий юзер існує';
    } else {
        $time = date('Y-m-d h:m:s');
        $value = $db->query("INSERT INTO `users` (`login`, `pass`, `name`, `create_date_user`) VALUES ('$login', '$pass', '$name', '$time')");
    }
} else {
    echo db_error(__LINE__ . ':' . __FILE__, $db);
}



$db->close();

include 'template/auth.html';