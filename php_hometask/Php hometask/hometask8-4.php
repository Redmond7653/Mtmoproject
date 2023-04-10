<?php

$sum = 0;
$array = [4,2,5,19,13,0,10];

foreach ($array as $test) {
    $sum = $sum + pow($test,2);
}

$sqrt = sqrt($sum);

echo $sqrt;

