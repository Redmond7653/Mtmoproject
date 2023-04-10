<?php


$connect = mysqli_connect('mariadb', 'drupal', 'drupal', 'drupal');

if (!$connect) {
    die('Error');
}