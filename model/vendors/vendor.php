<?php

class Vendor{
    // DB PARAM 
    private $conn;
    private $table = "vendors";
    private $authid;
    
    // USER PARAM 
    public $id;
    public $vid;
    public $vname;
    public $vemail;
    public $vuname;
    public $vphone;
    public $vbank;
    public $vaccount;
    public $vaccount_no;
    public $vimage;
    public $password;
    public $contact;

    // ESTABLISH A DATABASE CONNECTION
    public function __construct($db){
        $this->conn = $db;
    }

    public function authenticate(){
        
        $this->authid = isset($_SESSION["vid"]) ? $_SESSION["vid"] : 0;

        try {
            $query = 'SELECT * FROM '.$this->table.' WHERE vid="'.$this->authid.'"';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

            if($num > 0){
                return true;
            }else{
                
                echo json_encode(
                    array('status' => '401', 'data' => 'session expired')
                );
                // return false;
                exit;
            }

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            // return false;  
            exit;

        }
    }

    public function generateId(){
        
        // GENERATE UNIQUE ID FOR TABLE COLUMN
        $gen = uniqid(1,2);
        $explode = explode('.', $gen);
        $id = $explode[1];  

        try {
            $query = 'SELECT * FROM '.$this->table.' WHERE vid='.$id.'';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

        do{
                $gen = uniqid(1,2);
                $explode = explode('.', $gen);
                $id = $explode[1]; 

                $query = 'SELECT * FROM '.$this->table.' WHERE vid='.$id.'';
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
            $query = 'SELECT * FROM '.$this->table.' WHERE vemail="'.$this->email.'"';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

            if($num > 0){
                // echo("Email address already exists");
                echo json_encode(
                    array('status' => '400', 'message' => 'Email address already exists')
                );
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

    public function upload(){
        try {
            $query = 'UPDATE 
                '.$this->table.' 
            SET
                vimage=:vimage
            WHERE 
                vid=:userid
            '; 

            $stmt = $this->conn->prepare($query); 

            // CLEAN USER DATA
            $this->vimage = htmlspecialchars(strip_tags($this->vimage));

            // BIND PARAM 
            $stmt->bindParam(':vimage', $this->vimage);
            $stmt->bindParam(':userid', $this->id);
            
            $stmt->execute();
            
            return $stmt;

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
                        vid=:restuarant_id,
                        name=:name,
                        email=:email,
                        phone=:phone,
                        location=:location,
                        username=:username,
                        password=:password ';

        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        
        // CLEAN USER DATA
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->restuarant_id = $this->generateId();
        
        // ENCRYPT PASSWORD 
        $md5_password = md5($this->password);

        // BIND PARAM 
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone_number);
        $stmt->bindParam(':restuarant_id', $this->restuarant_id);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':password', $md5_password);

        // CHECK IF EMAIL ALREADY EXISTS
        $this->checkEmail();

        // EXECUTE THE QUERY
        if($stmt->execute()){
            return true;
            exit;
        }

        // PRINT ERROR IF QUERY FAILED TO EXECUTE
        printf("Error %s. \n", $stmt->error);
        return false; 
        exit;   
    } 

    // USER LOGIN AUTHYENTICATION
    public function login(){
        try {
            // ENCRYPT PASSWORD 
            $md5_password = md5($this->password); 

            $query = 'SELECT * FROM '.$this->table.' WHERE vemail="'.$this->vemail.'" AND vpassword="'.$md5_password.'"';
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

    public function vendorProfile(){
        // $id = $_SESSION["vid"];
        try {
            $query = 'SELECT * 
            FROM 
                '.$this->table.'  
            WHERE 
                vid=?  
            ';

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

    public function update(){
         try {
            $query = 'UPDATE 
                '.$this->table.' 
            SET
                vname=:name,
                vemail=:email,
                vlocation=:location,
                vcontact=:contact
            WHERE 
                vid=:userid
            ';

            $stmt = $this->conn->prepare($query); 

            // CLEAN USER DATA
            $this->vname = htmlspecialchars(strip_tags($this->vname));
            $this->vemail = htmlspecialchars(strip_tags($this->vemail));
            $this->vphone = htmlspecialchars(strip_tags($this->vphone));
            $contact_info = json_encode($this->contact);

            // BIND PARAM 
            $stmt->bindParam(':name', $this->vname);
            $stmt->bindParam(':email', $this->vemail);
            $stmt->bindParam(':location', $this->vlocation);
            $stmt->bindParam(':contact', $contact_info);
            $stmt->bindParam(':userid', $this->id);
            
            $stmt->execute();
            
            echo json_encode(
                array('status' => '200', 'data' => 'Update successful')
            );

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            // return false;  
            echo json_encode(
                array('status' => '400', 'data' => "Update failed")
            );
            exit;
        }
    }

    public function updateStatus(){
        try {
           $query = 'UPDATE 
               '.$this->table.' 
           SET
               vstatus=:status
           WHERE 
               vid= :userid
           ';

           $stmt = $this->conn->prepare($query); 

           // CLEAN USER DATA
           $this->status = htmlspecialchars(strip_tags($this->status));

           // BIND PARAM 
           $stmt->bindParam(':status', $this->status);
           $stmt->bindParam(':userid', $this->vid);
           
           $stmt->execute();
           
           echo json_encode(
               array('status' => '200', 'data' => 'Update successful')
           );

       } catch (PDOException $e) {
           // PRINT ERROR IF QUERY FAILED TO EXECUTE
           // printf("Error %s. \n", $e->getMessage());
           // return false;  
           echo json_encode(
               array('status' => '200', 'data' => "Update failed")
           );
           exit;
       }
    }

    // TRENDING RESTURANTS
    public function tVendors(){
        try {
            $query = 'SELECT * 
                FROM 
            '.$this->table.' ';

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

    // AVAILABLE RESTURANTdS
    public function aVendors(){
        try {
            $query = 'SELECT * 
                FROM 
            '.$this->table.' ';

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
