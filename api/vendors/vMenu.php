<?php
// INITIALIZE HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../config/db_conn.php');
include_once('../../model/get.php');

$database = new Database(); //Create DB Connection
$db = $database->connect(); //Return DB Connection

$menu = new Chowbox($db);

$menu->id = isset($_GET["id"]) ? $_GET["id"] : die();  //GET ID OF VENDOR

$list = $menu->Menu();      //RETURNED Vendors

$num = $list->rowCount();  //CHECK COUNT

if($num > 0){
    $data_arr = array();
    $data_arr["status"] = "200";
    $data_arr["data"] = array();
    
    while($row = $list->fetch(PDO::FETCH_ASSOC)){
        extract($row); //GIVE US DIRECT ACESS TO COLUMUN NAME email, userid WITHOUT $row --- ($row[email], $row['password'], $row['userid'])

        $data_arr['vendor'] = $vname;
        $data_arr['storeid'] = $vid;
        $data_arr['address'] = $vlocation;
        $data_arr["contact"] = $vcontact;
        $data_arr["image"] = $vimage;
        
        $data = array(
            'category'=> $pcategory,
            'product'=> $pname,
            'price' => $pamount,
            'addons' => $paddons,
        );
        array_push($data_arr["data"], $data);
    }
    echo json_encode($data_arr);

}else{
    echo json_encode(
        array('status' => '400', 'data'=>'Nulls')
    );
}






?>