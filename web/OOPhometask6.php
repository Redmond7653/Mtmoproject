<?php

class Product {
    private $name;
    private $price;
    private $quantity;

    function __construct($name,$price,$quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName(){
        return $this->name;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getQua(){
        return $this->quantity;
    }

    public function getCost(){
        return $this->getPrice() * $this->getQua();
    }
}


class Cart {


    public $products;

    public function add($name,$price,$quantity) {
        $this->products[] = new Product($name,$price,$quantity);
    }

    public function getTotalCost() {
        $totalcost = 0;
        foreach ($this->products as $product) {
            $totalcost += $product->getCost();
        }
        return $totalcost;
    }

}

$corn = new Product('Кукуруза', 20,2);
//$milk = new Product("Молоко", 25,3);

$list = new Cart;

$list->products[]= $corn;

$list->add('carrot', 25,10);

$test = $corn->getPrice();

$list->getTotalCost();


echo "<pre>";
var_export($list);
echo "</pre>";



