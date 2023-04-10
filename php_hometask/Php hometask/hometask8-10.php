<?php


$arr = [];
$array = range(1,1000);
shuffle($array);


foreach ($array as $test) {
    $arr[] = $test;
    if (count($arr) > 10) {
        break;
    }
}

var_dump($arr);
