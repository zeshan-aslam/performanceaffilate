<?php		ob_start();


# iinclude session variables
  include '../includes/session.php';

# include database constants
  include '../includes/constants.php';

# include common fuctions
  include '../includes/functions.php';

# functions on get and post variables
  include '../includes/allstripslashes.php';

# crete databse instance
  $partners = new partners;

# establish databse connection
  $partners->connection($host,$user,$pass,$db);

  $url = "index.php?Act=uploadProducts&pgmid=$pgmid";

  if (!empty($_FILES['product']['name'])) {
  		$filebody  =  $_FILES['product']['size'];
        $filetype  =  $_FILES['product']['tmp_name'];
        $filename  =  $_FILES['product']['name'];
        $file      =  $_FILES['product']['type'];
        list(,$ext) = explode(".",$filename);

  }
  else{
     header("Location:$url&msg=2");
     exit();
  }

  if(strtolower($ext) !="csv"){
     header("Location:$url&msg=4");
     exit();

  }

 $fp 		= fopen ($filetype, "r");
 $bytes 	= filesize($filetype);
 $buffer 	= fread($fp, $bytes);

 fclose ($fp);


 $buffer = trim($buffer,"\n");

// $lines  = explode("\n",$buffer);

 $cont1 = explode('"',$buffer);
 for($h=0;$h<count($cont1);$h++)
 {
        if(($h%2) and $h != 0)
	        {
            	$sep	= chr(13).chr(10);
            	$question = str_replace($sep, '', $question );
            	$cont1[$h] = str_replace($sep," ",$cont1[$h]);
            	$cont1[$h] = str_replace(";","~#~",$cont1[$h]);
            }
 }


$contents1 = implode('"', $cont1);

$lines = explode("\n",$contents1);

 for ($i=0; $i<count($lines); $i++) {

  $fields	= array();
  $fields   = explode(";",$lines[$i]);

  if(count($fields)!= 6)  {
       $Err = 1;
     	header("Location:$url&msg=1");
     	exit();
  }


 }

  $status 	  = "Inactive";
  $sql_upload = "INSERT INTO partners_upload(upload_programid,upload_status) VALUES('$pgmid','$status')";

  mysqli_query($con,$sql_upload);
  $id = mysql_insert_id();

  $new  = "upload_".$id.".".$ext;
  $dest = "../images/uploads/".$new;
  copy($filetype,$dest);

  for ($i=0; $i<count($lines); $i++) {

  	$fields	   = array();
  	$fields    = explode(";",$lines[$i]);

    for($j=0;$j<count($fields);$j++){
         $fields[$j]    = str_replace("~#~",";",$fields[$j]);
         $fields[$j]    = trim(addslashes($fields[$j]));
    }

     $sql = "INSERT INTO partners_product (prd_programid,prd_number, prd_product,  prd_desc, prd_price, prd_image, prd_url, prd_catid, prd_catname, prd_uploadid) VALUES ('$pgmid', '$fields[0]', '$fields[1]', '$fields[2]', '$fields[3]' ,'$fields[4]' ,'$fields[5]','$fields[6]','$fields[7]', $id) ";
     mysqli_query($con,$sql) or die(mysqli_error($con));

 }

 $sql_upload = "UPDATE partners_upload SET upload_filename='$new' ,upload_actualfile='$filename' WHERE upload_id = '$id' ";

 mysqli_query($con,$sql_upload);
 header("location:index.php?Act=uploadProducts&pgmid=$pgmid&msg=3");
 exit();
?>