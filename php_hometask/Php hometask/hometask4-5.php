<?php

function isNumberInRange($a) {
    if ($a > 0 && $a < 10) {
        return true;
    } else {
        return false;
    }
}


$numbers = [1,2,6,9,3,11,15,13];

function new_array($a) {
    $new = [];
    foreach ($a as $test) {
            if (isNumberInRange($test)) {
                $new[] = $test;
            }
        }
     print_r($new);
}

new_array($numbers);