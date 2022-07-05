<?php

class userAccess{
    // DB PARAM 
    private $conn;
    private $table = "register";
    
    // USER PARAM 
    public $firstname;
    public $lastname;
    public $email;
    public $username;
    public $phone_number;
    public $password;

    // ESTABLISH A DATABASE CONNECTION
    public function __construct($db){
        $this->conn = $db;
    }

    // USERS REGISTRATION
    public function register(){
    
        // CREATE QUERY
        $query = 'INSERT INTO '.$this->table.'
                    SET
                        firstname=:firstname,
                        lastname=:lastname,
                        email=:email,
                        password=:password
                ';

        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);

        // CLEAN USER DATA
        $this->firtsname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // BIND PARAM 
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

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
        
    }
}
