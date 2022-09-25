<?php



class Verification extends Database{
    public function validMyEmail($key){
        
        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT verification_key, validation FROM users WHERE verification_key = '$key' AND validation = 1 LIMIT 1";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            // Yes we found that a valid user
            if(count($result) > 0){
                return 1;
                die();

            }else{
                
            
                // Yes we found that not a valid user
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT verification_key, validation FROM users WHERE verification_key = '$key' AND validation = 0 LIMIT 1";

                $statement = $this->conn->prepare($sql);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                
                if(count($result) > 0){
                    $sql = "UPDATE users SET validation = 1  WHERE verification_key = '$key'";

                    $statement = $this->conn->prepare($sql);
                    $statement->execute();

                    return 2;
                    die();

                }else{
                    return 3;
                    die();

                }
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function updateVerificationCode($key, $email){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM users WHERE user_email = '$email' AND validation = 0 LIMIT 1";

        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        if(count($result) > 0){
            $sql = "UPDATE users SET verification_key = '$key' WHERE user_email = '$email'";

            $statement = $this->conn->prepare($sql);
            $statement->execute();

            return 1;
            die();

        }else{
            return 2;
            die();

        }
    }
}