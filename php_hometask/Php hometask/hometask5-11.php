<?php

$test = "Are we not drawn onward, we few, drawn onward to new era?";

$test = str_replace(' ', '', "$test");

$test = preg_replace('/[^A-Za-z0-9\-]/', '', "$test");

$test = strtolower($test);

$reverse = strrev($test);

echo $reverse;