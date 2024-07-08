<?php
   	include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

           $err=$_GET['msg'];
		   $note = $_REQUEST['suc_msg'];
		   
			if(!empty($err))
			{

                $firstname        = stripslashes(trim($_GET['firstname']));
                $lastname         = stripslashes(trim($_GET['lastname']));
                $company          = stripslashes(trim($_GET['company']));
                $url              = stripslashes(trim($_GET['url']));
                //$address          =stripslashes(trim($_GET['address']));
                $city             = stripslashes(trim($_GET['city']));
                $category         = stripslashes(trim($_GET['category']));
                $phone            = stripslashes(trim($_GET['phone']));
                $fax              = stripslashes(trim($_GET['fax']));
                $mailid           = stripslashes(trim($_GET['mailid']));
                $type             = stripslashes(trim($_GET['type']));
                $state            = stripslashes(trim($_GET['state']));
                $zip	          = stripslashes(trim($_GET['zip']));
                $taxId            = stripslashes(trim($_GET['taxId']));
                $country          = $_GET['country'];

               //$address                =stripslashes(trim($_GET['address']));
				$address          = $_SESSION['MER_ADDRESS'];
			}

	                     $sql    = "select * from partners_login where login_id ='$MERCHANTID' and login_flag='m'";
	                     $result = mysqli_query($con,$sql);

	                         while($row=mysqli_fetch_object($result))
	                                {
	                                             $emailid=$row->login_email;
	                                             $origin=$row->login_email;
	                                             $oldpassword=$row->login_password;
	                                }

			 if($err=="")
               {

	               $sql="select * from partners_merchant where merchant_id='$MERCHANTID'";
	               $res=mysqli_query($con,$sql);
	               echo mysqli_error($con);

	               while($row=mysqli_fetch_object($res))
	                 {
	                   $firstname                        = stripslashes(trim($row->merchant_firstname));
	                   $lastname                         = stripslashes(trim($row->merchant_lastname));
	                   $company                          = stripslashes(trim($row->merchant_company));
	                   $url                              = stripslashes(trim($row->merchant_url));
	                   $address                          = stripslashes(trim($row->merchant_address));
	                   $category                         = stripslashes(trim($row->merchant_category));
	                   $phone                            = stripslashes(trim($row->merchant_phone));
	                   $fax                              = stripslashes(trim($row->merchant_fax));
	                   $type                             = stripslashes(trim($row->merchant_type));
	                   $city                             = stripslashes(trim($row->merchant_city));
	                   $country                          = stripslashes(trim($row->merchant_country));
	                   $status                           = stripslashes(trim($row->merchant_status));
                       $state                            = stripslashes(trim($row->merchant_state));
	                   $zip		                         = stripslashes(trim($row->merchant_zip));
	                   $taxId                            = stripslashes(trim($row->merchant_taxId));

	                 }

               }  //closing of err if

?>

<script id="clientEventHandlersJS" language="javascript" type="text/javascript">
<!--

function a1_onclick() {
//window.open("login_edit.php",200,100);
window.open("login_edit.php",'new','height=250,width=500,scrollbars=no');

}

//-->
</script>
<br/>
<div align="center">
  <center>         <font color="#ff0000" size="2" ><b><?=stripslashes($_GET['msg1'])?></b></font>
  <table border="0" cellpadding="0" cellspacing="0" width="70%" id="AutoNumber1" class="tablebdr">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="49%">&nbsp;</td>
      <td width="49%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
    </tr>
     <tr>
      <td width="1%">&nbsp;</td>
      <td width="95%" colspan="2" class="textred" align="center"><?=stripslashes($fromprg)?>&nbsp;</td>
      <td width="1%">&nbsp;</td>
    </tr>

    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%" colspan="2" rowspan="2">
    <table border="0" cellspacing="1" align="center" width="57%" class="tablebdr">
      <tr>
        <td width="100%" colspan="3" align="center" height="19" class="tdhead">
        <b><?=$lang_MerchantLoginInfo?></b> </td>
      </tr>
       <tr>
        <td width="100%" colspan="3" align="center" height="25" class="txtred">
        <font color="#ff0000" size="1"><?=$Err?></font></td>
      </tr>
      <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="30%" height="28"><?=$lang_EmailId?></td>
        <td width="66%" height="28"><input type="text" name="login" size="25" value="<?=$emailid?>"/></td>
      </tr>
      <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="30%" height="28"><?=$lang_Password?></td>
        <td width="66%" height="28">
        <input type="password" name="password" size="25" value="<?=$oldpassword?>"/></td>
      </tr>
      <tr>
        <td width="100%" height="13" colspan="3" align="center">
        <a href="#" id="a1"  onclick="return a1_onclick()"><?=$lang_Edit?></a></td>
      </tr>
    </table>
		<br/>

<?php
        //////////////////////////// next form
