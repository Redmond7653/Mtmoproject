<?php

include "connect.php";

$result = mysqli_query($connect, "SELECT * FROM `php_task`");

$user_messages = $result->fetch_all(MYSQLI_ASSOC);


//    $user_array = [];
//    $count = count($user_messages);
//    for ($p = 0; $p < $count; $p++) {
//        $user_array[$p]['id'] = $user_messages[$p]['id'];
//        $user_array[$p]['ip'] = $user_messages[$p]['ip'];
//        $user_array[$p]['email'] = $user_messages[$p]['email'];
//        $user_array[$p]['text'] = $user_messages[$p]['text'];
//        $user_array[$p]['data'] = $user_messages[$p]['data'];
//    }

?>

<div>
    <h1>Головна сторінка</h1>
</div>

<form action="/index.php" method="post">
    <input type="submit" value="Написати відгук">
</form>


<!--<table>-->
<!--    <tr>-->
<!--        <th>ID користувача</th>-->
<!--        <th>IP користувача</th>-->
<!--        <th>Електронна пошта</th>-->
<!--        <th>Текст відгуку</th>-->
<!--        <th>Дата та час</th>-->
<!--    </tr>-->
<!--    --><?php //for ($i=0; $i<count($user_messages); $i++) : ?>
<!--    <tr>-->
<!--        <td style="padding: 10px">--><?php //=$user_messages[$i]['id']?><!--</td>-->
<!--        <td>--><?php //=$user_messages[$i]['ip']?><!--</td>-->
<!--        <td>--><?php //=$user_messages[$i]['email']?><!--</td>-->
<!--        <td>--><?php //=$user_messages[$i]['text']?><!--</td>-->
<!--        <td>--><?php //=$user_messages[$i]['data']?><!--</td>-->
<!--    </tr>-->
<!--    --><?php //endfor; ?>
<!--</table>-->


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
