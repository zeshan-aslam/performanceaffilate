<?php
include_once '../includes/db-connect.php';

$id   = $_POST['merchantid'];
$dir = "uploadedimage/";
if (isset($_FILES['ajax_file'])) {



  $imge = $_FILES['ajax_file'];
  $filename = $imge['name'];
  $types = array('image/jpeg', 'image/gif', 'image/png');
  if (in_array($imge['type'], $types)) {
    if ($imge['size'] <= 10000000) {
      $destination = $dir . $imge['name'];

      //=================Start Image width and height validation for 150*150 =================//
      $max_width = 150; // set to desired maximum width
      $max_height = 150; // set to desired maximum height
      $imge = $_FILES['ajax_file']['tmp_name'];
      list($width, $height) = getimagesize($imge);
      if ($width > $max_width || $height > $max_height) {
        $size_err = "Error: Image size exceeds maximum limit ($max_width x $max_height pixels).";
      } else {
        // move the uploaded file to a permanent location
        // $isuploaded = move_uploaded_file($imge['tmp_name'], $destination);
        $isuploaded = move_uploaded_file($imge, $destination . $_FILES['ajax_file'][$filename]);
      }
      //=================End Image width and height validation for 150*150 =================//

      // $isuploaded = move_uploaded_file($imge['tmp_name'], $destination);
      if ($isuploaded) {
        $sql1 = "UPDATE `partners_affiliate` SET `affilate_profileimage` = '$filename'
           WHERE `affiliate_id` = '$id'";
        $result = mysqli_query($con, $sql1);

        if ($result) {
          echo json_encode(array("status" => "success", "message" => "File has been uploaded successfully"));
        } else {
          echo json_encode(array("status" => "fail", "message" => "Some error1 to upload this file"));
        }
      } else {
        echo json_encode(array("status" => "fail", "message" => $size_err));
      }
    } else {
      echo json_encode(array("status" => "fail", "message" => "File size can't more than 1 MB"));
    }
  } else {
    echo json_encode(array("status" => "fail", "message" => "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes."));
  }
} else {
  echo json_encode(array("status" => "fail", "message" => "File size can't more than 1 MB"));
}
