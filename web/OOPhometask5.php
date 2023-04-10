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

class Driver extends Employee {
    public $stash, $category;
    function __construct($name, $age, $salary, $stash,$category)
    {
        $this->name = $name;
        $this->age = $age;
        $this->salary = $salary;
        $this->stash = $stash;
        $this->category = $category;
    }
    function getStash() {
        return $this->stash;
    }
    function getCategory() {
        return $this->category;
    }
    function setStash($sta) {
        $this->stash = $sta;
    }
    function setCategory($cat) {
        $this->stash = $cat;
    }
}

$tom = new Driver("Bob", "23", "2000", "10", "A");

var_dump($tom);