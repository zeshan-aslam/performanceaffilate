<?php	ob_start();

 include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include '../includes/allstripslashes.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);

 $elements      = $_POST['elements'];
 $newsite       = $track_site_url."/admin/mass/affiliateList.csv";
 $accType       = trim($_GET['accType']);

 if(file_exists($newsite)) unlink($newsite);

 $file          = "mass/affiliateList.csv";
 $fp            = fopen($file,'w');

 $toWrite   =   "Paypal Eamil, Amount, Currency, Affiliate \n";
 fwrite($fp,$toWrite);

 for($i=0;$i<count($elements);$i++){

   $id  = $elements[$i];

   $sql  =   " SELECT * FROM partners_affiliate AS A , partners_request AS R , partners_bankinfo AS B " ;
   $sql .=   " WHERE R.request_id = '$id' ";
   $sql .=   " AND B.bankinfo_modeofpay = 'Paypal' ";
   $sql .=   " AND R.request_affiliateid = A.affiliate_id ";
   $sql .=   " AND B.bankinfo_affiliateid = A.affiliate_id ";

   $ret  = mysql_query($sql);

   if(mysql_num_rows($ret)>0){
          $row              = mysql_fetch_object($ret);
          $affiliateName    = trim(stripslashes($row->affiliate_firstname))." ".trim(stripslashes($row->affiliate_lastname));
          $requestAmnt      = $row->request_amount;
          $paypalEmail      = $row->bankinfo_paypalemail;

          $toWrite   =   $paypalEmail.",".$requestAmnt.","."USD".",".$affiliateName."\n";
          fwrite($fp,$toWrite);
   }
 }

 if(filesize ($filename)) {
       $toWrite   =   $paypalEmail.",".$requestAmnt.","."USD".",".$affiliateName."\n";
       fwrite($fp,$toWrite);
 }


  $ContentType        = "application/msword";
  $filename           = "mass/affiliateList.csv";
  $nfilename           = "affiliateList.csv";
  header ("Content-Type: $ContentType");
  header ("Content-Disposition: attachment; filename=$nfilename");


  $fp                       = fopen($filename,'r');
  $contents                 = fread ($fp, filesize ($filename));
  fclose($fp);

  echo  $contents;
?>