<?php

class Register extends Database{

    public function registerUser($name, $email, $phoneNumber, $password, $confirm_password, $date, $image, $validation, $verificationKey){

        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM users WHERE user_email = '$email' LIMIT 1";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            // username or email has already been taken
            if(count($result) > 0){
                return 1;
                die();

            }else {
                if($password == $confirm_password){
                    // Registration Succeed
                    $url_address = $this->get_random_string_max(99);
                    
                    $password = hash("sha1", $password);
                    $sql = "INSERT INTO users (user_email, phone_number , user_password, username, user_urlAddress, join_date, rank, profile_picture, validation, verification_key) VALUES ('$email', '$phoneNumber', '$password', '$name', '$url_address','$date', 'costumer', '$image', '$validation', '$verificationKey')";
                    $statement = $this->conn->prepare($sql);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_OBJ);

                    // Sending email Verification:

                    $path = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] ."/hoyostore/validation/registration-verify.php?k=$verificationKey";

                    $to = $email;
                    $verification_link = "<a href='$path'>Your account verification link</a>";
                    $subject = "Your email verification.";
                    $message = "
                        
                        Hello $name <br>

                        Are you ready to gain access to all of the assets we prepared for clients of HoyoStore?<br>

                        First, you must complete your registration by clicking on the link below:<br><br>

                        $verification_link
                        <br><br>

                        This link will verify your email address, and then you’ll officially be a part of our community.<br>

                        See you there!<br><br>

                        <strong>Best regards, the <u>HoyoStore</u> team.</strong>
                    ";

                    $headers = "From: aismaili690@gmail.com \r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    mail($to, $subject, $message, $headers);

                    header("Location:login.php?email=$email&v=false");
                    die();

                }
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }

        
    }

    public function get_random_string_max($length){
        $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':',';','<','>','?','[',']','~','`','.',',',' ');
        $text = "";

        $length = rand(4, $length);

        for($i = 0; $i < $length; $i++){
            $text .= $array[rand(0, count($array) - 1)];
        }

        return $text;
    }

}