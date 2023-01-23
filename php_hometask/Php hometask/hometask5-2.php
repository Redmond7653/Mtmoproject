<?php

$test = 'https://www.google.com/';

if (strpos($test, 'http://') === 0) {
    echo 'Yes';
} else {
    echo 'No';
}