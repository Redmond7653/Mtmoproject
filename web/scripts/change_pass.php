<?php

$current_pass = $_POST['current_pass'] ?? '';
$new_pass = $_POST['new_pass'] ?? '';
$confirm_pass = $_POST['confirm_pass'] ?? '';
$current_pass2 = md5pass($current_pass);
//if (!empty($_POST)) {
//    $all_ok = TRUE;
//    if (strlen($current_pass) < 5 || strlen($current_pass) > 100) {
//        echo "Недопустима довжина теперішнього пароля<br>";
//        $all_ok = FALSE;
//    }
//    if (strlen($new_pass) < 2 || strlen($new_pass) > 8) {
//        echo "Недопустима довжина нового пароля<br>";
//        $all_ok = FALSE;
//    }
//    if (!$all_ok) {
//        exit;
//    }
//}
// @TODO: save the new passwornd
// @TODO: verify the old password
// @TODO: verify new passwords
$db = db_connect();

if (isset($_POST['new_pass'])) { // /* form_CHANGE_PASS_is_sent*/
    if (!empty($_POST)) {
        $all_ok = TRUE;
        if (strlen($current_pass) < 5 || strlen($current_pass) > 100) {
            echo "Недопустима довжина теперішнього пароля<br>";
            $all_ok = FALSE;
        }
        if (strlen($new_pass) < 2 || strlen($new_pass) > 8) {
            echo "Недопустима довжина нового пароля<br>";
            $all_ok = FALSE;
        }
        if (!$all_ok) {
            exit;
        }
    }

    $pass_changed = FALSE;

    if ($result = $db->query("SELECT * FROM `users` WHERE `id` = {$_SESSION['user']['id']} AND `pass` = '$current_pass2'")) {
        $user = $result->fetch_assoc();
        if ($new_pass == $confirm_pass) {
            $new_pass = md5pass($new_pass);
            $pass_changed = $db->query("UPDATE `users` SET `pass` = '$new_pass' WHERE `id` = {$_SESSION['user']['id']}");
            db_error(__LINE__);
        } else {
            echo 'Паролі не співпадають';
        }


        $all_ok = TRUE;
        if (count($user) == 0) {
            echo "Теперішній пароль введенний неправильно";
            $all_ok = FALSE;
        }
        if (!$all_ok) {
            exit;
        }


//    if (saved) {
//        $pass_changed = TRUE;
//    }


        if ($pass_changed) {
            include 'template/password_saving_confirmed.html';

        }
    }
}
else {
    include 'template/change_pass.html';
}


$db->close();
