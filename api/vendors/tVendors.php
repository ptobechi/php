<?php
// INITIALIZE HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/vendors/vendor.php');


$database = new Database();
$db = $database->connect();

$vendors = new Vendor($db);

//RETURNED USER
$vendor = $vendors->tVendors();

//CHECK COUNT
$num = $vendor->rowCount();

if($num > 0){
    $data_arr = array();
    $data_arr["status"] = "200";
    $data_arr["data"] = array();
    
    while($row = $vendor->fetch(PDO::FETCH_ASSOC)){
        array_push($data_arr["data"], $row);
    }

    echo json_encode($data_arr);


}else{
    echo json_encode(
        array('status' => '400')
    );
}






?>