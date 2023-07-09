<?php

class Employee{
    public $name, $age, $salary;
    function __construct ($name, $age, $salary) {
        $this->name = $name;
        $this->age = $age;
        $this->salary = $salary;
    }

    function getName() {
        return $this->name;
    }
    function getAge() {
        return $this->age;
    }
    function getSalary() {
        return $this->salary;
    }
    function checkAge() {
        if ($this->age > 18) {
            return true;
        } else {
            return false;
        }
    }
    function setAge($ag) {
        if ($ag >= 18) {
            $this->age = $ag;
        }
    }
}

$tom = new Employee("Bob",25,1500);
$tom1 = new Employee("Tom",21,3500);
$tom->setAge(7);

echo $tom->getSalary() + $tom1->getSalary();