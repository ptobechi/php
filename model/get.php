<?php

class Chowbox{
    // DB PARAM 
    private $conn;
    private $vendor = "vendors";
    private $products = "products";
    private $users = "register";
    private $order = "sales";

    public $id;
    public $email;
    public $password;

    // ESTABLISH A DATABASE CONNECTION
    public function __construct($db){
        $this->conn = $db;
    }

    public function Vendors(){
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

    public function Menu(){
        try {
            $query = "SELECT * 
                    FROM
                $this->products p
                    LEFT JOIN 
                $this->vendor v ON v.vid = p.vid  
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

    public function login(){
        try {
            $query = "SELECT * 
                        FROM
                    $this->users
                WHERE
                    username= :email AND upassword=:pass            
            ";

            $stmt = $this->conn->prepare($query); 
            // CLEAN USER DATA
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            //BIND PARAM
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':pass', $this->password);
            
            $stmt->execute();
            return $stmt;

        } catch (PDOException $error) {
            printf("Error %s. \n", $error->getMessage());
            exit;
        }
    }

    public function userInfo(){
        try {
            $query = "SELECT * 
                        FROM
                    $this->users
                WHERE
                    uid= ?            
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

    public function userOrder(){
        try {
            $query = "SELECT * 
                        FROM
                    $this->order o
                        LEFT JOIN 
                    $this->vendor v ON v.vid = o.vid  
                WHERE
                    uid= ?            
            ";

            $stmt = $this->conn->prepare($query); 
            // CLEAN USER DATA
            $this->id = htmlspecialchars(strip_tags($this->id));

            //BIND PARAM
            $stmt->bindParam(1, $this->uid);
            
            $stmt->execute();
            return $stmt;

        } catch (PDOException $error) {
            printf("Error %s. \n", $error->getMessage());
            exit;
        }
    }

    
}

?>