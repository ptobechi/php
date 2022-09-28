<?php
// INITIALIZE HEADERS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//CREATE DB CONNECTION
include_once('../../config/db_conn.php');
include_once('../../model/post.php');

$database = new Database();
$db = $database->connect();

$user = new Post($db);

//Autthenticate 
// $auth->authenticate();

// get session id 
$user->uid = isset($_SESSION["authid"]) ? $_SESSION["authid"] : 0;
        
if(isset($_FILES['file']['name'])){
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileType = $_FILES['file']['type'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];

  $fileExt = explode('.',$fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpg','jpeg','png');

  if(in_array($fileActualExt,$allowed)){
      if($fileError == 0){
          if($fileSize < 5000000){
              $fileDestination = "../../../user profile pics/";
              $picture = $_SESSION["authid"].$fileName;
      
              $move = move_uploaded_file($fileTmpName, $fileDestination.$picture);
              
              if($move){
                $user->image = $picture;

                //update picture in db
                if($user->upload()){
                  echo json_encode(
                      array('status' => '201', 'data' => 'Update Successful')
                    );
                }else{
                    echo json_encode(
                        array('status' => '400', 'data' => 'Update Failed')
                    );
                }

              }else{
                  echo json_encode(
                      array('status' => '400', 'data' => 'upload failed try again')
                  );
              }
          }else{
              echo json_encode(
                  array('status' => '400', 'data' => 'file size too large, upload less than 5mb')
              );
          }
      }else{
          echo json_encode(
              array('status' => '400', 'data' => 'An error occured uploading file try again')
          );
      }
  }else{
      echo json_encode(
          array('status' => '400', 'data' => 'unsupported file type')
      );
  }

} 






?>