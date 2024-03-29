<?php
// INITIALIZE HEADERS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/post.php');

$database = new Database();
$db = $database->connect();

$user = new Post($db);

//Autthenticate 
// $auth->authenticate();

// get session id 
$user->uid = isset($_SESSION["authid"]) ? $_SESSION["authid"] : die();

// GET RAW DATA FROM API REQUEST 
// LOOK INTO THIS TO FIX LATER AND CHECK FOR ALTERNATIVE THAT ACCEPTS (MULTI-PART/FORM-data)
// $data = json_decode(file_get_contents("php://input"));

foreach($_POST as $name => $value){
    $user->$name =  $value;
}

// SEND DATA TO MODEL FOR INSERTION
if($user->checkOut()){
    echo json_encode(
        array('status' => '201', 'data' => 'successful')
    );
}else{
    echo json_encode(
        array('status' => '400', 'data' => 'failed')
    );
}





?>