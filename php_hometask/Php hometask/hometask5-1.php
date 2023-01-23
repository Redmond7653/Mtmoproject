<?php

$password = 12345678;

if (strlen($password) > 5 && strlen($password) < 15) {
    echo 'Ваш пароль підходить';
} else {
    echo 'Придумайте новий пароль';
}