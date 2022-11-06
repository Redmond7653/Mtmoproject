<?php

$user_dir = $_SESSION['user']['id'];

$target_dir = "images/". $user_dir. "/";
$target_dir1 = "images/";

foreach ($_FILES["fileToUpload"]["name"] as $key=>$fileUploadedName) {

    $target_file = $target_dir1 . basename($fileUploadedName);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $fileinfo = pathinfo($target_file);

//$string_to_separate = $fileinfo['basename'];
//$pieces = explode('.', $string_to_separate);
//$file_basename = $pieces[0];
//
    $target_file =  $fileinfo['basename'];


    $i = 1;
    while (file_exists($target_dir . $target_file)) {
        $target_file =  $fileinfo['filename'] . $i . "." . $fileinfo['extension'];
        $i++;
    }

//if (file_exists($target_file)) {
//    for ($i = 1; $i <= 1000; $i++) {
//        $target_file = $file_basename . $i . "." . $fileinfo['extension'];
//        if (!file_exists($target_dir . $target_file)) {
//            break;
//        }
//    }
//}

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]);
        if ($check !== false) {
            echo "File is an image - " . $target_file . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }


    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        // Створюю папку "250"
        if (!file_exists("images/". $user_dir)) {
            mkdir("images/". $user_dir, 0777, true);
        }

        // Муваю файл в images/250
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_dir . $target_file)) {
            echo "The file " . htmlspecialchars(basename($fileUploadedName)) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

    }

    $path_image = "/". $target_dir . $target_file;

    $db = db_connect();

    $message_id = $_REQUEST['id'];

    $all_images_array = $db->query("INSERT INTO `images` (`img`, `message_id`) VALUES ('$path_image', '$message_id')" );

    $db->close();

}
//    $pic_directory = $_SESSION['user']['id'];


?>