<?php


$test = '1a2b3c4b5d6e7f8g9h0';

$test = preg_replace('/[0-9]+/', '', $test);

echo $test;