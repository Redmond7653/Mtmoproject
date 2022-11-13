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

function show_user_messages($user_id = NULL, $limit = 5)
{

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
    if ($result = $db->query("
            SELECT * 
            FROM `messages`
            WHERE `user_id` = '{$user_id}' 
            ORDER BY `id` DESC
            LIMIT {$offset}, {$limit}
            "
    )) {
        $user_message_rows = $result->fetch_all(MYSQLI_ASSOC);
    }
    db_error(__LINE__, $db);


    $user_messages = "<h2>Page " . ($page + 1) . "</h2>";

    foreach ($user_message_rows as $message_row) {
        $user_messages .= "<div class='user_message_field'><div>" . "<div class='user_message'>".nl2br($message_row['message'])."</div>";
        // Генерація картинки початок
        $message_id = $message_row['id'];
        $images = '';

        if ($images_result = $db->query("SELECT * FROM `images` WHERE `message_id` = '$message_id'")) {
            $user_images_row = $images_result->fetch_all(MYSQLI_ASSOC);
            foreach ($user_images_row as $images_row) {
//                $images .= "<div class='user_img'><img src='{$images_row['img']}'></div>";
                $images .= get_template('messages_image', $images_row);

            }
        }


        if ($select_user_message_row = $db->query("SELECT * FROM `messages` WHERE `id` = '$message_id'")) {
            $user_message_row_array = $select_user_message_row->fetch_assoc();
            $user_message = $user_message_row_array['message'];
        }

        $edit_message = get_template('message_edit_form', ['um' => $user_message, 'message_id' => $message_id]);

            // Генерація картинки кінець
            $user_messages .= "$images</div>" . $edit_message;


        }


        // Отримати message id
        // Витягнути всі строчкі з цим message id з табличкі images
        // Перебрати всі строчкі і створити тег img з src="img"

        $db->close();

        return $user_messages;
    }

    function show_user_images($user_id = NULL) {
        if (!$user_id) {
            $user_id = $_SESSION['user']['id'];
        }



    }


    function get_pages_number($user_id = NULL, $limit = 5)
    {
        $page_number = get_messages_number($user_id) / $limit;
        // @todo: return actual numbers of pages for this user
        return $page_number;
    }

    function get_messages_number($user_id = NULL)
    {
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

    function get_custom_message()
    {

        if (isset($_GET['custom_message']) || isset($_POST['custom_message'])) {
            $db = db_connect();

//        $id_number = $_POST['custom_message'] ?? $_GET['custom_message'] ?? FALSE;
            $id_number = $_POST['custom_message'] ?? $_GET['custom_message'];


            $method = isset($_POST['custom_message']) ? "_POST_" : "_GET_";

            if ($user_custom_message_array = $db->query("SELECT * FROM `messages` WHERE `id` = '$id_number'")) {
                $custom_message_array = $user_custom_message_array->fetch_assoc();
            }
            $custom_message = "<h3>Message #{$custom_message_array['id']}, method {$method}</h3>";
            $custom_message .= "<div>" . $custom_message_array['message'] . "</div>";
            $custom_message .= "<hr>";


            $db->close();
            return $custom_message;

        }
    }

    function select_users_names()
    {
        $db = db_connect();

        $a = select_unique_authors();
        if (empty($a)) {
            $a = '0';
        } else {
            $a = implode(',', $a);
        }

        // SELECT * FROM `users` WHERE id=250 OR id=251 OR id=252
        if ($select_all_users_array = $db->query("SELECT * FROM `users` WHERE id IN ({$a})")) {
            $select_users_array = $select_all_users_array->fetch_all(MYSQLI_ASSOC);
        }
        $select_user_names = [];
        foreach ($select_users_array as $select_custom_users_array) {
            $select_user_names[$select_custom_users_array['id']] = $select_custom_users_array['name'];
        }
        $db->close();
        return $select_user_names;
    }

//function select_users_id()
//{
//    $db = db_connect();
//
//    $a = select_unique_authors();
//    if (empty($a)) {
//        $a = '0';
//    } else {
//        $a = implode(',', $a);
//    }
//
//    // SELECT * FROM `users` WHERE id=250 OR id=251 OR id=252
//    if ($select_all_users_array = $db->query("SELECT * FROM `users` WHERE id IN ({$a})")) {
//        $select_users_array = $select_all_users_array->fetch_all(MYSQLI_ASSOC);
//    }
//    $select_user_id = [];
//    foreach ($select_users_array as $select_custom_users_array) {
//        $select_user_id[] = $select_custom_users_array['id'];
//    }
//    $db->close();
//   return $select_user_id;
//}

    function select_unique_authors()
    {
        $db = db_connect();

        if ($select_all_users_array = $db->query("SELECT DISTINCT `user_id` FROM `messages` ")) {
            $select_users_id_array = $select_all_users_array->fetch_all(MYSQLI_ASSOC);
        }
        $select_user_names = [];
        foreach ($select_users_id_array as $select_custom_users_array) {
            $select_user_names[] = $select_custom_users_array['user_id'];
        }
        $db->close();
        return $select_user_names;
    }

    function select_unique_images()
    {
        $db = db_connect();

        if ($select_all_users_array = $db->query("SELECT * FROM `images` WHERE `ID`  ")) {
            $select_images_id_array = $select_all_users_array->fetch_all(MYSQLI_ASSOC);
        }
        $select_images_names = [];
        foreach ($select_images_id_array as $select_custom_images_array) {
            $select_images_names[$select_custom_images_array['name']] = $select_custom_images_array['img'];
        }
        $db->close();
        return $select_images_names;
    }


//function show_unique_images() {
//    $db = db_connect();
//
//    if ($select_all_users_array = $db->query("SELECT * FROM `images` WHERE `ID`  ")) {
//        $select_images_id_array = $select_all_users_array->fetch_all(MYSQLI_ASSOC);
//    }
//    $select_images_names = [];
//    foreach ($select_images_id_array as $select_custom_images_array) {
//        $select_images_names[$select_custom_images_array['img']] = $select_custom_images_array['name'];
//    }
//    $db->close();
//    return $select_images_names;
//}

//function edit_user_message() {
//
//    $db = db_connect();
//
//    if ($select_user_message_row = $db->query("SELECT * FROM `messages` WHERE `id` = '$message_id'")) {
//        $user_message_row_array = $select_user_message_row->fetch_assoc();
//        $current_user_message = $user_message_row_array['message'];
//        $db->close();
//        return $current_user_message;
//    }
//}

//function edit_user_image() {
//
//    $db = db_connect();
//
//    if ($table_img = $db->query("SELECT * FROM `images` WHERE `message_id` = '$message_id'")) {
//        $change_img = $table_img->fetch_all(MYSQLI_ASSOC);
//        foreach ($change_img as $image_rows) {
//            $image = $image_rows['img'];
//        }
//    }
//}

function edit_user_image() {

    $db = db_connect();

    $image = '';
    $message_id = $_REQUEST['message_id'];
    if ($table_img = $db->query("SELECT * FROM `images` WHERE `message_id` = '{$_REQUEST['message_id']}'")) {
        $change_img = $table_img->fetch_all(MYSQLI_ASSOC);
        foreach ($change_img as $image_rows) {
            $user_image = $image_rows['img'];
            $image .= "<img src='{$image_rows['img']}'>". "<form action='index.php' method='post'>
                                                                <input type='hidden' name='action' value='delete_img'>
                                                                <input type='hidden' name='message_id' value='$message_id'>
                                                                <input type='hidden' name='message_img' value='$user_image'>
                                                                <input type='submit' value='X'>
                                                            </form>" ;
        }
    }
    return $image;
}

function render_page() {
    if (!isset($_SESSION['render']) || !is_array($_SESSION['render'])) {
        echo '$_SESSION["render"] is not and render array!';
        return;
    }
    foreach ($_SESSION['render'] as $key => $element) {
        if (!isset($element['#weight'])) {
            $_SESSION['render'][$key]['#weight'] = 0;
        }
    }
    // todo: enforce sort by '#weight'

    foreach ($_SESSION['render'] as $element) {
        $template = $element['#template'] ?? '';
        if (!isset($element['#data'])) {
            $element['#data'] = '';
        }
        echo get_template($template, $element['#data']);
    }

}

function get_template($template, $data) {
    $content = '';
    $template = "template/{$template}.html";
    if (file_exists($template)) {
        ob_start();
        include $template;
        $content = ob_get_clean();
    }
    return $content;
}
