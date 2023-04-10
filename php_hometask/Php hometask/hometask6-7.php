<?php



function das($day = null) {
    $week = [1 => 'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'Пятниця', 'Субота', 'Неділя'];
    if ($day == null) {
        $date = date("w",time());
    } else {
        $date = date("w", strtotime($day));
    }
    return $week[$date];
}

/*

Вписувати вхідний параметр як дату потрібно за зразком - '1999.06.06'

*/


echo das('1999.02.23');



