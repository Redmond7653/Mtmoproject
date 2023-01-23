<?php

$arr = [1,2,5,9,4,13,4,10];

foreach ($arr as $test) {
    if ($test == 4) {
        echo 'Є!';
        break;
    }
}