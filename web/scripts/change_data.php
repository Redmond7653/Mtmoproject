<?php
  
  use MyClasses\Db;
  use MyClasses\User;
  use MyClasses\Template;
  
  
  $new_email = $_POST['new_email'] ?? '';
  $new_login = $_POST['new_login'] ?? '';
  $new_pass = $_POST['new_pass'] ?? '';
  $current_pass = $_POST['current_pass'] ?? '';
  $confirm_pass = $_POST['confirm_pass'] ?? '';
  $current_pass2 = md5($current_pass."Russia_is_a_terrorist");
  
  
  $db = new Db();
  $user_data = new User;
  $user_data->load($_SESSION['user']->getId());
  
  if (isset($_POST['new_email'])) {
    if (!empty($_POST['new_email'])) {
      $all_ok = TRUE;
      if (strlen($new_email) < 5 || strlen($new_email) > 100) {
        echo "Недопустима довжина нового email<br>";
        $all_ok = false;
      }
      
      if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $all_ok = true;
      } else {
        echo 'Ви ввели не email в рядок "Введіть новий email"';
        _template('default');
        $all_ok = false;
      }
      
      if (!$all_ok) {
        exit;
      }
    }
    
    $email_changed = false;
    
    if (!empty($_POST['new_email'])) {
      if ($result = $db->query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']->getId()}' AND `email` = '{$user_data->getEmail()}'")) {
        $user_email = $result->fetch_all(MYSQLI_ASSOC);
        if (count($user_email) !== 0) {
          $user = new User;
          $user->load($_SESSION['user']->getId());
          $user->setEmail($new_email);
        }
        
        $all_ok = TRUE;
        
        if (!$all_ok) {
          exit;
        }
        
        if ($user_email) {
          _template('email_saving_confirmed');
        }
      }
    }
  }
  
  if (isset($_POST['new_login'])) {
    if (!empty($_POST['new_login'])) {
      $all_ok = TRUE;
      if (strlen($new_login) < 2 || strlen($new_login) > 8) {
        echo "Недопустима довжина нового логіну<br>";
        $all_ok = false;
      }
      if (!$all_ok) {
        exit;
      }
    }
    
    $login_changed = false;
    
    if (!empty($_POST['new_login'])) {
      if ($result = $db->query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']->getId()}' AND `login` = '{$user_data->getName()}'")) {
        $user_login = $result->fetch_all(MYSQLI_ASSOC);
        if (count($user_login) !== 0) {
          $user = new User;
          $user->load($_SESSION['user']->getId());
          $user->setName($new_login);
        }
        
        
        $all_ok = TRUE;
        
        if (!$all_ok) {
          exit;
        }
        
        if ($user_login) {
          _template('login_saving_confirmed');
        }
      }
    }
  }
  
  if (isset($_POST['new_pass'])) {
    if (!empty($_POST['new_pass'])) {
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
  
 
  
  
  
  
 