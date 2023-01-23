<?php

function isNumberInRange($a) {
    if ($a > 0 && $a < 10) {
        return true;
    } else {
        return false;
    }
}

isNumberInRange(3);