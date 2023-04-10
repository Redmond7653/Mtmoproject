<?php

$date = time();

$past = new DateTime("2000-03-15 13:12:59");


$dif = $date - $past->getTimestamp();

echo $dif;
