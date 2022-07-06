<?php

class Restuarant{
    // DB PARAM 
    private $conn;
    private $table = "restuarant";
    private $restuarant_id;
    
    // USER PARAM 
    public $name;
    public $email;
    public $username;
    public $phone_number;
    public $location;
    public $cover;
    public $password;

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
            $query = 'SELECT * FROM '.$this->table.' WHERE restuarant_id='.$id.'';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

        do{
                $gen = uniqid(1,2);
                $explode = explode('.', $gen);
                $id = $explode[1]; 

                $query = 'SELECT * FROM '.$this->table.' WHERE restuarant_id='.$id.'';
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

    public function upload(){
        $id = $this->generateId();

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];

        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg','pdf','jpeg','png');

        if(in_array($fileActualExt,$allowed)){
            if($fileError == 0){
                if($fileSize < 5000000){

                    $fileNameNew = $id.$fileName;
                    $fileDestination = "../../file manager/";
            
                    $move = move_uploaded_file($fileTmpName, "../../file manager/".$fileNameNew);
                    
                    return $fileNameNew;

                }else{
                    // IF FILE SIZE IS MORE THAN 5mb 
                    exit;
                }
            }else{
                 // IF FILE IS CURROUPT | UNKWONN  | NOT SUPPORTED
                 exit;
            }
        }else{
             // IF FILE NOT SUPPORTED 
             exit;
        }

    }

    // USERS REGISTRATION
    public function register(){
        // CREATE QUERY
        $query = 'INSERT INTO '.$this->table.'
                    SET
                        restuarant_id=:restuarant_id,
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
}
