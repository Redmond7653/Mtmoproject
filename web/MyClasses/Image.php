<?php

namespace MyClasses;
use MyClasses\Db;

class Image
{
 private $img;

     public function image_save($id = NULL, $message_id = NULL) {
         $user_directory = $_SESSION['user']->getId();
         $target_directory = "images/".$user_directory."/";
         $img_directory = "images/";

         foreach ($_FILES["fileUpload"]["name"] as $key => $fileUploadName) {
             $target_file = $img_directory. basename($fileUploadName);
             $uploadOk = 1;
             $fileinfo = pathinfo($target_file);

             $target_file = $fileinfo['basename'];

             $i = 1;
                    while (file_exists($target_directory . $target_file)) {
                    $target_file =  $fileinfo['filename'] . $i . "." . $fileinfo['extension'];
                    $i++;
             }

             if (isset($_POST["submit"]) && !empty($fileUploadName)) {
                 $check = getimagesize($_FILES["fileUpload"]["tmp_name"][$key]);
                 if ($check !== false) {
                     echo "File is an image - " . $target_file . ".";
                     $uploadOk = 1;
                 } else {
                     echo "File is not an image.";
                     $uploadOk = 0;
                 }
             }


             if ($uploadOk == 0 && isset($_POST['submit'])) {
                 echo "Sorry, your file was not uploaded.";
             } else {
                 // Створюю папку "250"
                 if (!file_exists("images/". $user_directory)) {
                     mkdir("images/". $user_directory, 0777, true);
                 }

                 if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"][$key], $target_directory . $target_file)) {
                     $path_image = "/". $target_directory . $target_file;

                     $db = new Db();
                     
                      if (!is_null($id)) {
                        $result = $db->query("SELECT * FROM `messages` WHERE `user_id` = '$id' ORDER BY `id` DESC LIMIT 1");
                        
                        $row_message = $result->fetch_assoc();
                        
                        $message_id = $row_message['id'];
                      }

                     $all_images_array = $db->query("INSERT INTO `images` (`img`, `message_id`) VALUES ('$path_image', '$message_id')" );

                     echo "The file " . htmlspecialchars(basename($fileUploadName)) . " has been uploaded.";

                 }

             }

         }
     }
     
     
}