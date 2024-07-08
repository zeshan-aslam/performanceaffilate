<?php

  include_once 'payments.php';

  $status		=	trim($_GET['status']);    //affilaite status(for search)
  $page			=	intval(trim($_GET['page']));      // page no
  $affid		=	intval(trim($_GET['affid']));     // affid
  $loginflag	=	trim($_GET['loginflag']); //'a' diffeerntiate affiliate in login table
  $mode			=	trim($_GET['mode']);      // for view profile and change password ,reject,remove affiliate
  $sortby  		=	$_GET['sortby'];          // Request for Sorting ADDED BY PRAMOD
  $mode			=   trim($_GET['mode']);
  $id			=   $_GET['id'];

  if($mode=="edit"){
  	 if(intval($id)) {
       $edtsql = "UPDATE partners_affiliate SET affiliate_status='approved' WHERE affiliate_id = '$id' ";
       mysqli_query($con,$edtsql);
     }
  }

  if(empty($status))
        $status=$_SESSION['SESSIONSTATUS'];      //setting for status
  else
        $_SESSION['SESSIONSTATUS']=$status;
  if(empty($page))                               //getting page no
        $page        =$partners->getpage();

  if ($_GET['mode']=='ViewProfile' || $_GET['mode']=='ChangePassword' || $_GET['mode']=='Reject' || $_GET['mode']=='Remove')
        {
        if ($_GET['mode']=='ViewProfile')
		{
			$pageurl	= "viewprofile_affiliate.php?";                ///view profile
			$h			= "400";
			$w			= "450";
		}
        else if($_GET['mode']=='Remove' || $_GET['mode']=='Reject')  ///remove ,reject
		{
			$pageurl="remove_affiliate.php?&loginflag=$loginflag&mode=$mode";
			$h="400";
			$w="450";
		}
        else
		{
			$pageurl="change_pass.php?&loginflag=$loginflag";      //change password
			$h="400";
			$w="450";
		}
 ?>

  <script language="javascript" type="text/javascript">
       help();
       function help()
                {
                nw = open('<?=$pageurl?>&id=<?=$affid?>','new','height=<?=$h?>,width=<?=$w?>,scrollbars=yes');
                nw.focus();
                }
    </SCRIPT>
  <?

   }  ///// if close



  $sql   =  "SELECT *,Date_format(affiliate_date,'%d-%b-%Y') d from partners_affiliate where affiliate_status like ('waiting')";
  $pgsql =  $sql;
  $sql  .=  "LIMIT ".($page-1)*$lines.",".$lines; //adding page no
  $ret   =  mysqli_query($con,$sql);

  if(mysqli_num_rows($ret)){

?>
<br/>
    <table border='0' cellpadding="0" cellspacing="0" width="95%" class="tablebdr">
        <tr>
        <td width="5%" class="tdhead" align="middle" colspan="2" >Status</td>
        <td width="25%" class="tdhead" align="middle">Affiliate</td>
        <td width="15%" class="tdhead" align="middle">Registered</td>
        <td width="15%" class="tdhead" align="middle">Action</td>
        <td width="10%" class="tdhead" align="middle">Notes</td>
        </tr>
<?
	while($row=mysqli_fetch_object($ret)){
		$affiliate_id 	= 	$row->affiliate_id;
		$status1		=	$row->affiliate_status;
		$name         	=	stripslashes($row->affiliate_company);
		$regdate 		=	$row->d;
?>
		<tr>
		<td width="2%" height="25" align="middle"></td>
		<td width="2%" height="25" align="middle">
		<IMG alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/notjoined.gif">
		</td>
		<td width="25%" height="25" align="middle"><a href="#"  onclick="viewLink(<?=$row->affiliate_id?>)"><?=$name?></a></td>
		<td width="15%" height="25" align="middle"><?=$regdate?></td>
		<td width="15%" height="25" align="middle" >
		<a href="index.php?Act=waiting_affiliates&mode=edit&id=<?=$row->affiliate_id?>">Approve</a>
		</td>
		<td width="10%" height="25" align="middle"><a href="test1.php?aid=<?=$row->affiliate_id?>">Log In</a></td>
		</tr>
<?php
    }
?>
      <tr>
      <td width="100%" colspan="9" align="center">
		<?
		$url    ="index.php?Act=waiting_affiliates";    //adding page nos
		include '../includes/show_pagenos.php';
		
		?>
    </td>
    </tr>
  </table>
<?php
/******************************close if records exists************************************************/
 }else
  {/***************no records **********************************/
?>
   <table width="100%" align="center">
    <tr>
       <td align="center" class="textred">Sorry, no waiting affiliate(s) found
       </td>
    </tr>
    <tr>
        <td></td>
    </tr>
   </table>
 <?
 } /**********************************************************/
 ?>
<br />
     <script language="javascript" type="text/javascript">
           function viewLink(affiliateid){
				url="viewprofile_affiliate.php?&id="+affiliateid;
				nw = open(url,'new','height=450,width=450,scrollbars=yes');
				nw.focus();
           }
    </SCRIPT>