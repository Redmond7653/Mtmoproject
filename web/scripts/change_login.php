<?php
  
  use MyClasses\Db;
  use MyClasses\User;
  use MyClasses\Template;
  
  $new_login = $_POST['new_login'] ?? '';
  
  $db = new Db();
  
  
  if (isset($_POST['new_login'])) {
    if (!empty($_POST)) {
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
    
    if ($result = $db->query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']->getId()}'")) {
      $user_login = $result->fetch_all(MYSQLI_ASSOC);
      if (count($user_login) !== 0)   {
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
  
  else {
    _template('change_login');
  }