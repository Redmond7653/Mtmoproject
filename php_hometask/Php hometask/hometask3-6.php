<?php

$arr = [2,5,9,15,0,4];

foreach ($arr as $test) {
    if ($test > 3 && $test < 10) {
        echo $test;
    }
}