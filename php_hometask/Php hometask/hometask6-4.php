<?php


$t = strtotime("-100 days");

$test = date("l", $t);

echo $test;