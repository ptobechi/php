<?php

class VendorList{
    // DB PARAM 
    private $conn;
    private $table = "vendors";
    
    // ESTABLISH A DATABASE CONNECTION
    public function __construct($db){
        $this->conn = $db;
    }

    public function returnAllVendors(){
        try {
            $query = "SELECT * 
                        FROM
                    $this->table            
            ";

             $stmt = $this->conn->prepare($query); 
             $stmt->execute();
             return $stmt;

        } catch (PDOException $error) {
            printf("Error %s. \n", $error->getMessage());
            exit;
        }
        
    }

    public function returnTopVendor(){
        try {
            $query = "SELECT * 
                    FROM
                $this->table 
                    LIMIT 5           
            ";

             $stmt = $this->conn->prepare($query); 
             $stmt->execute();
             return $stmt;
             
        } catch (PDOException $error) {
            printf("Error %s. \n", $error->getMessage());
            exit;
        }
        
    }

    public function returnPromotedVendors(){
        try {
            $query = "SELECT * 
                    FROM
                $this->table 
                    LIMIT 5           
            ";

             $stmt = $this->conn->prepare($query); 
             $stmt->execute();
             return $stmt;
             
        } catch (PDOException $error) {
            printf("Error %s. \n", $error->getMessage());
            exit;
        }
        
    }

    public function returnTrendingVendors(){
        try {
            $query = "SELECT * 
                    FROM
                $this->table 
                    LIMIT 5           
            ";

             $stmt = $this->conn->prepare($query); 
             $stmt->execute();
             return $stmt;
             
        } catch (PDOException $error) {
            printf("Error %s. \n", $error->getMessage());
            exit;
        }
        
    }

    public function returnVendorInformation(){
        try {
            $query = "SELECT * 
                    FROM
                $this->table 
                    LIMIT 5           
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