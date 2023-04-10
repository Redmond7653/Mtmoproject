<?php

include 'connect.php';

$email = $_POST['email'];
$text = $_POST['text'];
$data = date('Y-m-d h-i-s');
$ip = $_SERVER['REMOTE_ADDR'];

if (empty($email) || empty($text)) {
    echo "Одне з полів пусте";
}  elseif (strlen($text) > 4000) {
    echo "Ваш текст більше 4000 символів, будь-ласка зробіть його меншим";
} else {
    mysqli_query($connect, "INSERT INTO `php_task` (`ip`,`email`,`text`, `data`) VALUES ('$ip','$email','$text', '$data')");
    echo "Дякуюємо за ваш відгук";
}

?>

<form action="main.php" method="post">
    <input type="submit" value="На головну">
</form>


