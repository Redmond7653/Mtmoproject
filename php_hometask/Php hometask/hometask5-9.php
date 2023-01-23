<?php

$test = '1a2b3c4b5d6e7f8g9h0';

$cut = substr($test,3,5);

$result = str_replace("$cut","!!!", "$test");

echo $result;