<?php
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$fileinfo = pathinfo($target_file);

$string_to_separate = $fileinfo['basename'];
$pieces = explode('.', $string_to_separate);
$file_basename = $pieces[0];

$target_file =  $file_basename . "." . $fileinfo['extension'];

$i = 1;
while (file_exists($target_dir . $target_file)) {
    $target_file = $file_basename . $i . "." . $fileinfo['extension'];
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
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
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
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
?>