?>
	  </td>
      <td></td>
	</tr>
  </table>
 <br/>
<form method="post" name="reg" action="accounts_validate.php?mode=update">
<table border="0" cellpadding="0"  align="center" cellspacing="0" width="70%" id="AutoNumber2"  class="tablebdr">
    <tr>
      <td colspan="7" height="19" class="tdhead" align="center"><b> <?=$lang_MerchantContactInfo?></b></td>
    </tr>
    <tr>
      <td colspan="7" height="19" class="textred" align="center"><?=$err?>&nbsp;<?=$note?></td>
    </tr>
    <tr>
      <td height="26" colspan="2" align="right"><?=$lang_FirstName?></td>
      <td width="2%">&nbsp;</td>
      <td width="36%" height="26" align="left">
      <input type="text" name="firstnametxt" size="20" value="<?=$firstname?>" /></td>
      <td width="19%" height="26" align="right"><?=$lang_Category?></td>
      <td width="2%">&nbsp;</td>
      <td width="24%" height="26" align="left">
      <select size="1" name="categorylst" >
      <option value="nill">----<?=$selectacategory?>----</option>
      <?php
    $sql    = "select * from partners_category";
    $result = mysqli_query($con,$sql);
?>

<?php
    while($row=mysqli_fetch_object($result))
    {
    if(trim($category)==trim($row->cat_name))
    {
?>
                <option value="<?=$row->cat_name?>" selected="selected" ><?=$row->cat_name?></option>
<?php
        }
    else{
?>
                <option value="<?=$row->cat_name?>" ><?=$row->cat_name?></option>
<?php
             }
    }
?>



      </select></td>
    </tr>
    <tr>
      <td height="29" colspan="2" align="right"><?=$lang_LastName?></td>
      <td width="2%">&nbsp;</td>
      <td width="36%" height="29" align="left">
      <input type="text" name="lastnametxt" size="20" value="<?=$lastname?>"/></td>
      <td width="19%" height="29" align="right"><?=$lang_Phone?></td>
      <td width="2%">&nbsp;</td>
      <td width="24%" height="29" align="left"><input type="text" name="phonetxt" size="20" value="<?=$phone?>"/></td>
    </tr>
    <tr>
      <td height="31" colspan="2" align="right"><?=$lang_Company?></td>
      <td width="2%">&nbsp;</td>
      <td width="36%" height="31" align="left">
      <input type="text" name="companytxt" size="20" value="<?=$company ?>"/></td>
      <td width="19%" height="31" align="right"><?=$lang_Fax?></td>
      <td width="2%">&nbsp;</td>
      <td width="24%" height="31" align="left"><input type="text" name="faxtxt" size="20" value="<?=$fax?>"/></td>
    </tr>
    <tr>
      <td height="28" colspan="2" align="right"><?=$lang_URL?></td>
      <td width="2%">&nbsp;</td>
      <td width="36%" height="28" align="left"><input type="text" name="urltxt" size="20" value="<?=$url?>" /></td>

      <td width="19%" height="28" align="right"><span class="style6"></span> <?=$lang_zip?></td>
              <td >&nbsp;</td>
              <td height="28" align="left" ><input type="text" name="ziptxt" size="20" value="<?=$zip?>" />
			</td>
            </tr>
    <tr>
      <td height="66" colspan="2" rowspan="2" align="right"><?=$lang_Address?></td>
      <td width="2%" rowspan="2">&nbsp;</td>
      <td width="36%" height="66" rowspan="2" align="left">
      <textarea rows="3" name="addresstxt" cols="20"><?=$address?></textarea></td>

      <td width="19%" height="24" align="right"><?=$lang_City?></td>

      <td width="2%">&nbsp;</td>
      <td width="24%" height="24" align="left"><input type="text" name="citytxt" size="20" value="<?=$city?>"/></td>
    </tr>
    <tr>
      <td width="19%" height="22" align="right"> <?=$lang_state?></td>

      <td width="2%">&nbsp;</td>
      <td width="24%" height="22" align="left">
      <input type="text" name="statetxt" size="20" value="<?=$state?>" />
     </td>
    </tr>
     <tr>
              <td height="28" colspan="2" align="right"><span class="style6"><?=$lang_Country?>
              </span></td>
              <td width="2%">&nbsp;</td>
              <td width="36%" height="28" align="left"> <select size="1" name="countrylst">
      <option value="nill" >----<?=$lang_SelectaCountry?>----</option>

      <?php
    $sql    = "select * from partners_country";
    $result = mysqli_query($con,$sql);
?>

<?php
    while($row=mysqli_fetch_object($result))
    {
    if($country==$row->country_name)
    {
?>
                <option value="<?=$row->country_name?>" selected="selected" ><?=$row->country_name?></option>
<?php
        }
    else{
?>
                <option value="<?=$row->country_name?>" ><?=$row->country_name?></option>
<?php
             }
    }
