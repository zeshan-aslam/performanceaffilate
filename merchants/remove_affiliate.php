<?php	ob_start();
   include '../includes/session.php';
   include '../includes/constants.php';
   include '../includes/functions.php';
   include 'lang/english.php';
   include '../mail.php';



$partners=new partners;
$partners->connection($host,$user,$pass,$db);

/******************************variables**************************************/
$affid	   			=$_GET['id'];
$actionflag	  		=$_GET['mode'];  
$pgmname			=$_GET['pgmname'];
$pgmname			=explode("~",$pgmname);
/****************************************************************************/
$sql				="select * from partners_affiliate where affiliate_id='$affid'";
$res				=mysqli_query($con,$sql);

/// check is submitted to remove;
?>

	<SCRIPT LANGUAGE=javascript type="text/javascript">
		function button1_onclick() {
			window.close();
		}
	</SCRIPT>
<?


if($rbtn=="Remove" || $rbtn=="Reject")
        {
           $sql="select * from partners_login,partners_joinpgm where joinpgm_id='$toremove' and login_flag='a' and joinpgm_affiliateid=login_id";
           $ret1=mysqli_query($con,$sql);
           $row=mysqli_fetch_object($ret1);
           $to=$row->login_email;
        ?>
            <div align="center">
            <P>&nbsp;&nbsp;</p>
            <P>&nbsp;&nbsp;</p>
            <big>

           <? if($rbtn=="Remove")
            {
                 $sql="select * from partners_transaction where transavtion_joinid='$toremove'";
                 $ret=mysqli_query($con,$sql) or die('cant exe');

                 if(mysqli_num_rows($ret)>0)
                 {
                			 echo "Affiliate can't be Removed From This Program !!!Transaction Exists";
                 }
                 else
                 {      	 $sql="delete from partners_joinpgm where joinpgm_id='$toremove'";
                             mysqli_query($con,$sql) or die('cant exe');
                     		 MailEvent("Remove AffiliateProgram",$MERCHANTID,$toremove,$to,0);
                     		 echo "Affiliate Removed From This Program !!!";
                 }
            }
            else
            {
            	 $sql="delete from partners_joinpgm where joinpgm_id='$toremove'";
                 mysqli_query($con,$sql) or die('cant exe');
                 MailEvent("Reject AffiliateProgram",$MERCHANTID,$toremove,$to,0);
            	 echo "Affiliate Rejected From This Program !!!";

            }
            ?></big><br/>


            <P>&nbsp;&nbsp;</p>
                         <INPUT id="button1"  type="button" value="<?=$common_close?>" name="button1" LANGUAGE="javascript" onclick="return button1_onclick()">
                    </div>
        <?
       exit;

}

while($row=mysqli_fetch_object($res)){
	$affiliate_id			=$row->affiliate_id;
	$affiliate_firstname	=stripslashes($row->affiliate_firstname);
	$affiliate_lastname		=stripslashes($row->affiliate_lastname);
	$affiliate_company		=stripslashes($row->affiliate_company);
	$affiliate_address		=stripslashes($row->affiliate_address);
	$affiliate_city			=stripslashes($row->affiliate_city);
	$affiliate_country		=stripslashes($row->affiliate_country);
	$affiliate_phone		=stripslashes($row->affiliate_phone);
	$affiliate_url			=stripslashes($row->affiliate_url);
	$affiliate_category		=stripslashes($row->affiliate_category);
	$affiliate_status		=stripslashes($row->affiliate_status);
	$affiliate_date			=stripslashes($row->affiliate_date);
	$affiliate_fax			=stripslashes($row->affiliate_fax);
}

?>


<html>
<head> 
<title><?=$vproaff_head?></title>
</head>
<link rel="stylesheet" type="text/css" href="main.css">
<link rel="stylesheet" type="text/css" href="style.css">
<table border="0" class="tablebdr" cellpadding="0" cellspacing="0" bordercolor="#111111" width="100%" height="303">
  <tr>
    <td width="100%" colspan="5" class="tdhead" align="center"><?=$removeaff_pgm.$pgmname[0]?><td>
  <tr>
  <tr>
    <td width="100%" colspan="5" align="center" height="20"><td>
  <tr>
  <tr>
    <td width="100%" colspan="5" height="19">
    <p align="center" class="textred"><?=$removeaff_doyou.$actionflag.$removeaff_thisaff?></td>
  </tr>
  </tr>


  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$common_id?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_id?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$removeaff_comp?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_company?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$removeaff_fname?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_firstname?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">
    <p align="left"><?=$vproaff_lname?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_lastname?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_addr?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19">
    <p>
      <textarea rows="2" name="add" cols="20"><?=$affiliate_address?></textarea></p>
    </form>
    </td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19"></td>
    <td width="38%" height="19"><?=$vproaff_city?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_city?></td>
    <td width="1%" height="19"></td>
  </tr>
  <tr>
    <td width="2%" height="19"></td>
    <td width="38%" height="19"><?=$vproaff_contry?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_country?> </td>
    <td width="1%" height="19"></td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_phone?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_phone?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_url?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_url?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_category?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_category?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_status?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_status?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19"></td>
    <td width="38%" height="19"><?=$vproaff_jdate?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_date ?></td>
    <td width="1%" height="19"></td>
  </tr>
  <tr>
    <td width="2%" height="15"></td>
    <td width="38%" height="15"><?=$vproaff_fax?></td>
    <td width="1%" height="15"><b>:</b></td>
    <td width="60%" height="15"><?=$affiliate_fax?></td>
    <td width="1%" height="15"></td>
  </tr>
  <tr>
    <td width="100%" colspan="5" align="center" height="20"><td>
  <tr>
  <tr>
  <form name="FormName" action="remove_affiliate.php" method="post">

    <td width="100%" height="10" colspan="5" class="tdhead" align="center">
        <INPUT type="submit" name="rbtn" value="<?=$actionflag?>">

    <input name="toremove" type="hidden" value=<?=$pgmname[1]?> >

    <INPUT type="button" value="<?=$common_close?>" name="button1" LANGUAGE="javascript" onclick="return button1_onclick()">
    </td>
    </form>
   </tr>

</table>

 <?  include 'footer.php'; ?>