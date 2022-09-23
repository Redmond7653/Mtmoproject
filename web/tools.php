<?php

/**
 * Return FALSE if a filed is ok, otherwise return reason of invalidation
 */
function form_field_is_invalid($key){
    switch ($key) {
        case 'Name':

            if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])>0 && strlen($_REQUEST[$key])<3) {
                $_REQUEST[$key] = '';
                return 'the value is not correct';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])){
                return 'the value is empty';
            }
            else return false;
        case 'ID':
            if (isset($_REQUEST[$key]) &&  !is_numeric($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
                $_REQUEST[$key] = '';
                return 'the value is not numeric';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])){
                return 'the value is empty';
            }
            else return false;
        case 'Address':
            if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])>0 && strlen($_REQUEST[$key])<4) {
                $_REQUEST[$key] = '';
                return 'the value is not correct';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])) {
                return 'the value is empty';
            }
            else return false;
        case 'Type':
            if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])>0 && strlen($_REQUEST[$key])<2) {
                $_REQUEST[$key] = '';
                return 'the value is not correct';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])){
                return 'the value is empty';
            }
            else return false;
        case 'Source':
            if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])>0 && strlen($_REQUEST[$key])<5) {
                $_REQUEST[$key] = '';
                return 'the value is not correct';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])){
                return 'the value is empty';
            }
            else return false;

        default:
            return false;
    }
}

function isset_form() {
    return isset($_REQUEST['Name']);
}

function show_user_messages($user_id = NULL, $limit = 5) {
    if (!$user_id) {
        $user_id = $_SESSION['user']['id'];
    }

    $db = db_connect();

    $page = 1;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    }

    $page = $page - 1;
    $offset = $page * $limit;
    if ($user_message_array = $db->query("
            SELECT * 
            FROM `messages`
            WHERE `user_id` = '{$user_id}' 
            ORDER BY `id` DESC
            LIMIT {$offset}, {$limit}
            "
    )) {
        $show_user_messages = $user_message_array->fetch_all(MYSQLI_ASSOC);
    }
    db_error(__LINE__, $db);


    $user_messages = "<h2>Page ".($page+1)."</h2>";
    foreach ($show_user_messages as $user_array) {
        $user_messages .= "<div>".nl2br($user_array['message'])."</div><hr>";
    }

    $db->close();

    return $user_messages;
}

function get_pages_number($user_id = NULL, $limit = 5) {
    $page_number = get_messages_number($user_id)/$limit;
    // @todo: return actual numbers of pages for this user
    return $page_number;
}

function get_messages_number($user_id = NULL) {
    $db = db_connect();
    if ($user_message_array1 = $db->query("
            SELECT COUNT(id) AS cnt
            FROM `messages` 
            WHERE `user_id` = '{$user_id}'
            "
    )) {
        $user_count_messages = $user_message_array1->fetch_array()[0];
    }

    $db->close();
    return $user_count_messages;
}

function get_custom_message() {

    if (isset($_GET['custom_message']) || isset($_POST['custom_message'])) {
        $db = db_connect();

//        $id_number = $_POST['custom_message'] ?? $_GET['custom_message'] ?? FALSE;
        $id_number = $_POST['custom_message'] ?? $_GET['custom_message'];




        $method = isset($_POST['custom_message']) ? "_POST_" : "_GET_";

        if ($user_custom_message_array = $db->query("SELECT * FROM `messages` WHERE `id` = '$id_number'")) {
            $custom_message_array = $user_custom_message_array->fetch_assoc();
        }
        $custom_message = "<h3>Message #{$custom_message_array['id']}, method {$method}</h3>";
        $custom_message .= "<div>".$custom_message_array['message']."</div>";
        $custom_message .= "<hr>";


            $db->close();
        return $custom_message;

    }

}
