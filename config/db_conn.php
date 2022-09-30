<?php
session_start();
class Database{
    // DB PARAM
    private $host = "localhost";
    private $db_name = "database";
    private $username = "root";
    private $password = "";
    private $conn;
    // e10adc3949ba59abbe56e057f20f883e
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
        $query = ("CREATE TABLE IF NOT EXISTS users ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `uid` VARCHAR(10) NOT NULL , 
            `ufname` VARCHAR(100) NOT NULL , 
            `ulname` VARCHAR(100) NOT NULL , 
            `ucontact` VARCHAR(100) NOT NULL , 
            `uimage` VARCHAR(255) NOT NULL ,  
            `address` VARCHAR(500) NOT NULL ,  
            `alt_address` VARCHAR(500) NOT NULL ,  
            `ustatus` VARCHAR(11) NOT NULL ,  
            `upassword` VARCHAR(100) NOT NULL ,  
            `ucreated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            UNIQUE (`uid`)
        )ENGINE = InnoDB;");
        $stmt = $this->conn->prepare($query);// PREPARE STATEMENT FOR INSERTING
        $stmt->execute(); // EXECUTE THE QUERY

        $query = ("CREATE TABLE IF NOT EXISTS vendors ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `vid` VARCHAR(10) NOT NULL , 
            `vemail` VARCHAR(255) NOT NULL , 
            `vname` VARCHAR(255) NOT NULL , 
            `vcontact` VARCHAR(100) NOT NULL , 
            `vlocation` VARCHAR(255) NOT NULL , 
            `vimage` VARCHAR(255) NOT NULL ,  
            `vopen_at` DATETIME NOT NULL ,  
            `vstatus` VARCHAR(11) NOT NULL ,  
            `vpassword` VARCHAR(11) NOT NULL ,  
            `vcreated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            UNIQUE (`vid`)
        )ENGINE = InnoDB;");
        $stmt = $this->conn->prepare($query);// PREPARE STATEMENT FOR INSERTING
        $stmt->execute(); // EXECUTE THE QUERY

        $query = ("CREATE TABLE IF NOT EXISTS products ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `pid` VARCHAR(10) NOT NULL , 
            `vid` VARCHAR(10) NOT NULL , 
            `pcategory` VARCHAR(100) NOT NULL , 
            `pname` VARCHAR(100) NOT NULL , 
            `pamount` VARCHAR(50) NOT NULL , 
            `paddons` VARCHAR(255) NOT NULL , 
            `pimage` VARCHAR(50) NOT NULL ,  
            `pstatus` INT(11) NOT NULL ,  
            `pcreated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            FOREIGN KEY (`vid`) REFERENCES vendors(`vid`)
        )ENGINE = InnoDB;");
        $stmt = $this->conn->prepare($query);  // PREPARE STATEMENT FOR INSERTING
        $stmt->execute();  // EXECUTE THE QUERY

        $query = ("CREATE TABLE IF NOT EXISTS sales ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `oid` VARCHAR(10) NOT NULL , 
            `uid` VARCHAR(10) NOT NULL , 
            `vid` VARCHAR(10) NOT NULL , 
            `content` VARCHAR(1025) NOT NULL , 
            `osum` VARCHAR(255) NOT NULL , 
            `delivery_address` VARCHAR(255) NOT NULL , 
            `ostatus` INT(11) NOT NULL ,  
            `ocreated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            FOREIGN KEY (`vid`) REFERENCES vendors(`vid`),
            FOREIGN KEY (`uid`) REFERENCES register(`uid`)
        )ENGINE = InnoDB;");
        $stmt = $this->conn->prepare($query);  // PREPARE STATEMENT FOR INSERTING
        $stmt->execute();  // EXECUTE THE QUERY
   
    }

    
}

