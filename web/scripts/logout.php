<?php
    unset($_SESSION['user']);
//    include 'template/auth.html';
    $_SESSION['render'][] = [
        '#template' => 'auth',
    ];

?>