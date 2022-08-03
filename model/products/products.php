<?php

class Products{
    // DB PARAM 
    private $conn;
    private $table = "products";
    
    // USER PARAM 
    public $pcategory;
    public $pname;
    public $pamount;
    public $pid;
    public $vid;
    
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
            $query = 'SELECT * FROM '.$this->table.' WHERE pid='.$id.'';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

            do{
                    $gen = uniqid(1,2);
                    $explode = explode('.', $gen);
                    $id = $explode[1]; 

                    $query = 'SELECT * FROM '.$this->table.' WHERE pid='.$id.'';
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
                        pid=:productid,
                        vid=:vendorid,
                        pcategory=:category,
                        pname=:name,
                        pamount=:price,
                        pstatus="1" ';

        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);

        // CLEAN USER DATA
        $this->pcategory = htmlspecialchars(strip_tags($this->pcategory));
        $this->pname = htmlspecialchars(strip_tags($this->pname));
        $this->pamount = htmlspecialchars(strip_tags($this->pamount));
        $this->pid = $this->generateId();
        $this->vid = $_SESSION["vid"];
        
        // BIND PARAM 
        $stmt->bindParam(':category', $this->pcategory);
        $stmt->bindParam(':name', $this->pname);
        $stmt->bindParam(':price', $this->pamount);
        $stmt->bindParam(':vendorid', $this->vid);
        $stmt->bindParam(':productid', $this->pid);

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

    // LIST OF ALL REGISTERED USERS 
    public function productList(){
        try {
            $query = 'SELECT * 
                    FROM 
                        '.$this->table.' o 
            LEFT JOIN 
                vendors v ON o.vid = v.vid 
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

    public function VendorsproductList(){
        $id = $_SESSION["vid"];
        
        try {
            $query = 'SELECT * 
            FROM 
                '.$this->table.' p 
            LEFT JOIN 
                vendors v ON p.vid = v.vid 
            WHERE 
                p.vid='.$id.'
            ORDER BY 
                p.created_at DESC';

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

    public function vendorProductInfo(){
        $id = $_SESSION["vid"];
        try {
            $query = 'SELECT 
                * 
            FROM 
                '.$this->table.' 
            WHERE 
                id = ? AND vid='.$id.'
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

    public function delete(){
        try {
            $query = 'DELETE 
                FROM 
                '.$this->table.' 
            WHERE 
                pid = '.$this->pid.' AND vid='.$this->vid.'
            ';

            $stmt = $this->conn->prepare($query); 

            if($stmt->execute()){
                echo json_encode(
                    array('status' => '201', 'data' => 'done')
                );
            }else{
                echo json_encode(
                    array('status' => '400', 'data' => 'failed')
                );
            }
            
            

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            // return false;  
            exit;
        }

    }

    public function updateStatus(){
        try {
           $query = 'UPDATE 
               '.$this->table.' 
           SET
               pstatus=:status
           WHERE 
               vid='.$this->vid.' AND pid='.$this->pid.'
           ';

           $stmt = $this->conn->prepare($query); 

           // CLEAN USER DATA
           $this->status = htmlspecialchars(strip_tags($this->status));

           // BIND PARAM 
           $stmt->bindParam(':status', $this->status);
           
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
}
