<?php	ob_start();


//=============================================================================//
/*  Last Modfd	: 11/1/2005                                                   */
/*  Script Name	: admin_currency.php               			                  */
//=============================================================================//


# iinclude session variables
  include '../includes/session.php';

# include database constants
  include '../includes/constants.php';

# include common fuctions
  include '../includes/functions.php';

# functions on get and post variables
  include '../includes/allstripslashes.php';

# crete databse instance
  $partners=new partners;

# establish databse connection
  $partners->connection($host,$user,$pass,$db);

#-------------------------------------------------------------------------------
# getting back form variables
#-------------------------------------------------------------------------------
  $currency_caption  = trim(stripslashes($_POST['currency_caption']));
  $currency_symbol	 = $currArray[$currency_caption];
  $currency_relation = trim(stripslashes($_POST['currency_relation']));
  $mode				 = trim(stripslashes($_GET['mode']));
  $id				 = intval(trim(stripslashes($_GET['id'])));


#---------------------------ends Here-------------------------------------------

# delete a currency
if($mode=="delete")
{
	$caption = $_GET['caption'];
	$sql = "DELETE FROM partners_currency WHERE currency_caption = '$caption'";
	mysql_query($sql);
	
	header("location:index.php?Act=currency&mode=add");
	exit;
}


# return url if validation fails
 $url = "index.php?Act=currency&id=$id&mode=$mode&currency_caption=$currency_caption&currency_symbol=$currency_symbol&currency_relation=$currency_relation";

# validation
 if(empty($currency_caption))   $err = "1";
 else							$err = "0";


 if(empty($currency_relation))  $err .= ".1";
 else							$err .= ".0";

 # redirecting since empty fileds are there
 if($err != "0.0") {
     $msg = 1;
     header("location:$url&msg=$msg");
     exit();
 }

 if(!is_numeric($currency_relation)) {
     $msg = 8;
     header("location:$url&msg=$msg");
     exit();
 }

  $currency_caption  = trim(addslashes($_POST['currency_caption']));
   $currency_symbol	 = $currArray[$currency_caption];
   $today = date("Y-m-d");


//New modifications for setting the relations of Currency by SMA on 4-Aug-2006

     $sql = "SELECT * FROM partners_currency WHERE currency_code = '$currency_caption' ";  
     $ret = mysql_query($sql) or die("<br/>You have an error while comparing currency values<br/>");

	if(mysql_num_rows($ret) > 0)
	{
		$sql_relation = "INSERT INTO partners_currency_relation SET ".
		" relation_currency_code = '". addslashes($currency_caption)."' , ".
		" relation_value = ".$currency_relation." , ".
		" relation_date = '".$today."' ";
		$res_relation = mysql_query($sql_relation);
		
		$msg = 4;
	}	
	else {
		$msg = 12;
	}

	header("location:index.php?Act=currency&msg=$msg");
	exit();

// End new Modify   
   

/*   
   
 if($mode=="Add"){ 

     #-------------------------------------------------------------------------------
     #  chceking if currency already exists
     #-------------------------------------------------------------------------------
     $sql = "SELECT * FROM partners_currency WHERE currency_code = '$currency_caption' "; echo "qry = ".$sql;
     $ret = mysql_query($sql) or die("<br/>You have an error while comparing currency values<br/>");

     if(mysql_num_rows($ret)>0){ 
       $sql = "UPDATE partners_currency SET currency_caption='$currency_caption' , currency_symbol='$currency_symbol', currency_relation='$currency_relation' WHERE currency_caption = '$currency_caption' and currency_date = '$today'";
       mysql_query($sql)or die("<br/>You have an error while editing currency values<br/>");;
       $msg = 10;
     }
     #-------------------------------------------------------------------------------
     else{ 


     $sql = "INSERT INTO partners_currency(currency_caption, currency_symbol, currency_relation, currency_date )VALUES('$currency_caption', '$currency_symbol', '$currency_relation','$today') ";
     mysql_query($sql) or die("<br/>You have an error while adding currency values<br/>"); ;


     $msg = 3;
     }
 }else{  

     #-------------------------------------------------------------------------------
     #  chceking if currency already exists
     #-------------------------------------------------------------------------------
     $sql = "SELECT * FROM partners_currency WHERE currency_caption = '$currency_caption' AND currency_id <> $id ";
     $ret = mysql_query($sql) or die("<br/>You have an error while comparing currency values<br/>");

     if(mysql_num_rows($ret)>0){
        $msg = 2;
     	header("location:$url&msg=$msg");
        exit();
     }
    #-------------------------------------------------------------------------------

     $sql = "UPDATE partners_currency SET currency_caption='$currency_caption' , currency_symbol='$currency_symbol', currency_relation='$currency_relation' WHERE currency_id = $id  ";
     mysql_query($sql)or die("<br/>You have an error while editing currency values<br/>");;

     $msg = 4;
 }

  header("location:index.php?Act=currency&msg=$msg");
  exit();
  
*/  
 ?>