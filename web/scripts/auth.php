<?php


$login = $_POST['login'] ?? '';
$pass = $_POST['pass'] ?? '';

if (!empty($_POST)) {
    $all_ok = TRUE;
    if (strlen($login) < 5 || strlen($login) > 100) {
        echo "Недопустима довжина логіна<br>";
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

$date = date('Y-m-d h:m:s');
if ($result = $db->query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'" )) {

    $user = $result->fetch_assoc();
    $datetime = $db->query("UPDATE `users` SET `last_login` = '$date' WHERE `id` = '{$user['id']}'");
} else {
    echo db_error(__LINE__ . ':' . __FILE__, $db);
}


$all_ok = TRUE;
if (count($user) == 0) {
    echo "Такий користувач не знайдений";
    $all_ok = FALSE;
}
if (!$all_ok) {
    exit;
}



//setcookie('user', $user['name'], time()+ 3600, '/');
$_SESSION['user'] = $user;

$db->close();

include 'template/messages.html';
