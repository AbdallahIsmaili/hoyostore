<?php

class Products extends Database{

    # Insert Function
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

    # generate SKU code function
    public function get_sku($length){
        $array = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $text = "";

        $length = rand(8, $length);

        for($i = 0; $i < $length; $i++){
            $text .= $array[rand(0, count($array) - 1)];
        }

        return $text;
    }

    # Get All Products Function
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

    # Search On Product
    public function searchOnProduct($searchedProductName, $productMaxPrice, $productMinPrice, $category, $supplier){
        try{
            
            # name found but prices not found
            if($productMinPrice == 0 and $productMaxPrice == 0 and $searchedProductName != ''){

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM products where category_id = '$category' and supplier_id = '$supplier' and product_name LIKE '%$searchedProductName%'";

            }
            
            # all 3 found
            if($productMinPrice != 0 and $productMaxPrice != 0 and $searchedProductName != ''){

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM products where category_id = '$category' and supplier_id = '$supplier' and unit_price <= '$productMaxPrice' and unit_price >= '$productMinPrice' and product_name LIKE '%$searchedProductName%'";

            }

            # all 3 not found
            if($productMinPrice == 0 and $productMaxPrice == 0 and $searchedProductName == ''){

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM products where category_id = '$category' and supplier_id = '$supplier'";

            }

            # all prices found but name not found
            if($productMinPrice != 0 and $productMaxPrice != 0 and $searchedProductName == ''){

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM products where category_id = '$category' and supplier_id = '$supplier' and unit_price <= '$productMaxPrice' and unit_price >= '$productMinPrice'";

            }

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    # Get Product Information By Id
    public function getProductByID($id){
        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM products WHERE product_id = '$id'";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    # Update Function
    public function updateProduct($productID, $productName, $productDesc, $supplierId, $categoryId, $unitPrice, $size, $productColor, $sizesAvailable, $colorsAvailable, $unitWeight, $unitOnStock, $productPicture){

        try{

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM products WHERE product_id = '$productID'";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            if(count($result) > 0){
                
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE products SET product_name = '$productName', product_description = '$productDesc', supplier_id = '$supplierId', category_id = '$categoryId', unit_price = '$unitPrice', size = '$size', color = '$productColor', avialable_size = '$sizesAvailable', avialable_colors = '$colorsAvailable', unit_weight = '$unitWeight', units_in_stock = '$unitOnStock', picture = '$productPicture' WHERE product_id = '$productID'";

                $statement = $this->conn->prepare($sql);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                
                return 1;
                die();

            }else{
                return 2;
                die();
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }

}