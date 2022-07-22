<?php

class Order{
    // DB PARAM 
    private $conn;
    private $table = "orders";
    // private $userid;
    
    // USER PARAM 
    // public $firstname;
    // public $lastname;
    public $orders;
    // public $userid;
    // public $phone_number;
    // public $password;

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
            $query = 'SELECT * FROM '.$this->table.' WHERE oid='.$id.'';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

        do{
                $gen = uniqid(1,2);
                $explode = explode('.', $gen);
                $id = $explode[1]; 

                $query = 'SELECT * FROM '.$this->table.' WHERE oid='.$id.'';
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

    // USERS REGISTRATION
    public function register(){
        // CREATE QUERY
        $query = 'INSERT INTO '.$this->table.'
                    SET
                        oid=:orderid,
                        vid=:vendorid,
                        uid=:userid,
                        ocontent=:requeste,
                        desc="Nothing"';

        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);

        // CLEAN USER DATA
        $this->userid = 9557529;
        // $this->orders = htmlspecialchars(strip_tags($this->orders));
        $this->orderid = $this->generateId();
        // $orders = "okau";
        
        // ENCRYPT PASSWORD 
        // $md5_password = md5($this->password);

        // BIND PARAM 
        $stmt->bindParam(':orderid', $this->orderid);
        $stmt->bindParam(':vendorid', $this->vendorid);
        $stmt->bindParam(':requeste', $this->orders);
        $stmt->bindParam(':userid', $this->userid);

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

    // ORDER LIST 
    public function orderList(){
        try {
            $query = 'SELECT * 
                    FROM 
                        '.$this->table.' o 
            LEFT JOIN 
                register r ON o.userid = r.userid 
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

    // USER DETAILS
    public function userInfo(){
        try {
            $query = 'SELECT 
                * 
            FROM 
                '.$this->table.' 
            WHERE 
                id = ?
            LIMIT 0,1';

            $stmt = $this->conn->prepare($query); 

            //BIND PARAM
            $stmt->bindParam(1, $this->id);
            
            $stmt->execute();
            
            return $stmt;

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            // return false;  
            exit;
        }
    }

    public function vendorOrderList(){
        $id = $_SESSION["vid"];
        
        try {
            $query = 'SELECT * 
            FROM 
                '.$this->table.' o 
            LEFT JOIN 
                register r ON o.uid = r.uid 
            WHERE 
                o.vid='.$id.'
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

    public function vendorOrderInfo(){
        $id = $_SESSION["vid"];
        try {
            $query = 'SELECT * 
            FROM 
            '.$this->table.' o 
            LEFT JOIN 
                register r ON o.uid = r.uid  
            WHERE 
                o.oid = ? AND o.vid='.$id.'
            LIMIT 0,1';

            $stmt = $this->conn->prepare($query); 

            //BIND PARAM
            $stmt->bindParam(1, $this->id);
            
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
