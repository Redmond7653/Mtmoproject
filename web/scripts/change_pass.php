<?php
  
  use MyClasses\Db;
  use MyClasses\User;
  use MyClasses\Template;
  
$current_pass = $_POST['current_pass'] ?? '';
$new_pass = $_POST['new_pass'] ?? '';
$confirm_pass = $_POST['confirm_pass'] ?? '';
$current_pass2 = md5($current_pass."Russia_is_a_terrorist");

$db = new Db();


if (isset($_POST['new_pass'])) {
    if (!empty($_POST)) {
        $all_ok = TRUE;
        if (strlen($current_pass) < 5 || strlen($current_pass) > 100) {
            echo "Недопустима довжина теперішнього пароля<br>";
            $all_ok = false;
        }
        if (strlen($new_pass) < 2 || strlen($new_pass) > 8) {
            echo "Недопустима довжина нового пароля<br>";
            $all_ok = false;
        }
        if (!$all_ok) {
            exit;
        }
    }

    $pass_changed = false;

    if ($result = $db->query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']->getId()}' AND `pass` = '$current_pass2'")) {
        $user_pass = $result->fetch_all(MYSQLI_ASSOC);
        if ($new_pass == $confirm_pass && count($user_pass) !== 0) {
            $new_pass = md5($new_pass."Russia_is_a_terrorist");
          $user = new User;
          $user->load($_SESSION['user']->getId());
          $user->setPass($new_pass);
        } else {
            echo 'Паролі не співпадають';
        }


        $all_ok = TRUE;
        if (count($user_pass) == 0) {
            echo "Теперішній пароль введенний неправильно";
            $all_ok = false;
        }
        if (!$all_ok) {
            exit;
        }
        
        if ($user_pass) {
            _template('password_saving_confirmed');
        }
    }
}

else {
  _template('change_pass');
}

// To do: Create: change user login
// To do: Create: change user email with validation
// To do: Create method: "create_user" in class User (file User.php)
// To do: Change methods naming to be a more appropriate in class User (file User.php)
// To do: After create method: "create_user" in class User - recreate with it changing pass in file: "change_pass.php"

