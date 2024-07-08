<?php		ob_start();




# iinclude session variables
  include '../includes/session.php';

# include database constants
  include '../includes/constants.php';

# include common fuctions
  include '../includes/functions.php';

# functions on get and post variables
  include '../includes/allstripslashes.php';

# create databse instance
  $partners = new partners;

# establish databse connection
  $partners->connection($host,$user,$pass,$db);

  $id  = intval($_GET['id']);

  $sql = "SELECT * FROM partners_product WHERE prd_uploadid= '$id' ";
  $ret = mysqli_query($con,$sql);
  $AFFILIATEID = $_SESSION['AFFILIATEID'];

  $conent = "ArtNumber, Title, Description_short, DisplayPrice, Img_url, DeepLink1, ProductCategoryID, ProductCategoryName \n";

  if(mysqli_num_rows($ret)>0){
     while($row  = mysqli_fetch_object($ret)){
       $prd_name    = trim(stripslashes($row->prd_product));
       $prd_number  = trim(stripslashes($row->prd_number));
       $prd_desc    = trim(stripslashes($row->prd_desc));
       $prd_price   = trim(stripslashes($row->prd_price));
       $prd_catid   = trim(stripslashes($row->prd_catid));
       $prd_catname = trim(stripslashes($row->prd_catname));
       $prd_image   = $track_site_url."/trackingcode.php?aid=$AFFILIATEID&linkid=R$row->prd_id&type=1";
       $prd_url     = $track_site_url."/trackingcode.php?aid=$AFFILIATEID&linkid=R$row->prd_id&type=2";

      $conent .= $prd_number.",".$prd_name.",".$prd_desc.",".$prd_price.",".$prd_image.",".$prd_url.",".$prd_catid.",".$prd_catname."\n";

     }
  }

   $filename = "product_".$AFFILIATEID.".csv";
   $file	 = "../images/uploads/".$filename;
   $fp = fopen ($file, "w");
   fwrite ($fp, $conent);
   fclose ($fp);

  $ContentType        = "application/vnd.ms-excel";
  $filename = "product_".$AFFILIATEID.".csv";
  $file	 = "../images/uploads/".$filename;
  $newFile	= "product.csv";
  header ("Content-Type: $ContentType");
  header ("Content-Disposition: attachment; filename=$newFile");


  $fp                       = fopen($file,'r');
  $contents                 = fread ($fp, filesize ($file));
  fclose($fp);

  echo  $contents;
?>