<?php

class Employe
{
    public $name;
    public $age;
    public $salary;
}

$test = new Employe();
$test->name = "Jonh";
$test->age = 25;
$test->salary = 1000;

$test1 = new Employe();
$test1->name = "Eric";
$test1->age = 26;
$test1->salary = 2000;

$money = $test->salary + $test1->salary;
$age1 = $test->age + $test1->age;

echo $money."<br>";
echo $age1;