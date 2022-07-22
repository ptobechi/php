<?php
// INITIALIZE HEADERS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/products/products.php');

$database = new Database();
$db = $database->connect();

$user = new Products($db);

//RETURNED USER
$logged_user = $user->VendorsproductList();

//CHECK COUNT
$num = $logged_user->rowCount();

if($num > 0){
    $data_arr = array();
    $data_arr["status"] = "200";
    $data_arr["data"] = array();
    
    while($row = $logged_user->fetch(PDO::FETCH_ASSOC)){
        array_push($data_arr["data"], $row);
    }

    echo json_encode($data_arr);


}else{
    echo json_encode(
        array('status' => '400')
    );
}






?>