<?php


function getFridays($year, $format, $timezone = "UTC")
{
    $fridays = array();
    $startDate = new DateTime("{$year}-01-01 Friday", new DateTimezone($timezone));
    $year++;
    $endDate = new DateTime("{$year}-01-01", new DateTimezone($timezone));
    $int = new DateInterval('P7D');
    foreach (new DatePeriod($startDate, $int, $endDate) as $d) {
        $fridays[] = $d->format($format);
    }

    return $fridays;
}

$fridays = getFridays('2010', 'F j, Y, g:i a T', 'America/New_York');
print_r($fridays);
