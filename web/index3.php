<?php


include 'scripts/connect.php';


?>


<div>
    <span>Напишіть ваш відгук</span>
</div>

<form action="/scripts/create.php" method="post">
    <input type="text" name="email" placeholder="Введіть ваш почту">
    <textarea name="text" placeholder="Введіть ваш відгук"></textarea>
    <label>
        <input type="submit" name="submit" value="Відправити">
    </label>
</form>

<form action="/scripts/main.php" method="post">
    <input type="submit" value="На головну">
</form>
