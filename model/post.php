<?php

class Post{
    // DB PARAM 
    private $conn;
    private $vendor = "vendors";
    private $order_tbl = "sales";
    private $products = "products";
    private $users = "register";

    public $id;
    public $order;
    public $oid;
    public $uid;
    public $vid;
    public $osum;
    public $lname;
    public $fname;
    public $contact;
    public $home;
    public $work;
    public $image;

    // ESTABLISH A DATABASE CONNECTION
    public function __construct($db){
        $this->conn = $db;
    }

    public function generateId($table, $rid){
        
        // GENERATE UNIQUE ID FOR TABLE COLUMN
        $gen = uniqid(1,2);
        $explode = explode('.', $gen);
        $id = $explode[1];  

        try {
            $query = 'SELECT * FROM '.$table.' WHERE '.$rid.'='.$id.'';
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            //CHECK COUNT
            $num = $stmt->rowCount();

            do{
                    $gen = uniqid(1,2);
                    $explode = explode('.', $gen);
                    $id = $explode[1]; 

                    $query = 'SELECT * FROM '.$table.' WHERE '.$rid.'='.$id.'';
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

    public function Post(){
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

    public function checkOut(){
        // CREATE QUERY
        $query = 'INSERT INTO '.$this->order_tbl.'
                    SET
                        oid         =:orderid,
                        uid         =:userid,
                        vid         =:vendorid,
                        content     =:order,
                        osum        =:sum                    ';

        // PREPARE STATEMENT FOR INSERTING
        $stmt = $this->conn->prepare($query);

        // CLEAN USER DATA
        $this->uid = htmlspecialchars(strip_tags($this->uid));
        $this->vid = htmlspecialchars(strip_tags($this->vid));
        $this->osum = htmlspecialchars(strip_tags($this->osum));
        $this->orderid = $this->generateId(''.$this->order_tbl.'', 'oid');
        $this->order = json_encode($this->order);


        // BIND PARAM 
        $stmt->bindParam(':orderid', $this->orderid);
        $stmt->bindParam(':userid', $this->uid);
        $stmt->bindParam(':vendorid', $this->vid);
        $stmt->bindParam(':order', $this->order);
        $stmt->bindParam(':sum', $this->osum);

        // EXECUTE THE QUERY
        if($stmt->execute()){
            return true;
        }

        // PRINT ERROR IF QUERY FAILED TO EXECUTE
        printf("Error %s. \n", $stmt->error);
        return false;    
    }

    public function update(){
        try {
            $query = 'UPDATE 
                '.$this->users.' 
            SET
                ufname=:firstname,
                ulname=:lastname,
                ucontact=:contact,
                address=:address,
                alt_address=:altaddress
            WHERE 
                uid=:userid
            ';

            $stmt = $this->conn->prepare($query); 

            // CLEAN USER DATA
            $this->fname = htmlspecialchars(strip_tags($this->fname));
            $this->lname = htmlspecialchars(strip_tags($this->lname));
            // $this->contact = htmlspecialchars(strip_tags($this->contact));
            $this->home = htmlspecialchars(strip_tags($this->home));
            $this->work = htmlspecialchars(strip_tags($this->work));
            $contact = json_encode($this->contact);

            // BIND PARAM 
            $stmt->bindParam(':firstname', $this->fname);
            $stmt->bindParam(':lastname', $this->lname);
            $stmt->bindParam(':address', $this->home);
            $stmt->bindParam(':altaddress', $this->work);
            $stmt->bindParam(':userid', $this->uid);
            $stmt->bindParam(':contact', $contact);

           
            if($stmt->execute()){
                return true;
            }

            // echo json_encode(
            //     array('status' => '200', 'data' => 'Update successful')
            // );

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            // return false;  
            // echo json_encode(
            //     array('status' => '200', 'data' => "Update failed")
            // );
            return false;
            exit;
        }
    }

    public function upload(){
        try {
            $query = 'UPDATE 
                '.$this->users.' 
            SET
                uimage=:image
            WHERE 
                uid=:userid
            ';

            $stmt = $this->conn->prepare($query); 

            // CLEAN USER DATA
            $this->home = htmlspecialchars(strip_tags($this->image));

            // BIND PARAM 
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':userid', $this->uid);

           
            if($stmt->execute()){
                return true;
            }

        } catch (PDOException $e) {
            // PRINT ERROR IF QUERY FAILED TO EXECUTE
            printf("Error %s. \n", $e->getMessage());
            return false;
            exit;
        }
    }


    
}

?>