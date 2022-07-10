<?php

class Database{
    // DB PARAM
    private $host = "localhost";
    private $db_name = "database";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect(){
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name.';charset=utf8', $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection Succesful";
            $this->CreateDataTables();
        } catch (PDOException $e) {
            echo "Connection Error: ". $e->getMessage();
        }

        return $this->conn;
    }

    protected function CreateDataTables(){
        $query = ("CREATE TABLE IF NOT EXISTS register ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `userid` INT(11) NOT NULL , 
            `firstname` VARCHAR(100) NOT NULL , 
            `lastname` VARCHAR(100) NOT NULL , 
            `email` VARCHAR(100) NOT NULL , 
            `phone_no` VARCHAR(20) NOT NULL , 
            `password` VARCHAR(50) NOT NULL ,  
            `status` INT(11) NOT NULL ,   
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            UNIQUE (`userid`) 
        )ENGINE = InnoDB;");
        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        // EXECUTE THE QUERY
        $stmt->execute();

        $query = ("CREATE TABLE IF NOT EXISTS restuarant ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `restuarant_id` INT(11) NOT NULL , 
            `name` VARCHAR(255) NOT NULL , 
            `email` VARCHAR(50) NOT NULL , 
            `phone` VARCHAR(12) NOT NULL ,  
            `location` VARCHAR(255) NOT NULL , 
            `username` VARCHAR(50) NOT NULL ,  
            `password` VARCHAR(50) NOT NULL ,  
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            `image` VARCHAR(255) NOT NULL ,  
            `status` VARCHAR(11) NOT NULL ,  
            PRIMARY KEY  (`id`),
            UNIQUE (`restuarant_id`) 
        )ENGINE = InnoDB;");
        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        // EXECUTE THE QUERY
        $stmt->execute();

        $query = ("CREATE TABLE IF NOT EXISTS products ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `product_id` INT(11) NOT NULL , 
            `restuarant_id` INT(11) NOT NULL , 
            `category` VARCHAR(255) NOT NULL , 
            `name` VARCHAR(255) NOT NULL , 
            `price` VARCHAR(20) NOT NULL , 
            `others` VARCHAR(255) NOT NULL , 
            `status` VARCHAR(11) NOT NULL ,  
            `image` VARCHAR(255) NOT NULL ,  
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            FOREIGN KEY (`restuarant_id`) REFERENCES restuarant(`restuarant_id`)
        )ENGINE = InnoDB;");
        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        // EXECUTE THE QUERY
        $stmt->execute();

        $query = ("CREATE TABLE IF NOT EXISTS orders ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `orderid` INT(11) NOT NULL , 
            `userid` INT(11) NOT NULL , 
            `requeste` VARCHAR(1025) NOT NULL , 
            `others` VARCHAR(255) NOT NULL , 
            `status` INT(11) NOT NULL ,  
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            FOREIGN KEY (`userid`) REFERENCES register(`userid`)
        )ENGINE = InnoDB;");
        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        // EXECUTE THE QUERY
        $stmt->execute();
   
    }
}

// $p = new Database;
// $p->connect();