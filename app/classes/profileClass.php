<?php

class Profile extends Database{

    public function updateUserInfo($name, $userURL, $email, $phoneNumber, $userAddress, $password){

        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM users WHERE user_urlAddress = '$userURL' LIMIT 1";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            // username or email has already been taken
            if(count($result) > 0){
                if($password == $result[0]->user_password){

                    $sql = "UPDATE users SET user_email = '$email', phone_number = '$phoneNumber', user_address = '$userAddress', username = '$name' WHERE user_urlAddress = '$userURL'";

                    $statement = $this->conn->prepare($sql);
                    $statement->execute();

                    return 1;
                    die();

                }else{
                    return 2;
                    die();
                }


            }else {
                return 3;
                die();
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }

        
    }

    public function getProfileName($email){
        try{
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM users WHERE user_email = '$email'";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            if(count($result) > 0){
                $user_image = $result[0]->profile_picture;
                return $user_image;

            }else{
                return 0;
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

}