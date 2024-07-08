<?php
# including all needed files
include_once 'includes/db-connect.php';
include_once 'includes/constants.php';
include_once 'includes/functions.php';
include_once 'includes/session.php';
include_once 'includes/encode_decodeFunction.php';
 
    $msg='';
    $token =$_GET['etf'];
    // if(isset($token))
    // {
    //     $response = MultipleTimeEncode($token);
    // }else{
    //     $response='';
    //     echo "Token Not Verified";
    // }
    // echo $token;

    $api_url = "https://plantback.co.uk/advr_rec.php?ret='$token'";
    // Read JSON file
    $json_data = file_get_contents($api_url);
    // Decode JSON data into PHP array
    $response_data = json_decode($json_data,true);
   
 foreach($response_data as $row)
 {
     $status = $row['status'];
     $program_id =$row['program_id'];
     if($status=='1')
     {
        $update_query ="UPDATE partners_program SET program_status='active' WHERE program_id='$program_id'"; 
        $run_query =mysqli_query($con,$update_query);
        if($run_query){
            $msg='SUCCESS';
        }else{
            $msg ="FAILED";
        }
     }else{
        $update_query ="UPDATE partners_program SET program_status='inactive' WHERE program_id='$program_id'"; 
        $run_query =mysqli_query($con,$update_query);
        if($run_query){
            $msg='SUCCESS';
        }else{
            $msg ="FAILED";
        }
     }
    

 }
 echo $msg;
 ?>