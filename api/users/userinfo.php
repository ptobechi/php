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

$user = new Chowbox($db);

// $user->authenticate();

$user->id = isset($_SESSION["authid"]) ? $_SESSION["authid"] : die();

//RETURNED USER
$info = $user->userInfo();

//CHECK COUNT
$num = $info->rowCount();

if($num > 0){
    $data_arr = array();
    $data_arr["status"] = "200";
    $data_arr["data"] = array();
    
    while($row = $info->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $data = array('username' => $username, 'firstname'=> $ufname, 'lastname'=> $ulname, 'contact'=> $ucontact, 'balance'=> $ucredit, 'image'=> $uimage);
        array_push($data_arr["data"], $data);
    }

    echo json_encode($data_arr);


}else{
    echo json_encode(
        array('status' => '400', 'data' => 'Invalid ')
    );
}






?>