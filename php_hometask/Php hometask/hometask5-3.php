<?php

$test = 'Sixteen';

if (strlen($test) > 5) {
    $rest = substr($test, 5);
    $dots = '...';
    $result = $rest.$dots;
    echo $result;
} else {
    echo $test;
}