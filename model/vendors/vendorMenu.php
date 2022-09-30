<?php

class Menu{
    // DB PARAM 
    private $conn;
    private $vendor = "vendors";
    private $products = "products";

    public $id;

    // ESTABLISH A DATABASE CONNECTION
    public function __construct($db){
        $this->conn = $db;
    }

    public function returnVendorMenu(){
        try {
            $query = "SELECT * 
                    FROM
                $this->vendor v
                    LEFT JOIN 
                $this->products p ON v.vid = p.vid  
                    WHERE
                v.vid = ?        
            ";

            $stmt = $this->conn->prepare($query); 
            
            // CLEAN USER DATA
            $this->id = htmlspecialchars(strip_tags($this->id));

            //BIND PARAM
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            return $stmt;

        } catch (PDOException $error) {
            printf("Error %s. \n", $error->getMessage());
            exit;
        }
    }

    
}

?>