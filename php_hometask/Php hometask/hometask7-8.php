<?php

$array = ['a','b','c','d','e'];

$test = array(0 => '!');
$test1 = array(3=>'!!');

$result = array_replace($array,$test,$test1);

var_dump($result);