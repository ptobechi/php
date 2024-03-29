<?php
// INITIALIZE HEADERS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/products/products.php');

$database = new Database();
$db = $database->connect();

$user = new Products($db);

// GET RAW DATA FROM API REQUEST 
// LOOK INTO THIS TO FIX LATER AND CHECK FOR ALTERNATIVE THAT ACCEPTS (MULTI-PART/FORM-data)
// $data = json_decode(file_get_contents("php://input"));

// GET PARSED DATA FROM REQUEST 
// echo $_POST["orders"];
// die;
foreach($_POST as $name => $value){
    $user->$name =  $value;
}
$user->vid = isset($_SESSION["vid"]) ? $_SESSION["vid"] : 0;


// SEND DATA TO MODEL FOR INSERTION
if($user->register()){
    echo json_encode(
        array('status' => '201', 'data' => 'Upload successful')
    );
}else{
    echo json_encode(
        array('status' => '400', 'data' => 'Upload failed')
    );
}





?>