<?php
    // INITIALIZE HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // //CREATE DB CONNECTION
    include_once('../../config/db_conn.php');
    include_once('../../model/vendors/vendor.php');

    $database = new Database();
    $db = $database->connect();
    $data = new Vendor($db);
    $data->authenticate(); //Authenticate session
    $data->vimage =  $_FILES['image']['name'];
    $data->id =  $_SESSION["vid"];

    if(isset($_FILES['image']['name'])){
        
        $filename = $_FILES['image']['name']; // file name
        $rename = $_SESSION["vid"].$filename;
        $location = '../../../uploads/'.$rename; // Location
        // file extension
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
     
        $valid_ext = array("jpg","png","jpeg");  // Valid extensions
        $max_size = 250;   // maxim size for image file, in KiloBytes
        $response = 0;
        
        if(in_array($file_extension,$valid_ext)){
            if ($_FILES['image']['size'] <= $max_size * 1000) {
                if ($_FILES['image']['error'] == 0) {
                    // Upload file
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $location)){
                        $response = 1;
                    } 
                }

            }else{ 
                echo json_encode(
                    array('status' => '400', 'data'=> 'The file '. $_FILES['image']['name']. 'exceeds the maximum permitted size'. $max_size )
                );
                exit;
            }
        }
     
    }
// exit;
    if($response = 1){
        // SEND DATA TO MODEL FOR INSERTION
        if($data->upload()){
            echo json_encode(
                array('status' => '201', 'data' => '')
            );
            exit;
        }else{
            echo json_encode(
                array('status' => '400', 'data'=> '')
            );
            exit;
        }
    }else{
        echo json_encode(
            array('status' => '400', 'data'=> 'The file <b>'. $_FILES['image']['name']. '</b> exceeds the maximum permitted size <i>'. $max_size. 'KB</i>' )
        );
        exit;
    }

    





?>