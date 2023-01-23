<?php

$arr = array(
    "ru"=>array("1"=>"Понеділок","Вівторок", "Середа", "Четвер", "Пятниця", "Субота", "Неділя"),
    'en'=>array("1"=>'Monday','Tuesday','Wednesday', 'Thursday','Friday','Saturday','Sunday')
);

$lang = "ru";

$day = 3;

echo $arr[$lang][$day];