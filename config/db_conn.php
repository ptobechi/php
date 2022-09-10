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

    protected function CreateDataTables(){
        $query = ("CREATE TABLE IF NOT EXISTS vendors ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            `pkey` VARCHAR(50) NOT NULL , 
            `vid` VARCHAR(10) NOT NULL , 
            `vname` VARCHAR(255) NOT NULL , 
            `vcontact` VARCHAR(100) NOT NULL , 
            `vlocation` VARCHAR(255) NOT NULL , 
            `vimage` VARCHAR(255) NOT NULL ,  
            `vopen_at` DATETIME NOT NULL ,  
            `vstatus` VARCHAR(11) NOT NULL ,  
            `vcreated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            UNIQUE (`vid`), 
            UNIQUE (`pkey`) 
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
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,  
            PRIMARY KEY  (`id`),
            FOREIGN KEY (`vid`) REFERENCES vendors(`vid`)
        )ENGINE = InnoDB;");
        $stmt = $this->conn->prepare($query);  // PREPARE STATEMENT FOR INSERTING
        $stmt->execute();  // EXECUTE THE QUERY
   
    }

    
}

