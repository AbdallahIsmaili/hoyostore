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