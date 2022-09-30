<?php
// INITIALIZE HEADERS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// //CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/orders/orders.php');
include_once('../../model/vendors/vendor.php');


$database = new Database();
$db = $database->connect();

$user = new Order($db);
$auth = new Vendor($db);

//Autthenticate vendor
$auth->authenticate();

$user->id = isset($_GET["id"]) ? $_GET["id"] : 0;
$user->vid =  isset($_SESSION["vid"]) ? $_SESSION["vid"] : 0;


//RETURNED USER
$logged_user = $user->vendorOrderInfo();

//CHECK COUNT
$num = $logged_user->rowCount();
 
if($num > 0){
    $data_arr = array();
    $data_arr["status"] = "200";
    $data_arr["data"] = array();
    
    while($row = $logged_user->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $data = array('id' => $oid, 'customer' => $ulname." ".$ufname, 'contact' => $ucontact, 'address' => $address, 'status' => $ostatus, 'order'=> $content, 'total'=> $osum, 'delivery_time' => $odd, 'upload_date' => $ocreated_at);

        array_push($data_arr["data"], $data);
    }

    echo json_encode($data_arr);


}else{
    echo json_encode(
        array('status' => '400')
    );
}






?>