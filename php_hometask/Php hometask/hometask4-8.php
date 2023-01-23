<?php

function apples($a,$b,$c,$d) {
    if ($a == 1) {
        echo $a.' '.$b;
    } elseif ($a > 1 && $a <= 4) {
        echo $a.' '.$c;
    } elseif ($a >= 5) {
        echo $a.' '.$d;
    }
}

apples(6,'яблуко', 'яблука', 'яблук');