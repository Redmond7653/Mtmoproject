<?php

$array = [1,2,3,4,5];

array_splice($array,4,0, ['c']);

array_splice($array,6,0, ['e']);

array_splice($array,1,0, ['a','b']);

var_dump($array);

