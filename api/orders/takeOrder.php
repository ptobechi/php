<?php
// INITIALIZE HEADERS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/orders/orders.php');

$database = new Database();
$db = $database->connect();

$user = new Order($db);

//Autthenticate user
// $auth->authenticate();

// GET RAW DATA FROM API REQUEST 
// LOOK INTO THIS TO FIX LATER AND CHECK FOR ALTERNATIVE THAT ACCEPTS (MULTI-PART/FORM-data)
// $data = json_decode(file_get_contents("php://input"));

// GET PARSED DATA FROM REQUEST  
// echo $_POST["orders"];
// print_r(json_encode($_POST["orders"]));
// die;
foreach($_POST as $name => $value){
    $user->$name =  $value;
}

// SEND DATA TO MODEL FOR INSERTION
if($user->register()){
    echo json_encode(
        array('status' => '201', 'data' => 'order placed successful')
    );
}else{
    echo json_encode(
        array('status' => '400', 'data' => 'unable to place an order atthe moment')
    );
}





?>