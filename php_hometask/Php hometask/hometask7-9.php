<?php

$array = ['a','-','b','-','c','-','d'];

$key = array_search('-',$array);

array_splice($array,$key);

var_dump($array);

/* Не розумію що далі тут треба робити