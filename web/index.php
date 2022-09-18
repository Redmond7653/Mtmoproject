<?php
session_start();


if (isset($_SESSION['count'])) {
    $_SESSION['count']++;
} else {
    $_SESSION['count'] = 1;
}

include 'settings.php';
include 'tools.php';


$action = NULL;
if (!empty($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'register':
        include 'scripts/register.php';
        break;

    case 'login':
        include 'scripts/auth.php';
        break;

    case 'logout':
        include 'scripts/logout.php';
        break;

    case 'message':
        include 'scripts/message.php';
        break;

    case 'change_pass':
        include 'scripts/change_pass.php';
        break;

    case 'confirm_password':
        include "scripts/confirm_pass.php";
        break;

    default:
        include 'template/auth.html';
}


