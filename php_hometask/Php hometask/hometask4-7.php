<?php

function isEven($a) {
    if ($a % 2 == 0) {
        return true;
    } else {
        return false;
    }
}

$numbers = [1,3,4,5,6,8,10,11,13,14];

function new_ar($b) {
    $arr = [];
    foreach ($b as $test) {
        if (isEven($test)) {
            $arr[] = $test;
        }
    }
    print_r($arr);
}

new_ar($numbers);