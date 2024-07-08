<?php
# include all files
include_once 'includes/db-connect.php';
include_once 'includes/constants.php';
include_once 'includes/functions.php';
include_once 'includes/session.php';

     #--------------------------------------------------------------
     # inserting API User
     #--------------------------------------------------------------
     // Check if the request method is POST
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       // $token =$_GET['token'];
          // Check if the authentication token is valid
        if ($_SERVER['HTTP_AUTHORIZATION'] !== 'Token abcdefghijklmnopqrstuvwxyz') {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
          //  exit;
        }
        // Get the data from the request body
        $data = json_decode(file_get_contents('php://input'), true);
      
        // Validate the data
        if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data']);
            exit;
        }
      
        // Prepare the SQL statement
        $username = $con->real_escape_string($data['username']);
        $email = $con->real_escape_string($data['email']);
        $password = md5($con->real_escape_string($data['password']));
        $sql = "INSERT INTO users (username, email,password) VALUES ('$username', '$email', '$password' )";
      
          // Execute the SQL statement
          if ($con->query($sql) === TRUE) {
              echo json_encode(['message' => 'Data inserted successfully']);
          } else {
              http_response_code(500);
              echo json_encode(['error' => $con->error]);
          }
          header("Access-Control-Allow-Origin: chrome-extension://jablfhaoakofhkfnjkhdpchimgglabie");
        } 

        // else {
        //   http_response_code(405);
        //   echo json_encode(['error' => 'Method Not Allowed']);
        // }
      

?>