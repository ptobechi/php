<?php
// if(isset($_FILES['file']['name'])){
//     // file name
//     $filename = $_FILES['file']['name'];
 
//     // Location
//     $location = '../../user profile pics/'.$filename;
 
//     // file extension
//     $file_extension = pathinfo($location, PATHINFO_EXTENSION);
//     $file_extension = strtolower($file_extension);
 
//     // Valid extensions
//     $valid_ext = array("pdf","doc","docx","jpg","png","jpeg");
 
//     $response = 0;
//     if(in_array($file_extension,$valid_ext)){
//        // Upload file
//        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
//           $response = 1;
//        } 
//     }
 
//     echo $response;
//     exit;
// } 
    // $fileName = $_FILES['file']['name'];
    // $fileTmpName = $_FILES['file']['tmp_name'];
    // $fileType = $_FILES['file']['type'];
    // $fileSize = $_FILES['file']['size'];
    // $fileError = $_FILES['file']['error'];

    // $fileExt = explode('.',$fileName);
    // $fileActualExt = strtolower(end($fileExt));
    // $allowed = array('jpg','pdf','jpeg','png');

    // if(in_array($fileActualExt,$allowed)){
    //     if($fileError == 0){
    //         if($fileSize < 5000000){
    //             $fileNameNew = $fileName.$fileActualExt;
    //             $fileDestination = "../../user profile pics/";
        
    //             $move = move_uploaded_file($fileTmpName, "../../user profile pics/".$fileName);
                
    //             if($move){
    //                 // return true;
    //                 echo json_encode(
    //                     array('status' => '200', 'data' => 'failed')
    //                 );

    //             }else{
    //                 echo json_encode(
    //                     array('status' => '400', 'data' => 'failed')
    //                 );
    //             }
    //         }else{
    //             echo json_encode(
    //                 array('status' => '400', 'data' => 'failed')
    //             );
    //         }
    //     }else{
    //         echo json_encode(
    //             array('status' => '400', 'data' => 'failed')
    //         );
    //     }
    // }else{
    //     echo json_encode(
    //         array('status' => '400', 'data' => 'failed')
    //     );
    // }