<?php
// INITIALIZE HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/vendors/vendor.php');
include_once('../../model/products/products.php');


$database = new Database();
$db = $database->connect();

$user = new Vendor($db);
$product = new Products($db);
$user->authenticate();

// GET RAW DATA FROM API REQUEST 
// LOOK INTO THIS TO FIX LATER AND CHECK FOR ALTERNATIVE THAT ACCEPTS (MULTI-PART/FORM-data)
// $data = json_decode(file_get_contents("php://input"));

// GET PARSED DATA FROM REQUEST 
foreach($_POST as $name => $value){
    $product->$name =  $value;
}

$product->vid = $_SESSION["vid"];

//RETURNED USER
$product->updateStatus();








?>