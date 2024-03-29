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

$vendor = new Vendor($db);

$vendor->id = isset($_GET["id"]) ? $_GET["id"] : die();

//RETURNED USER
$vprofile = $vendor->vendorProfile();

//CHECK COUNT
$num = $vprofile->rowCount();
 
if($num > 0){
    $data_arr = array();
    $data_arr["status"] = "200";
    $data_arr["data"] = array();
    
    while($row = $vprofile->fetch(PDO::FETCH_ASSOC)){
        array_push($data_arr["data"], $row);
    }

    echo json_encode($data_arr);


}else{
    echo json_encode(
        array('status' => '400')
    );
}






?>