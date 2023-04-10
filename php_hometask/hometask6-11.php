<?php

$year = 2015;

$friday = 0;

for ($month = 1; $month <= 12; $month++) {
    $month_days = date('t', mktime(0,0,0,$month,1, $year));
    for ($day = 1; $day<=$month_days; $day++) {
        $a = date('w', mktime(0,0,0,$month,$day,$year));
        if ($a == 5 ) {
            if (date('d',mktime(0,0,0,$month,$day,$year)) == 13) {
                $friday++;
                $friday_date .= date('d.m.Y', mktime(0,0,0,$month, $day, $year));
            }

        }
    }
}
echo $friday." п'ятниці 13 в цьому році";
