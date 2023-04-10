<?php

class City {
    public $name, $popup;
    function __construct ($name, $popup) {
        $this->name = $name;
        $this->popup = $popup;
    }

}

$arr = [];
$city = new City("Lviv", 1000);
$city1 = new City("Kyiv", 2000);
$city2 = new City("Kovel", 1000);
$city3 = new City("Dnipro", 3000);
$city4 = new City("Odessa", 4000);

$arr[] = (array)$city;
$arr[] = (array)$city1;
$arr[] = (array)$city2;
$arr[] = (array)$city3;
$arr[] = (array)$city4;


foreach ($arr as $test) {
    foreach ($test as $key=>$value){
        echo "$key=>$value"."<br>";
    }
}
