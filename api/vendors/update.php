<?php
// INITIALIZE HEADERS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/vendors/vendor.php');

$database = new Database();
$db = $database->connect();

$user = new Vendor($db);

// GET RAW DATA FROM API REQUEST 
// LOOK INTO THIS TO FIX LATER AND CHECK FOR ALTERNATIVE THAT ACCEPTS (MULTI-PART/FORM-data)
// $data = json_decode(file_get_contents("php://input"));

// GET PARSED DATA FROM REQUEST 
foreach($_POST as $name => $value){
    $user->$name =  $value;
}

//RETURNED USER
$logged_user = $user->login();

//CHECK COUNT
$num = $logged_user->rowCount();

if($num > 0){
    $user_arr = array();
    $user_arr["data"] = array();
    
    while($row = $logged_user->fetch(PDO::FETCH_ASSOC)){
        extract($row); //GIVE US DIRECT ACESS TO COLUMUN NAME email, userid WITHOUT $row --- ($row[email], $row['password'], $row['userid'])
        $_SESSION["vid"] = $vid;
    }

    echo json_encode(
        array('status' => '200', 'sessionId' => $_SESSION["vid"])
    );


}else{
    echo json_encode(
        array('status' => '400')
    );
}






?>