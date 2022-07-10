<?php

class Products{
    // DB PARAM 
    private $conn;
    private $table = "products";
    private $product_id;
    private $restuarant_id;
    
    // USER PARAM 
    public $category;
    public $name;
    public $price;
    

    // ESTABLISH A DATABASE CONNECTION
    public function __construct($db){
        $this->conn = $db;
    }

    public function generateId(){
        
        // GENERATE UNIQUE ID FOR TABLE COLUMN
        $gen = uniqid(1,2);
        $explode = explode('.', $gen);
        $id = $explode[1];  

        try {
            $query = 'SELECT * FROM '.$this->table.' WHERE product_id='.$id.'';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

            do{
                    $gen = uniqid(1,2);
                    $explode = explode('.', $gen);
                    $id = $explode[1]; 

                    $query = 'SELECT * FROM '.$this->table.' WHERE product_id='.$id.'';
                    $stmt = $this->conn->prepare($query); 
                    $stmt->execute();
                    $num = $stmt->rowCount();

            }while ($num > 0);
        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            return false;  
        }
        

       return $id;
    }

    public function checkEmail(){
        try {
            $query = 'SELECT * FROM '.$this->table.' WHERE email="'.$this->email.'"';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

            if($num > 0){
                echo("Email address already exists");
                // return false;
                exit;
    
            }else{
                return true;
            }

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            // return false;  
            exit;

        }

    }

    // USERS REGISTRATION
    public function register(){
        // CREATE QUERY
        $query = 'INSERT INTO '.$this->table.'
                    SET
                        product_id=:product_id,
                        restuarant_id=:restuarant_id,
                        category=:category,
                        product_name=:name,
                        price=:price';

        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);

        // CLEAN USER DATA
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->product_id = $this->generateId();
        $this->restuarant_id = 80321002;
        
        // BIND PARAM 
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':restuarant_id', $this->restuarant_id);
        $stmt->bindParam(':product_id', $this->product_id);

        // CHECK IF EMAIL ALREADY EXISTS
        // $this->checkEmail();

        // EXECUTE THE QUERY
        if($stmt->execute()){
            return true;
        }

        // PRINT ERROR IF QUERY FAILED TO EXECUTE
        printf("Error %s. \n", $stmt->error);
        return false;    
    }

    // USER LOGIN AUTHYENTICATION
    public function login(){
        try {
            // ENCRYPT PASSWORD 
            $md5_password = md5($this->password); 

            $query = 'SELECT * FROM '.$this->table.' WHERE email="'.$this->email.'" AND password="'.$md5_password.'"';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            return $stmt;

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            // return false;  
            exit;
        }
    }

    // LIST OF ALL REGISTERED USERS 
    public function productList(){
        try {
            $query = 'SELECT * 
                    FROM 
                        '.$this->table.' o 
            LEFT JOIN 
                restuarant r ON o.restuarant_id = r.restuarant_id 
            ORDER BY 
                o.created_at DESC';

            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            return $stmt;

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            // return false;  
            exit;
        }
    }
}
