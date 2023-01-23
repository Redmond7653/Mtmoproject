<?php

$test = '1a.2b.3c.4b..5d.6e.7f.8g.9h..0';

$find = '..';

$result = strpos("$test","$find");

if ($result == true) {
    echo 'Yes';
} else {
    echo 'No';
}