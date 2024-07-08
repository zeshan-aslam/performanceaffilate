<?php

	include_once 'payments.php';
	
	$status			=	trim($_GET['status']);    		//affilaite status(for search)
	$page			=	intval(trim($_GET['page']));    // page no
	$affid			=	intval(trim($_GET['affid']));   // affid
	$loginflag		=	trim($_GET['loginflag']); 		//'a' diffeerntiate merchant in login table
	$mode			=	trim($_GET['mode']);      		// for view profile and change password ,reject,remove merchant
	$sortby  		=	$_GET['sortby'];          		// Request for Sorting ADDED BY PRAMOD
	$mode			=   trim($_GET['mode']);
	$id				=   intval($_GET['id']);

	if($mode=="edit"){
		if($id) {
			$edtsql = "UPDATE partners_merchant SET merchant_status='approved' WHERE merchant_id = '$id' ";
			mysqli_query($con,$edtsql);
		}
	}

	if(empty($status))
		$status	= $_SESSION['SESSIONSTATUS'];      //setting for status
	else
		$_SESSION['SESSIONSTATUS']=$status;
	if(empty($page))                               //getting page no
		$page	= $partners->getpage();
	
  if ($_GET['mode']=='ViewProfile' || $_GET['mode']=='ChangePassword' || $_GET['mode']=='Reject' || $_GET['mode']=='Remove')
        {
        if ($_GET['mode']=='ViewProfile')
        {
                $pageurl="viewprofile_merchant.php?";                ///view profile
                $h="400";
                $w="450";
        }
        else if($_GET['mode']=='Remove' || $_GET['mode']=='Reject')  ///remove ,reject
     	{
                $pageurl="remove_merchant.php?&loginflag=$loginflag&mode=$mode";
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

  $sql   =  "SELECT *,Date_format(merchant_date,'%d-%b-%Y') d from partners_merchant where merchant_status like ('waiting')";
  $pgsql =  $sql;
  $sql  .=  "LIMIT ".($page-1)*$lines.",".$lines; //adding page no
  $ret   =  mysqli_query($con,$sql);

  if(mysqli_num_rows($ret)){

?>
<br/>
    <table border='0' cellpadding="0" cellspacing="0" width="80%" class="tablebdr">
        <tr>
        <td width="5%" class="tdhead" align="middle" colspan="2" ><b>Status</b></td>
        <td width="25%" class="tdhead" align="middle"><b>merchant</b></td>
        <td width="15%" class="tdhead" align="middle"><b>Registered</b></td>
        <td width="15%" class="tdhead" align="middle"><b>Action</b></td>
        <td width="10%" class="tdhead" align="middle"><b>Notes</b></td>
        </tr>
<?
     while($row=mysqli_fetch_object($ret)){
		$merchant_id = 	$row->merchant_id;
		$status1		=	$row->merchant_status;
		$name         =	stripslashes($row->merchant_company);
		$regdate 		=	$row->d;
?>
        <tr>
			<td width="2%" height="25" align="middle"  > </td>
			<td width="2%" height="25" align="middle"  >
				<IMG alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif">
			</td>
			<td width="25%" height="25" align="middle"><a href="#" onclick="viewLink(<?=$row->merchant_id?>)"><?=$name?></a></td>
			<td width="15%" height="25" align="middle"><?=$regdate?></td>
			<td width="15%" height="25" align="middle" >
				<a href="index.php?Act=waiting_merchants&mode=edit&id=<?=$row->merchant_id?>">Approve</a>
			</td>
			<td width="10%" height="25" align="middle"><a href="test1.php?aid=<?=$row->merchant_id?>">Log In</a></td>
        </tr>
<?php
    }
?>
      <tr>
      <td width="100%" colspan="6" align="center">
        <?
                $url    ="index.php?Act=waiting_merchants";    //adding page nos
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
       <td align="center" class="textred">Sorry, no waiting merchant(s) found  </td>
    </tr>
   </table>
 <?
 } /**********************************************************/
 ?>

     <script language="javascript" type="text/javascript">
           function viewLink(merchantid)
                {
                   url="viewprofile_merchant.php?&id="+merchantid;
                   nw = open(url,'new','height=450,width=450,scrollbars=yes');
                   nw.focus();
                }
    </SCRIPT>