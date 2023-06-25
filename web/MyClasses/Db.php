<?php

namespace MyClasses;

class Db
{
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function connect() {
        if (!$this->connection) {
            $this->connection = mysqli_connect('mariadb', 'drupal', 'drupal', 'drupal');
        }
        return $this->connection;
    }

    public function escape_string($string) {
        return $this->connection->real_escape_string($string);
    }

    public function query($q) {
        return mysqli_query($this->connection, $q);
    }

}