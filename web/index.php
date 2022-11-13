<?php
session_start();
$_SESSION['render'] = [];
$_SESSION['render'][] = [
    '#template' => '_header',
    '#weight' => 0,
];

unset($_SESSION['show_user_message']);

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
        include 'scripts/upload.php';
        break;


    case 'change_pass':
        include 'scripts/change_pass.php';
        break;

    case 'confirm_password':
        include "scripts/confirm_pass.php";
        break;

    case 'show_user_message':
//        include 'template/messages.html';
        $_SESSION['render'][] = [
            '#template' => 'messages',
            '#data' => [
                'user_messages' => show_user_messages($_SESSION['user']['id']),
            ],
            '#weight' => 0,
        ];
        break;

    case 'chosen_user_message':
        $_SESSION['show_user_message'] = $_POST['user_id'];
//        include 'template/chosen_user_message.html';
        $_SESSION['render'][] = [
            '#template' => 'chosen_user_message',
        ];
        break;

    case 'show_custom_message':
//        include 'template/show_custom_message.html';
        $_SESSION['render'][] = [
            '#template' => 'show_custom_message',
        ];
        break;

    case 'show_select_pictures':
        $picture = $_POST['picture_name'];
//        include 'template/select_picture.html';
        $_SESSION['render'][] = [
            '#template' => 'select_picture',
        ];
        break;

    case 'upload_image':
        include 'scripts/upload.php';
        break;

    case 'go_to_upload_image':
//        include 'template/upload_images.html';
        $_SESSION['render'][] = [
            '#template' => 'upload_images',
        ];
        break;

    case 'go_to_selected_image':
//        include 'template/select_picture.html';
        $_SESSION['render'][] = [
            '#template' => 'select_picture',
        ];
        break;


    case 'change_user_message':
//        $message_id = $_REQUEST['message_id'];
//        $user_message = $_REQUEST['user_message'];
//        include 'template/change_message.html';
        $_SESSION['render'][] = [
            '#template' => 'change_message',
            '#data' => [
                'message_id' => $_REQUEST['message_id'],
                'user_message' => $_REQUEST['user_message'],
                // todo: wrong function naming
                'user_images' => edit_user_image(),
            ],

        ];

        break;

    case 'edit_message':
        include 'scripts/change_message.php';
        include 'scripts/upload_img.php';
        break;

    case 'delete_img':
        $user_message_id = $_REQUEST['message_id'];
        $user_message_image = $_REQUEST['message_img'];
        include 'scripts/delete_img.php';
        break;

    default:
        if (isset($_GET['custom_message']) || isset($_POST['custom_message'])) {
//            include 'template/custom_message.html';
            $_SESSION['render'][] = [
                '#template' => 'custom_message',
            ];

            break;
        }
        if (!empty($_SESSION['user'])) {
//            include 'template/messages.html';
            $_SESSION['render'][] = [
                '#template' => 'messages',
                '#data' => [
                    'user_messages' => show_user_messages($_SESSION['user']['id']),
                ],
                '#weight' => 0,
            ];
        }
        if (empty($_SESSION['user'])) {
//            include 'template/auth.html';
            $_SESSION['render'][] = [
                '#template' => 'auth',
            ];
        }

}

$_SESSION['render'][] = [
    '#template' => '_footer',
    '#weight' => 0,
];

render_page();
