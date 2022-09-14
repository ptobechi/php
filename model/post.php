<?php

class Post{
    // DB PARAM 
    private $conn;
    private $vendor = "vendors";
    private $products = "products";

    public $id;

    // ESTABLISH A DATABASE CONNECTION
    public function __construct($db){
        $this->conn = $db;
    }

    public function Post(){
        try {
            $query = "SELECT * 
                        FROM
                    $this->vendor            
            ";

             $stmt = $this->conn->prepare($query); 
             $stmt->execute();
             return $stmt;

        } catch (PDOException $error) {
            printf("Error %s. \n", $error->getMessage());
            exit;
        }
        
    }

    
}

?>