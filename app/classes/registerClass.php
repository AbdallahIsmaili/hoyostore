<?php

Class Database{

    public $DB_NAME = "hoyostore";
    public $DB_USER = "root";
    public $DB_PASS = "";
    public $DB_HOST = "localhost";
    public $DB_TYPE = "mysql";
    public $conn;
    public function __construct(){

        try {

            $string = $this->DB_TYPE . ":host=" . $this->DB_HOST . ";dbname=" . $this->DB_NAME;
            $this->conn = new PDO($string, $this->DB_USER, $this->DB_PASS);

        } catch(PDOException $e) {
            die($e->getMessage());
        }
        
    }

}

class Register extends Database{

public function registerUser($name, $email, $password, $confirm_password, $date, $image, $validation){

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
                $url_address = $this->get_random_string_max(99);
                
                $password = hash("sha1", $password);
                $sql = "INSERT INTO users (user_email, user_password, username, user_urlAddress, join_date, rank, profile_picture, validation) VALUES ('$email', '$password', '$name', '$url_address','$date', 'costumer', '$image', '$validation')";
                $statement = $this->conn->prepare($sql);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);

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