<?php

$number = "1451";

$sum = 0;

for($i = 0; $i < strlen($number); $i++) {
    $sum = $sum + $number[$i];
}

echo $sum
