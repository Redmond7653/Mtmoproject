<?php

$test = '1a2b3c4b5d6e7f8g9h0';

$first_change = str_replace("a", "1", $test);

$second_change = str_replace("b","2","$first_change");

$third_change = str_replace("c","3","$second_change");

echo $third_change;