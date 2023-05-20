<?php

$arr = [1,2,3,4,5,6,7,8,9];

$n = '';

foreach ($arr as $test) {
//    $project_array = '-'.$project_array;
//    echo '-'.$project_array;
    $n .= '-'.$test;;
}

$n .= '-';
echo $n;

