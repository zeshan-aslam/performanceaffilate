<?php		ob_start();

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';


  $partners = new partners;
  $partners->connection($host,$user,$pass,$db);

  include_once 'language_include.php';


  $id	=	intval($_GET['id']);

  /*
  		Checking for valid Id.
  */
  if(is_numeric($id)){
 	  $sql = "SELECT * FROM partners_upload  WHERE upload_id = '$id' ";
	  $ret = mysqli_query($con,$sql) ;

	  if(mysqli_num_rows($ret)>0){
	     while( $row = mysqli_fetch_object($ret) ){
	         $filename = stripslashes($row->upload_filename);
	     }
	  }

      /*
      		Set Product status to deleted.
      */
	  $sql = "update partners_upload  SET upload_status='deleted' WHERE upload_id = '$id' ";
	  $ret = mysqli_query($con,$sql);

	  $sql = "update partners_product  SET prd_status='Inactive' WHERE prd_uploadid = '$id' ";
	  $ret = mysqli_query($con,$sql);

      /*
            Delete the product file.
      */
	  $filePath = "../images/uploads/".$filename;
	  if(file_exists($filePath)){
	    unlink($filePath);
	  }
  }
  header("Location:index.php?Act=uploadProducts&pgmid=$pgmid&msg=5");
  exit;
?>
