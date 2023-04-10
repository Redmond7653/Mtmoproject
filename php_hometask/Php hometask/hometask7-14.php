<?php

$array = range('a','z');

$array1 = range('1','26');

$result = array_combine($array,$array1);

var_dump($result);