<?php		ob_start();
/***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW  programs DEATAILS
      VARIABLES          :
                              $merid                                   =merchantid
                                                          $pgmid                                   =programid
                                                           $status                              =status of joinpgm
                              $pgm_des                      =program description
                                           $links                            =total no of links added
                              $merchant_firstname          =firstname
                                                  $merchant_lastname     =last name
                                                   $merchant_company            =company name
                                                  $merchant_address      =caompany address
                              $merchant_url                =url
                                                  $merchant_category     =category
                              $merchant_status            =status
                                                  $merchant_date         =date of joining

  //*************************************************************************************************/

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	include_once '../includes/allstripslashes.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

?>
 <script language="javascript" type="text/javascript">
     function confirm(status)
     {
     if (status=='approved')
         return true;
     else
         alert("Your status must be approved to GetLinks");
         return false;
     }

 </script>


<?php

 /***********************variables*********************************************/
 $merid                     = intval($_GET['id']);            //merchantid
 $pgmid                     = intval($_GET['pgmid']);         //programid
 $status                    = $_GET['status'];        //status of joinpgm
 /*****************************************************************************/


 /******************getting details*******************************************/
 $sql           ="select * from partners_program where program_id='$pgmid'";
 $result    =mysqli_query($con,$sql);
  echo mysql_error();
 $sql           ="select * from partners_merchant where merchant_id='$merid'";
 $res           =mysqli_query($con,$sql);




 while($row=mysqli_fetch_object($res)){



         $merchant_id        =trim(stripslashes($row->merchant_id));              //merchantid
         $merchant_firstname =trim(stripslashes($row->merchant_firstname));       //firstname
         $merchant_lastname  =trim(stripslashes($row->merchant_lastname));        //last name
         $merchant_company   =trim(stripslashes($row->merchant_company));         //company name
         $merchant_address   =trim(stripslashes($row->merchant_address));         //aompany address
         $merchant_city      =trim(stripslashes($row->merchant_city));            //city
         $merchant_country   =trim(stripslashes($row->merchant_country));         //country
         $merchant_phone     =trim(stripslashes($row->merchant_phone));           //phone
         $merchant_url       =trim(stripslashes($row->merchant_url));             //url
         $merchant_category  =trim(stripslashes($row->merchant_category));        //category
         $merchant_status    =trim(stripslashes($row->merchant_status));          //status
         $merchant_date      =trim(stripslashes($row->merchant_date));            //date of joining
         $merchant_fax       =trim(stripslashes($row->merchant_fax));             // fax

                }

  while($rows=mysqli_fetch_object($result))
             {
                 $pgm_des       =trim(stripslashes($rows->program_description));   //program description
             }

    $links=GetLinks($pgmid);                                                       //total no of links added
 /******************************************************************************/
?>


<br/>
<table border="0" class="tablewbdr" cellpadding="0" cellspacing="0"  width="100%" >
			<tr>
            <td width="50%" valign="top" align="center" >
            <table border="0" class="tablebdr1" cellpadding="0" cellspacing="0"   width="97%" align="right">
                   <tr>
                            <td width="100%"  class="tdhead" height="19" colspan="2"  align="center">
                            <?=$lang_MerchantsProfile?> </td>
                   </tr>
                   <tr>
                           <td width="100%" colspan="2" height="8"></td>
                   </tr>
                   <tr>
                           <td width="50%" height="20" align="left"> <b><?=$lang_URL?>:</b><?=$merchant_url?></td>
                           <td width="50%" height="20" align="right"><b><?=$lang_Company?>:</b> <?=$merchant_company?></td>
                   </tr>
                   <tr>
                           <td width="50%" height="20" align="left"><b><?=$lang_Registered?> :</b><?=$merchant_date?></td>
                           <td width="50%" height="20" align="right"><b><?=$lang_Category?> :</b><?=$merchant_category?></td>
                   </tr>
                   <tr>
                           <td width="50%" height="40" align="left"></td>
                           <td width="50%" height="40" align="right"></td>
                   </tr>
                   <tr>
                           <td width="100%" height="40" colspan="2" align="center" > <b><?=$lang_ProgramDescription?></b></td>
                   </tr>
                   <tr>
                           <td width="100%" height="40" colspan="2"  align="center"><p><?=$pgm_des?></p></td>
                   </tr>
                   <tr>
                           <td width="100%" height="40" colspan="2" > <?=$lang_YourStatus?> :<img src="../images/<?=$status?>.gif" height="15" width="15" alt="" /><b><?=$status?></b></td>
                   </tr>
                   <tr>
                           <td width="100%" height="19" colspan="2" class="tdhead" align="center"></td>
                   </tr>
            </table>
            </td>
            <td width="30%" valign="top" >
            <table  cellpadding="0" cellspacing="0" width="97%" class="tablebdr1" align="center">
                   <tr>
                         <td width="100%"  class="tdhead" height="19" align="center">
                         <?=$lang_ProgramDetails?></td>
                  </tr>

                  <tr>
                          <td width="100%" align="center" ><br/>
                          <p><?=$merchant_company?> <?=$lang_hascreated?>
                                                   <?=$links?> <?=$lang_links?> <?=$title?>.<?=$lang_thus?> <?=$merchant_company?></p>
                          </td>
                   </tr>
                   <tr>
                         <td width="100%" align="center" ><br/>
                         <p> <a href="index.php?Act=Getlinks" onclick="return confirm('<?=$status?>')"><b><?=$lang_affiliate_getlinks?></b></a> <?=$lang_fromMerchantSite ?></p></td>
                   </tr>
                   <tr>
                         <td width="100%" height="100%" align="center">
                         <br/>
                         <p>
                         <?=$lang_your?><b>Approved</b> <?=$lang_togetlinks?> <?=$merchant_company?><br/></p> </td>
                   </tr>
                   <tr>
                         <td width="100%" height="19"  class="tdhead" align="center"></td>
                 </tr>
            </table>
            </td>
			</tr>
</table>

   <?
   /************getting total no of links of a particular pgm******************/
     function GetLinks($pgmid)
     {
                           $sql="select * from partners_banner where banner_programid ='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nobanner=mysqli_num_rows($result);
                           $sql="select * from partners_text where text_programid ='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $notext=mysqli_num_rows($result);
                           $sql="select * from partners_popup where popup_programid ='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nopopup=mysqli_num_rows($result);
                           $sql="select * from partners_flash where flash_programid ='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $noflash=mysqli_num_rows($result);
                           $sql="select * from partners_html where html_programid ='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nohtml=mysqli_num_rows($result);
                           $link=$nobanner+$nohtml+$notext+$nopopup+$noflash;

         return($link);
     }
     /*************************************************************************/
   ?>