<?php		ob_start();

    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

	include_once 'language_include.php';

    $groupname                =trim(($_POST['txtgroupname']));
    $click                    =trim(($_POST['txtclick']));
    $lead                     =trim(($_POST['txtlead']));
    $sale                     =trim(($_POST['txtsale']));
    $saletype                 =trim(($_POST['txtsaletype']));
    $programs                 =intval(trim(($_POST['programs'])));
    $groupid                  =intval(trim(($_GET['id'])));
    $add                      =trim(($_POST['add']));
    $MERCHANTID               = $_SESSION['MERCHANTID'];

     $pgmDate               = date("Y-m-d");
     $currValue				= $_POST['currValue'];
    // echo $groupid;
   if(!empty($add))
   {
   	$err = 0;
    if (empty($groupname))
	{
		$groupname                =trim(stripslashes($_POST['txtgroupname']));
		$msg=$lnewgrp_error1	;
		header("Location:index.php?Act=add_group&click=$click&lead=$lead&sale=$sale&saletype=$saletype&Err=$msg&groupname=$groupname&id=$groupid&addvalue=$add");
		exit;
	}

     
	//atleast one shld be entered
    if(empty($click) and empty($lead) and empty($sale))
	{
		$groupname                =trim(stripslashes($_POST['txtgroupname']));
		$msg=$lnewgrp_error6	;
		header("Location:index.php?Act=add_group&click=$click&lead=$lead&sale=$sale&saletype=$saletype&Err=$msg&groupname=$groupname&id=$groupid&addvalue=$add");
		exit;
	}
			
	if(empty($click))  $click = 0;
	if(empty($lead))  $lead = 0;
	if(empty($sale))  $sale = 0;		
      if((!is_numeric($click)) or (!is_numeric($lead))  or (!is_numeric($sale)))
             {
                    $groupname                =trim(stripslashes($_POST['txtgroupname']));
                   $msg=$lnewgrp_error2;
                    header("Location:index.php?Act=add_group&click=$click&lead=$lead&sale=$sale&saletype=$saletype&Err=$msg&groupname=$groupname&programs=$programs&id=$groupid");
                                exit;

             }

 $groupname                =trim(addslashes($_POST['txtgroupname']));


  switch($add)
  {
        case 'Add Group':
             $sql="select * from partners_group where group_programid=$programs and group_name ='$groupname' ";
             $ret=mysqli_query($con,$sql);
              // echo $sql;
                   if (mysqli_num_rows($ret)>0)

                       {
                                         $groupname                =trim(stripslashes($_POST['txtgroupname']));
                                         $msg=$lnewgrp_error3;
                                         header("Location:index.php?Act=add_group&click=$click&lead=$lead&sale=$sale&saletype=$saletype&Err=$msg&groupname=$groupname&programs=$programs");
                                                  exit;
                       }

            if($currValue != $default_currency_caption)   {
               $click = getDefaultCurrencyValue($pgmDate, $currValue, $click)  ;
               $lead  = getDefaultCurrencyValue($pgmDate, $currValue, $lead)  ;
               if($saletype != "%") $sale =  getDefaultCurrencyValue($pgmDate, $currValue, $sale)  ;
            }

           $sql="insert into partners_group(group_programid,group_merchantid,group_name,group_clickrate,group_leadrate,group_salerate,group_saletype, group_date) values('$programs','$MERCHANTID','".addslashes($groupname)."','".addslashes($click)."','".addslashes($lead)."','".addslashes($sale)."','".addslashes($saletype)."','$pgmDate') ";
            mysqli_query($con,$sql);
          //echo $sql;
           $groupname                =trim(stripslashes($_POST['txtgroupname']));
           $msg=$lnewgrp_error4;
           break;
        case 'Edit Group':
            if($currValue != $default_currency_caption)   {
               $click = getDefaultCurrencyValue($pgmDate, $currValue, $click)  ;
               $lead  = getDefaultCurrencyValue($pgmDate, $currValue, $lead)  ;
               if($saletype != "%") $sale =  getDefaultCurrencyValue($pgmDate, $currValue, $sale)  ;
          }


            $sql="update partners_group set group_name='".addslashes($groupname)."',group_clickrate='".addslashes($click)."',group_leadrate='".addslashes($lead)."',group_salerate='".addslashes($sale)."',group_saletype='".addslashes($saletype)."',group_date = '$pgmDate' where group_id='$groupid' ";
            mysqli_query($con,$sql);
         // echo $sql;
           $groupname                =trim(stripslashes($_POST['txtgroupname']));
           $msg=$lnewgrp_error5;
           break;
         }
        header("Location:index.php?Act=add_group&programs=$programs&Err=$msg");
                                exit;
      }
    else
   header("Location:index.php?Act=add_group&programs=$programs");
                                exit;
?>