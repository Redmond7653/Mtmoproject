<?php

$array = [1,2,3,4,5];

$first_step = array_slice($array,1);

$result = array_slice($first_step, 0,3);

print_r($result);