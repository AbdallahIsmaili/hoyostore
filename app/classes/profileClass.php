<?php


class Profile extends Database{

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