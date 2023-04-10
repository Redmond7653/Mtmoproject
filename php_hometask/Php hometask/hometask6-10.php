<?php

$date = "2025-12-31";

$date_after1 = date('Y-m-d', strtotime("+2 days", strtotime($date)));
$date_after2 = date('Y-m-d', strtotime("+1 month, +3 days", strtotime($date)));
$date_after3 = date('Y-m-d', strtotime("+1 year", strtotime($date)));
$date_after4 = date('Y-m-d', strtotime("-3 days", strtotime($date)));

echo $date_after1."<br>";
echo $date_after2."<br>";
echo $date_after3."<br>";
echo $date_after4."<br>";