<?php
// INITIALIZE HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/get.php');


$database = new Database();
$db = $database->connect();

$vList = new Chowbox($db);

//RETURNED Vendors
$list = $vList->Vendors();

//CHECK COUNT
$num = $list->rowCount();

if($num > 0){
    $data_arr = array();
    $data_arr["status"] = "200";
    $data_arr["data"] = array();
    
    while($row = $list->fetch(PDO::FETCH_ASSOC)){
        extract($row); //GIVE US DIRECT ACESS TO COLUMUN NAME email, userid WITHOUT $row --- ($row[email], $row['password'], $row['userid'])
        $data = array('id'=>$vid, 'vendor'=>$vname,'location'=>$vlocation, 'image'=>$vimage);
        array_push($data_arr["data"], $data);
    }
    echo json_encode($data_arr);

}else{
    echo json_encode(
        array('status' => '400', 'data' => '')
    );
}






?>