?>



      </select></td>
                 <td width="19%" height="28" align="right"><?=$lang_Type ?></td>
                 <td >&nbsp;</td>
          <td height="28" align="left" >

   <input name="typelst" type="hidden" value="<?=trim($type)?>" />

      <select size="1"  name="typelst" disabled="disabled">

      <?
      if (trim($type)=="nill") {

       $nill="selected = 'selected'";

       }

       if (trim($type)=="advance") {

       $adv="selected = 'selected'";

       }

       if (trim($type)=="normal") {


       $nor="selected = 'selected'";

       }
       ?>

      <option value="nill"><?=$account_selecttype?></option>

      <option value="advance" <?=$adv?>><?=$account_advance?></option>
      <option value="normal" <?=$nor?>><?=$account_normal?></option>
      </select></td>
	  </tr>
    <tr>
            <td height="19" colspan="2" align="right">              <?=$lang_taxId?></td>
            <td width="2%">&nbsp;</td>
            <td width="36%" height="19" align="left"><input type="text" name="taxIdtxt" size="20" value="<?=$taxId?>" /></td>
   		   <td width="19%" height="19" align="right">&nbsp;</td>
   		   <td width="2%" valign="bottom">&nbsp;</td>
   		   <td width="24%" height="19" align="left" valign="bottom">&nbsp;</td>
    </tr>
    <tr>
    		<td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td height="18" colspan="7" align="center">

      <input type="submit" value="<?=$account_editcont?>" name="B1" alt="<?=$lang_Edit?>" />

      <?
            	if($type=="normal")
                {
      ?>
                <input type="submit" value="<?=$account_updateto?>" name="Upgrade" id="Upgrade"/>
       <?
                }
      ?>
      </td>
    </tr>
    <tr>
    		<td colspan="7">&nbsp;</td>
    </tr>  </table><br />
<input name="status" type="hidden" value="<?=$status?>" />
</form>


<!-- Added on 25-July-2006 for merchants Sign Up lik for the Merchant  -->
<?
	$linkobj	= new merchantLink();

	$linkobj->merchantSignUpLink($MERCHANTID);
	$mer_header	= $linkobj->mer_header;
	$mer_footer	= $linkobj->mer_footer;

?>
<form method="post" name="signup" action="" onSubmit="return ValidateSignUp();">
	<table border="0" cellpadding="5"  align="center" cellspacing="0" width="70%" id="AutoNumber2"  class="tablebdr">
		<tr>
		  <td colspan="3" height="19" class="tdhead" align="center"><b>
		  <?=$lang_merchantSignUpLink?></b></td>
		</tr>
		<tr>
			<td colspan="3" align="center" ><b><?=$lang_merchantSignUpHelp?></b></td>
		</tr>
		<tr>
			<td><?=$lang_MerchantHeader?></td>
			<td>
				<textarea name="txt_header" cols="47" rows="5"></textarea>
			</td>
			<td><a href="#" onClick="window.open('viewlink.php?merid=<?=$MERCHANTID?>&disp=header','new','100,400,scrollbars=1,resizable=1')" ><? if($mer_header){ echo $lang_viewheader; } ?></a></td>
		</tr>
		
		<tr>
			<td><?=$lang_MerchantFooter?></td>
			<td>
				<textarea name="txt_footer" cols="47" rows="5"></textarea>
			</td>
			<td><a href="#" onClick="window.open('viewlink.php?merid=<?=$MERCHANTID?>&disp=footer','new','100,400,scrollbars=1,resizable=1')" ><? if($mer_footer){ echo $lang_viewfooter; } ?></a></td>
		</tr>
		<tr>
			<td colspan="3" align="center" >
				<input type="submit" name="Signup" value="<?=$common_submit?>" />&nbsp;&nbsp;&nbsp;
				<input type="reset" name="cancel" value="<?=$common_cancel?>" />
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center"><?=$lang_affiliateLinkHelp?></td>
		</tr>
		<tr>
			<td colspan="3" align="center" height="30"><b><a href="<?=$track_site_url."/merchant_link.php?mid=$MERCHANTID"?>"><? echo $track_site_url."/merchant_link.php?mid=$MERCHANTID"; ?></a></b></td>
		</tr>
	</table>
</form>
<br />
<script language="javascript">
	function ValidateSignUp()
	{
		if(document.signup.txt_header.value == '')
		{
			alert('<?=$err_nullheader?>');
			document.signup.txt_header.focus();
			return false;
		}
		if(document.signup.txt_footer.value == '')
		{
			alert('<?=$err_nullfooter?>');
			document.signup.txt_footer.focus();
			return false;
		}
		document.signup.action='signuplink_validate.php?mid=<?=$MERCHANTID?>';
		document.signup.submit();
	}
</script>
  </center>
</div>