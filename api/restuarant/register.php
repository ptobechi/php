<?php
// INITIALIZE HEADERS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/admin/restuarant.php');

$database = new Database();
$db = $database->connect();

$data = new Restuarant($db);

// GET RAW DATA FROM API REQUEST 
// LOOK INTO THIS TO FIX LATER AND CHECK FOR ALTERNATIVE THAT ACCEPTS (MULTI-PART/FORM-data)
// $data = json_decode(file_get_contents("php://input"));

// GET PARSED DATA FROM REQUEST 
foreach($_POST as $name => $value){
    $data->$name =  $value;
}

// SEND DATA TO MODEL FOR INSERTION
if($data->register()){
    echo json_encode(
        array('status' => '201')
    );
}else{
    echo json_encode(
        array('status' => '400')
    );
}





?>