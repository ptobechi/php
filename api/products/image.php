<?php
    // INITIALIZE HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // //CREATE DB CONNECTION
    include_once('../../config/db_conn.php');
    include_once('../../model/vendors/vendor.php');
    include_once('../../model/products/products.php');


    $database = new Database();
    $db = $database->connect();
    $product = new Products($db);
    $vendor = new Vendor($db);
    
    $vendor->authenticate(); //Authenticate session

    $product->vid =  isset($_SESSION["vid"]) ? $_SESSION["vid"] : 0;
    

    if(isset($_FILES['image']['name'])){
        
        $filename = $_FILES['image']['name']; // file name
        $rename =  $_POST["pid"].$filename;

        $location = '../../../product image/'.$rename; // Location
        // file extension
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
     
        $valid_ext = array("jpg","png","jpeg");  // Valid extensions
        $max_size = 50000;   // maxim size for image file, in KiloBytes
        $response = 0;
        
        if(in_array($file_extension,$valid_ext)){
            if ($_FILES['image']['size'] <= $max_size * 1000) {
                if ($_FILES['image']['error'] == 0) {
                    // Upload file
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $location)){

                        $product->image =  $rename;
                        $product->pid = $_POST["pid"];
                        if($product->upload()){
                            echo json_encode(
                                array('status' => '201', 'data' => 'Upload Sucessful')
                            );
                            exit;
                        }else{
                            echo json_encode(
                                array('status' => '400', 'data'=> 'Upload Failed')
                            );
                            exit;
                        }                    
                    } 
                }

            }else{ 
                echo json_encode(
                    array('status' => '400', 'data'=> 'The file '. $_FILES['image']['name']. ' exceeds the maximum permitted size'. $max_size.' '. ' KB' )
                );
                exit;
            }
        }
     
    }

    





?>