<?php
    const DB_HOST = 'mariadb';
    const DB_USER = 'drupal';
    const DB_PASS = 'drupal';
    const DB_NAME = 'drupal';
    const PASS_SALT = 'goodluckhavefun';

    function md5pass($pass) {
        return md5($pass . PASS_SALT);
    }

function db_connect() {
    $db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    return $db;
}

function db_error($str, $db = NULL) {
    if (!$db) {
        return 'No database connection!<br>';
    }

    $error = $db->error;
    if (!empty($error)) {
        $str = empty($str) ? '' : $str . " : ";
        return $str . $error . "<br>";
    }

    return '';
}

