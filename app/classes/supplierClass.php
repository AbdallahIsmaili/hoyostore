<?php

class Suppliers extends Database{

    public function registerSupplier($companyName, $contactTitle, $contactFName, $contactLName, $addressOne, $addressTwo, $country, $state, $city, $codePostal, $supplierEmail, $phoneNumber, $faxNumber, $website, $paymentMethod, $discountAvailable, $date, $logo){

        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM suppliers WHERE company_name = '$companyName' LIMIT 1";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            // username or email has already been taken
            if(count($result) > 0){
                return 1;
                die();

            }else {
                    
                $sql = "INSERT INTO suppliers (company_name, join_at, contact_title, contact_first_name, contact_last_name, supplier_address_one, 	supplier_address_two, supplier_city, supplier_state, supplier_postal_code, supplier_country, supplier_phone, supplier_fax, supplier_email, supplier_website, supplier_payment_method, discount_available, 	supplier_logo) VALUES ('$companyName', '$date', '$contactTitle', '$contactFName', '$contactLName', '$addressOne','$addressTwo', '$city', '$state', '$codePostal', '$country', '$phoneNumber', '$faxNumber', '$supplierEmail', '$website', '$paymentMethod', '$discountAvailable', '$logo')";
                $statement = $this->conn->prepare($sql);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);

                // Sending email Verification:

                $to = $supplierEmail;
                $subject = "Thank you for trust HoyoStore.";
                $message = "
                    
                    to $companyName <br>

                    We just wanted to say thank you for choosing us for our services and companionship. we are delighted to say that we've been offered the position, and we've accepted it!
                    <br>
                    Let us be the best supports and work companion.
                    <br>
                    <br>

                    Kind regards, HoyoStore.
                ";

                $headers = "From: aismaili690@gmail.com \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                mail($to, $subject, $message, $headers);
                
                return $result;
                die();

            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }

    }

    public function getSuppliers(){
        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM suppliers";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getSupplierName($Id){
        try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM suppliers WHERE supplier_id = '$Id'";

            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

}