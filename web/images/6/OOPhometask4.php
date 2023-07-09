<?php

class ArraySumHelper
{
    public $elem, $elem1, $elem2;

    function __construct($elem, $elem1, $elem2)
    {
        $this->elem = $elem;
        $this->elem1 = $elem1;
        $this->elem2 = $elem2;
    }
    public function getAvg1($arr){
        $sum = 0;
        foreach ($arr as $value) {
            $sum += $value;
        }
        echo $sum;
    }
    public function getAvg2($arr) {
        $sum = 0;
        foreach ($arr as $value) {
            $sum += pow($value,2);
        }
        $sqrt = sqrt($sum);
        echo $sqrt;
    }
    public function getAvg3($arr) {
        $sum = 0;
        foreach ($arr as $value) {
            $sum += pow($value,3);
        }
        $kub = pow($sum,1/3);
        echo $kub;
    }
    public function getAvg4($arr) {
        $sum = 0;
        foreach ($arr as $value) {
            $sum += pow($value,3);
        }
        $square = pow($sum,1/4);
        echo $square;
    }
}

$test = new ArraySumHelper(3,5,6);

$arr = (array)$test;

echo $test->getAvg3($arr);