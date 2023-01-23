<?php

$arr = [1,2,3,4,5];

$result = 0;
foreach ($arr as $test) {
    $test = pow($test, 2);
    $result = $result + $test;
}

echo $result;