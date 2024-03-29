<?php

class Vendor{
    // DB PARAM 
    private $conn;
    private $table = "vendors";
    private $vid;
    
    // USER PARAM 
    public $id;
    public $vname;
    public $vemail;
    public $vuname;
    public $vphone;
    public $vlocation;
    public $vimage;
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
            $query = 'SELECT * FROM '.$this->table.' WHERE vemail="'.$this->vemail.'"';
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
                        vid=:vid,
                        vname=:name,
                        vemail=:email,
                        vphone=:phone,
                        vlocation=:location,
                        vuname=:username,
                        vpassword=:password ';

        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);
        
        // CLEAN USER DATA
        $this->vname = htmlspecialchars(strip_tags($this->vname));
        $this->vemail = htmlspecialchars(strip_tags($this->vemail));
        $this->vuname = htmlspecialchars(strip_tags($this->vuname));
        $this->vphone = htmlspecialchars(strip_tags($this->vphone));
        $this->vlocation = htmlspecialchars(strip_tags($this->vlocation));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->vid = $this->generateId();
        
        // ENCRYPT PASSWORD 
        $md5_password = md5($this->password);

        // BIND PARAM 
        $stmt->bindParam(':name', $this->vname);
        $stmt->bindParam(':username', $this->vuname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->vphone);
        $stmt->bindParam(':vid', $this->vid);
        $stmt->bindParam(':location', $this->vlocation);
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

            $query = 'SELECT * FROM '.$this->table.' WHERE vemail="'.$this->vemail.'" AND password="'.$md5_password.'"';
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

    public function storeList(){
        try {
            $query = 'SELECT * FROM '.$this->table.' ORDER BY id DESC';
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

    public function storeinfo(){
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
}
