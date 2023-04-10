<?php

$date1 = "2025-12-31";

$date2 = "2023-11-03";

if (strtotime($date1) > strtotime($date2)) {
    echo "$date1 більша дата";
} else {
    echo "$date2 більша дата";
}
