<?php

include "connect.php";

$result = mysqli_query($connect, "SELECT * FROM `php_task`");

$user_messages = $result->fetch_all(MYSQLI_ASSOC);


?>

<div>
    <h1>Головна сторінка</h1>
</div>

<form action="/index.php" method="post">
    <input type="submit" value="Написати відгук">
</form>

<style>
    table, th, td {
        border: 1px solid black;
    }
</style>

<table>
    <tr>

        <th>ID користувача</th>
        <th>IP користувача</th>
        <th>Електронна пошта</th>
        <th>Текст відгуку</th>
        <th>Дата та час</th>
    </tr>
    <?php foreach ($user_messages as $i => $user_message) : ?>
        <tr>
            <td style="padding: 10px"><?=$user_message['id']?></td>
            <td><?=$user_message['ip']?></td>
            <td><?=$user_message['email']?></td>
            <td><?=$user_message['text']?></td>
            <td><?=$user_message['data']?></td>
        </tr>
    <?php endforeach; ?>
</table>
