<?php

// Includes
// include "../../../app/classes/databaseClass.php";
// include "../../../app/classes/profileClass.php";

session_start();
$email = $_SESSION['user_email'];
  
if(isset($_FILES['newImagePicture'])){
    $img_name = $_FILES['newImagePicture']['name'];
    $img_size = $_FILES['newImagePicture']['size'];
    $tmp_name = $_FILES['newImagePicture']['tmp_name'];
    $error = $_FILES['newImagePicture']['error'];

    if($error === 0){

        if($img_size > 5000000){
            $em = "Sorry, your image is too large";
            $error = array('error' => 1, 'em' => $em);

            // printing out php array and converting it into JSON format

            echo json_encode($error);
            exit();
        }else{

            // getting image extension
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            
            // convert image extension into lower case
            $img_ex_lc = strtolower($img_ex);

            // creating array that stores allowed to upload image extensions.

            $allowed_exs = array("jpg", "jpeg", "png", "webp");

            if(in_array($img_ex_lc, $allowed_exs)){
                // renaming the image name
                $newImageName = uniqid("IMG-", true).'.'.$img_ex_lc;
                //upload path

                $imgUploadPath = "../../uploads/images/".$newImageName;

                move_uploaded_file($tmp_name, $imgUploadPath);
                
                $host = "localhost";
                $user = "root";
                $pass = "";
                $db = "hoyostore";
                $conn;

                try{
                    $conn = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE users SET profile_picture = '$newImageName' WHERE user_email = '$email'";
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                }catch(PDOException $e){
                    echo $e->getMessage();
                }


                $res = array('error' => 0, 'src' => $newImageName);
                echo json_encode($res);
                exit();

            }else{
                $em = "You can't upload this type of files!";
                $error = array('error' => 1, 'em' => $em);

                // printing out php array and converting it into JSON format

                echo json_encode($error);
                exit();
            }
        }

    }else{
        $em = "unknown error occurred!";
        $error = array('error' => 1, 'em' => $em);

        // printing out php array and converting it into JSON format

        echo json_encode($error);
        exit();
    }

}