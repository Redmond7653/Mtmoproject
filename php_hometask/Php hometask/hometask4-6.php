<?php

function isEven($a) {
    if ($a % 2 == 0) {
        echo 'Yes';
        return true;
    } else {
        echo 'No';
        return false;
    }
}

isEven(3);

