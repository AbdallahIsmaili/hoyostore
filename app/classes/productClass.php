<?php

class Products extends Database{

    public function registerProduct($productName, $productDesc, $supplierId, $categoryId, $unitPrice, $size, $productColor, $sizesAvailable, $colorsAvailable, $unitWeight, $unitOnStock, $unitOnOrder, $productAvailable, $date, $ranking, $discount, $discountAvailable, $productPicture){

        try{
            $SKU = $this->get_sku(10);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO products (SKU, product_name, product_description , supplier_id, category_id, unit_price, size, color, avialable_size,avialable_colors, discount, unit_weight, units_in_stock, units_on_order, product_avilable, discount_avilable, picture, ranking, added_at) VALUES ('$SKU', '$productName', '$productDesc', '$supplierId', '$categoryId', '$unitPrice', '$size', '$productColor', '$sizesAvailable', '$colorsAvailable', '$discount', '$unitWeight', '$unitOnStock', '$unitOnOrder', '$productAvailable', '$discountAvailable', '$productPicture', '$ranking', '$date')";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            
            return 1;
            die();

        }catch(PDOException $e){
            echo $e->getMessage();
        }

        
    }

    public function get_sku($length){
        $array = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $text = "";

        $length = rand(8, $length);

        for($i = 0; $i < $length; $i++){
            $text .= $array[rand(0, count($array) - 1)];
        }

        return $text;
    }

    public function getProducts(){
        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM products";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}