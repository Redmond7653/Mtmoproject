<?php

$new_year = mktime(0,0,0,1,1,2024);

$today = time();

$dif_in_seconds = $new_year - $today;

$dif_in_days = $dif_in_seconds / 86400;

echo (int)$dif_in_days;
