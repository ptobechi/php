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

$obj = new Chowbox($db);

$obj->email = $_POST["email"];
$password = $_POST["password"];
$obj->password = md5($password);

$user = $obj->login();

//CHECK COUNT
$num = $user->rowCount();
if($num > 0){
    $http_user = array();
    while($row = $user->fetch(PDO::FETCH_ASSOC)){
        extract($row); //GIVE US DIRECT ACESS TO COLUMUN NAME email, userid WITHOUT $row --- ($row[email], $row['password'], $row['userid'])
        $_SESSION["authid"] = $uid;
        $_SESSION["username"] = $username;
    }
    echo json_encode(
        array('status' => '200', 'data' => 'Login Successful')
    );

}else{
    echo json_encode(
        array('status' => '400', 'data' => 'Invalid Login')
    );
}






?>