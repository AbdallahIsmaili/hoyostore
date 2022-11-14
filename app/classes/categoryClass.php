<?php

class Category extends Database{

    public function registerCategory($categoryName, $categoryDesc, $categoryIcon, $createdAt, $isActive){

        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM categories WHERE category_name = '$categoryName' LIMIT 1";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            // username or email has already been taken
            if(count($result) > 0){
                return 1;
                die();

            }else {
                    
                $sql = "INSERT INTO categories (category_name, category_desc, category_icon, created_at, is_active) VALUES ('$categoryName', '$categoryDesc', '$categoryIcon', '$createdAt', '$isActive')";

                $statement = $this->conn->prepare($sql);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                
                return $result;
                die();

            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }

        
    }

    public function getCategories(){
        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM categories";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

}