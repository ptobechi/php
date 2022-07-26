<?php
session_start();
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
    // e10adc3949ba59abbe56e057f20f883e
    protected function CreateDataTables(){
        $query = ("CREATE TABLE IF NOT EXISTS register ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `uid` INT(11) NOT NULL , 
            `ufirstname` VARCHAR(100) NOT NULL , 
            `ulastname` VARCHAR(100) NOT NULL , 
            `uemail` VARCHAR(100) NOT NULL , 
            `uphone` VARCHAR(20) NOT NULL , 
            `ulocation` VARCHAR(20) NOT NULL , 
            `upassword` VARCHAR(50) NOT NULL ,  
            `ustatus` INT(11) NOT NULL ,   
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            UNIQUE (`uid`) 
        )ENGINE = InnoDB;");
        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        // EXECUTE THE QUERY
        $stmt->execute();

        $query = ("CREATE TABLE IF NOT EXISTS vendors ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `vid` INT(11) NOT NULL , 
            `vname` VARCHAR(255) NOT NULL , 
            `vemail` VARCHAR(50) NOT NULL , 
            `vphone` VARCHAR(12) NOT NULL ,  
            `vlocation` VARCHAR(255) NOT NULL , 
            `vuname` VARCHAR(50) NOT NULL ,  
            `vpassword` VARCHAR(50) NOT NULL ,  
            `vimage` VARCHAR(255) NOT NULL ,  
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            `status` VARCHAR(11) NOT NULL ,  
            PRIMARY KEY  (`id`),
            UNIQUE (`vid`) 
        )ENGINE = InnoDB;");
        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        // EXECUTE THE QUERY
        $stmt->execute();

        $query = ("CREATE TABLE IF NOT EXISTS products ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `pid` INT(11) NOT NULL , 
            `vid` INT(11) NOT NULL , 
            `pcategory` VARCHAR(255) NOT NULL , 
            `pname` VARCHAR(255) NOT NULL , 
            `pamount` VARCHAR(20) NOT NULL , 
            `others` VARCHAR(255) NOT NULL , 
            `status` VARCHAR(11) NOT NULL ,  
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            FOREIGN KEY (`vid`) REFERENCES vendors(`vid`)
        )ENGINE = InnoDB;");
        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        // EXECUTE THE QUERY
        $stmt->execute();

        $query = ("CREATE TABLE IF NOT EXISTS orders ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `vid` INT(11) NOT NULL , 
            `uid` INT(11) NOT NULL , 
            `oid` INT(11) NOT NULL , 
            `ocontent` VARCHAR(1025) NOT NULL , 
            `desc` VARCHAR(255) NOT NULL , 
            `status` INT(11) NOT NULL ,  
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            FOREIGN KEY (`uid`) REFERENCES register(`uid`),
            FOREIGN KEY (`vid`) REFERENCES vendors(`vid`)
        )ENGINE = InnoDB;");
        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        // EXECUTE THE QUERY
        $stmt->execute();
   
    }

    
}

// $p = new Database;
// $p->connect();
// $p->CreateDataTables();
