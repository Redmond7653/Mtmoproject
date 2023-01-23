<?php

function change_text($test, $first_char = false) {
    $result = str_replace(' ', '', ucwords(str_replace('_', ' ', $test)));

    if (!$first_char) {
        $result[0] = strtolower($result[0]);
    }


    return $result;
}

echo change_text('var_test_text');