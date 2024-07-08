<?php
/*
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);
*/
	include_once 'payments.php';
	$userobj 		= new adminuser();
	$adminUserId 	= $_SESSION['ADMINUSERID'];
	
	$page			= intval(trim($_GET['page'])); 
	$status			= trim($_GET['status']);
	$merid          = intval(trim($_GET['merid']));
	$loginflag      = trim($_GET['loginflag']); 
	$mode           = trim($_GET['mode']); 
	$sortby			= trim($_GET['sortby']);
	
	$affiliateorder = trim($_GET['affiliateorder']);
	$regdateorder   = $_GET['regdateorder'];
	$aprovedorder   = $_GET['aprovedorder'];
	$pendingorder   = $_GET['pendingorder'];
	$paidorder      = $_GET['paidorder'];
	
	/************************ CODE ADDED BY PRAMOD  4 sorting ******************************/
	
	$sortingtable   =   $_SESSION['MER_SORTINGTABLE'];
	
	if($sortingtable==""){

		$sql	= " CREATE TABLE admin_mer_heap (
					heap_id BIGINT NOT NULL , 
					merchant_id BIGINT NOT NULL ,
					merchant_status VARCHAR( 250 ) NOT NULL ,
					heap_name VARCHAR( 250 ) NOT NULL ,
					heap_approved VARCHAR( 250 ) NOT NULL ,
					heap_regdate DATE NOT NULL ,
					heap_pending BIGINT NOT NULL ,
					heap_paid BIGINT NOT NULL ,
					heap_pgmapproval VARCHAR( 250 ) NOT NULL,
					heap_isInvoice VARCHAR( 250 ) NOT NULL,
					heap_invoiceStatus VARCHAR( 250 ) NOT NULL,
					PRIMARY KEY ( heap_id )
					) TYPE = HEAP ";
		
		mysqli_query($con, $sql);
		$_SESSION['MER_SORTINGTABLE'] ="existing";
	}
	if($sortby=="")
	{
		$sql                ="DELETE FROM admin_mer_heap ";
		mysqli_query($con, $sql);
	}

	/**************************  PRAMOD'S CODED ENDS HERE **************************/
	
	
	/*****************initial settings*******************************************/
	if(empty($status))                          //setting status
		$status=$_SESSION['SESSIONSTATUS'];
	else
		$_SESSION['SESSIONSTATUS']=$status;
		if(empty($page))                          //getting page no
		$page        =$partners->getpage();
	/*****************************************************************************/

	/******************view profile ,remove,reject,change password**************/
	if ($_GET['mode']=='ViewProfile' || $_GET['mode']=='ChangePassword' || $_GET['mode']=='Remove' || $_GET['mode']=='Reject')
	{
		if ($_GET['mode']=='ViewProfile')
		{
			$pageurl="viewprofile_merchant.php?";
			$h="400";
			$w="450";
		}
		else if($_GET['mode']=='Remove'|| $_GET['mode']=='Reject')
		{
			$pageurl="remove_merchant.php?loginflag=$loginflag&mode=$mode";
			$h="400";
			$w="450";
		}
		else
		{
			$pageurl="change_pass.php?&loginflag=$loginflag";
			$h="400";
			$w="450";
		}
		?>
		
		<script language="javascript" type="text/javascript">
			function help()
			{
				nw = open('<?=$pageurl?>&id=<?=$merid?>','new','height=<?=$h?>,width=<?=$w?>,scrollbars=yes');
				//nw.focus();
			}
			function ViewLink()
			{
				nw = open('viewprofile_merchant.php&id=1','new','height=<?=$h?>,width=<?=$w?>,scrollbars=yes');
				//nw.focus();
			}
			help();
		</SCRIPT>
		<?
		
	}  


   	/****************************search based on status*************************/
	switch ($status){
		case  'waiting':
			$sql	= " SELECT *,Date_format(merchant_date,'%d-%b-%Y') d from partners_merchant 
						where merchant_status like ('waiting') ";
			if(!empty($merchantname)){
				$merchantname1	=addslashes($merchantname);
				$sql	.= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') 
							OR merchant_company like('%$merchantname1%')";
			}
		break;
		case 'approved':
			$sql	= " SELECT *,Date_format(merchant_date,'%d-%b-%Y') d from partners_merchant 
						where merchant_status like ('approved') ";
			if(!empty($merchantname)){
				$merchantname1                 =addslashes($merchantname);
				$sql .= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') 
							OR merchant_company like('%$merchantname1%')";
			}
		break;
		case 'empty':
			$sql	= " SELECT *,Date_format(merchant_date,'%d-%b-%Y') d from partners_merchant 
						where merchant_status like ('empty') ";
			if(!empty($merchantname)){
			$merchantname1	= addslashes($merchantname);
			$sql	.= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') 
						OR merchant_company like('%$merchantname1%')";
			}
		break;
		case 'pending':
			$sql	= " SELECT  DISTINCT ( a.merchant_id ), a.merchant_firstname, a.merchant_lastname, 
						a.merchant_company,a.merchant_status, a.merchant_date, 
						Date_format(merchant_date,'%d-%b-%Y') d, a.merchant_pgmapproval " ;
			$sql	= $sql." FROM partners_merchant a, partners_joinpgm c, partners_transaction d";
			$sql	= $sql." WHERE d.transaction_status =  'pending' AND d.transaction_joinpgmid = c.joinpgm_id 
					AND  c.joinpgm_merchantid = a.merchant_id " ;
			if(!empty($merchantname)){
				$merchantname1	= addslashes($merchantname);
				$sql	.= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') 
							OR merchant_company like('%$merchantname1%')";
			}
		
		break;
		case 'suspend':
			$sql	= " SELECT *,Date_format(merchant_date,'%d-%b-%Y') d from partners_merchant 
						where merchant_status like ('suspend') ";
			if(!empty($merchantname)){
			$merchantname1	= addslashes($merchantname);
			$sql  .= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') 
						OR merchant_company like('%$merchantname1%')";
			}
		break;
		
		case 'notpaid':
			$sql	= " SELECT *,Date_format(merchant_date,'%d-%b-%Y') d from partners_merchant 
						where merchant_status like ('NP') ";
			if(!empty($merchantname)){
			$merchantname1                 =addslashes($merchantname);
			$sql	.= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') 
						OR merchant_company like('%$merchantname1%')";
			}
		break;
		case 'all':
		default :
		
			$sql	= " SELECT *,Date_format(merchant_date,'%d-%b-%Y') d from partners_merchant ";
			if(!empty($merchantname)){
				$merchantname1  = addslashes($merchantname);
				$sql 	.= " where CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') 
							OR merchant_company like('%$merchantname1%')";
			}
			
		break;
		
	}
  /****************************************************************************/

  $pgsql = $sql;
  $sql  .= "LIMIT ".($page-1)*$lines.",".$lines;
  $ret        =mysqli_query($con ,$sql);

	if(mysqli_num_rows($ret)){
		switch ($sortby) {
			case 'affiliate':
				$dateesort			="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$pendingsort        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$paidsort           ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$approvedsort       ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				
				if($affiliateorder=="asc"){
					$affiliatesort  = "<img src='../images/up.gif' width='10' height='10' alt='' border='0' />";
					$affiliateorder="desc";
				}
				else{
					$affiliatesort      = "<img src='../images/dawn.gif' width='10' height='10' alt='' border='0' />";
					$affiliateorder="asc";
				}
			break;
		
			case 'regdate':
			
				$affiliatesort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$pendingsort        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$paidsort           ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$approvedsort       ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				if($regdateorder=="asc")
				{
					$regdateorder	="desc";
					$dateesort   	="<img src='../images/up.gif' width='10' height='10' alt='' border='0' />";
				}
				else
				{
					$regdateorder	="asc";
					$dateesort      ="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0' />";
				}
			break;
		
			case 'aproved':
			
				$affiliatesort        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$dateesort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$pendingsort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$paidsort                        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				
				if($aprovedorder=="asc")
				{
					$aprovedorder="desc";
					$approvedsort                ="<img src='../images/up.gif' width='10' height='10' alt='' border='0' />";
				}
				else
				{
					$aprovedorder="asc";
					$approvedsort                ="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0' />";
				}
			break;
		
			case 'pending':
			
				$affiliatesort        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$dateesort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				// $pendingsort                ="<img src='../images/up.gif' width='10' height='10' alt='' border='0' />";
				$paidsort                        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$approvedsort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				
				if($pendingorder=="asc")
				{
					$pendingsort        ="<img src='../images/up.gif' width='10' height='10' alt='' border='0' />";
					$pendingorder="desc";
				}
				else
				{
					$pendingsort        ="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0' />";
					$pendingorder="asc";
				}
			break;
			
			case 'paid':
				$affiliatesort        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$dateesort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				$pendingsort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				// $paidsort                        ="<img src='../images/up.gif' width='10' height='10' alt='' border='0' />";
				$approvedsort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
				if($paidorder=="asc")
				{
					$paidsort        ="<img src='../images/up.gif' width='10' height='10' alt='' border='0' />";
					$paidorder="desc";
				}
				else
				{
					$paidsort        ="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0' />";
					$paidorder="asc";
				}
			break;
		
			default :
			
			$affiliatesort        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
			$dateesort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
			$pendingsort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
			$paidsort                        ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
			$approvedsort                ="<img src='../images/normal.gif' width='10' height='10' alt='' border='0' />";
		}
	
	/*******************if any records found*******************************/
	?>
	
	<table border='0' cellpadding="0" cellspacing="0" width="95%" class="tablebdr">
	
	<tr class="heading-4">
	<td align="center" colspan="2" >Status</td>
	<td width="19%" align="left"><a href="index.php?Act=merchants&status=<?=$status?>&page=<?=$page?>&sortby=affiliate&affiliateorder=<?=$affiliateorder?>" class="link-01"><?=$affiliatesort?>Merchant</a></td>
	<td width="5%" align="center">CRM</td>
	<td width="13%" align="center">PGM Approval</td>
	<td width="11%" align="center"><a href="index.php?Act=merchants&status=<?=$status?>&page=<?=$page?>&sortby=regdate&regdateorder=<?=$regdateorder?>" class="link-01"><?=$dateesort?>Registered</a></td>
	<td width="10%" align="center"><a href="index.php?Act=merchants&status=<?=$status?>&page=<?=$page?>&sortby=pending&pendingorder=<?=$pendingorder?>" class="link-01"><?=$pendingsort?>Pending</a></td>
	<td width="9%"  align="center"><a href="index.php?Act=merchants&status=<?=$status?>&page=<?=$page?>&sortby=paid&paidorder=<?=$paidorder?>" class="link-01"><?=$paidsort?>Balance</a></td>
	<td width="17%" align="left">Action</td>
	<td width="7%" align="center">Notes</td>
	</tr>
	<tr >
	<td colspan="10" align="center"  valign="top">&nbsp;</td>
	</tr>
	
	<?
	/************************************* adding Soerted records *****************/
	
	$sortby        =$_GET['sortby'];
	
	if($sortby!=""){
	
		switch ($sortby) {
			case 'affiliate':
				//$sql_sort	= " SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d FROM admin_mer_heap 
								//ORDER BY heap_name '$affiliateorder'";
				$sql_sort   ="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
                                FROM admin_mer_heap ORDER BY heap_name ".$affiliateorder;
				$ret		= mysqli_query($con, $sql_sort);
			break;
		
			case 'regdate':
				//$sql_sort 	= " SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d FROM admin_mer_heap 
								//ORDER BY heap_regdate '$regdateorder'";
				$sql_sort   ="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
                                FROM admin_mer_heap ORDER BY heap_regdate ".$regdateorder;
				$ret        = mysqli_query($con, $sql_sort);
			break;
		
			case 'aproved':
				//$sql_sort 	= " SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d FROM admin_mer_heap 
								//ORDER BY heap_approved '$aprovedorder'";
				$sql_sort   ="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
                                FROM admin_mer_heap ORDER BY heap_approved  ".$aprovedorder;
				$ret        = mysqli_query($con, $sql_sort);
			break;
			
			case 'pending':
				//$sql_sort	= " SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d FROM admin_mer_heap 
								//ORDER BY heap_pending '$pendingorder'";
				$sql_sort   ="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
                                FROM admin_mer_heap ORDER BY heap_pending   ".$pendingorder;
				$ret        = mysqli_query($con, $sql_sort);
			break;
		
			case 'paid':
				//$sql_sort 	= " SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d FROM admin_mer_heap 
								//ORDER BY heap_paid '$paidorder'";
				$sql_sort   ="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
                                FROM admin_mer_heap ORDER BY heap_paid  ".$paidorder;
				$ret        = mysqli_query($con, $sql_sort);
				echo mysqli_error();
			break;
		}
	
	while($row=mysqli_fetch_object($ret)){
	
	$merchant_id    = $row->merchant_id;
	$total=GetPaymentDetails($row->merchant_id,1); //getting pending,approved,paid amnts from GetPayments.php
	$total =explode('~',$total);
	$status1=$row->merchant_status;   //for setting picture
	$inVoiceStat	= $row->heap_invoiceStatus;
	$isInVoice	    = $row->heap_isInvoice;
	//-----------------------------------------------//
	
	//geting records from table
	$merchant_sql ="SELECT * FROM   merchant_pay  WHERE pay_merchantid='$row->merchant_id'";
	$merchant_ret =mysqli_query($con, $merchant_sql);
	
	//checking for each records
	if(mysql_num_rows($merchant_ret)>0){
		$merchant_row           = mysqli_fetch_object($merchant_ret);
		$merchant_pay_amount    = $merchant_row->pay_amount;
	}
	
	//-----------------------------------------------//
	$approval     = stripslashes($row->heap_pgmapproval);
	$approved     = $total[0];
	$pending      = $total[1];
	$paid         = $merchant_pay_amount;
	$name         = stripslashes($row->heap_name);
	$approval     = stripslashes($row->heap_pgmapproval);
	$regdate      = $row->d;
	$approved     = $total[0];
	$pending      = $total[1];
	$paid         = $merchant_pay_amount;
	$heap_regdate = $row->heap_regdate;
	
	?>       <tr >
	<td width="5%" height="25" align="center" valign="top"   ><?
	if($total[1]>0)  //checking for pending transactions
	{
	?>
	<img alt=" " border='0' height="24" src="../images/pending.gif" width="24" />
	<?
	}
	?>			</td>
	<td width="4%" height="25" align="center" valign="top"  >
	<img alt="" border='0' height="24" src="../images/<?=$status1?>.gif" width="24" />			</td>
	<td width="19%" height="25" align="left" valign="top"><a href="#" onclick="viewLink(<?=$row->merchant_id?>)"><?=$name?></a></td>
	<td width="5%" height="25" align="center" valign="top"><a href="index.php?Act=crm&merchant_id=<?=$row->merchant_id?>">CRM</a></td>
	<td width="13%" height="25" align="center" valign="top"><?=$approval?></td>
	<td width="11%" height="25" align="center" valign="top"><?=$regdate?></td>
	<td width="10%" height="25" align="center" valign="top"><?=$currSymbol?><?=round($total[1],2)?></td>
	<td width="9%" height="25" align="center" valign="top"><?=$currSymbol?><?=round($merchant_pay_amount,2)?></td>
	<td width="17%" height="25" align="left" ><?
	
	$Approve		= $row->merchant_id."~Approve";
	$Reject			= $row->merchant_id."~Reject";
	$Remove			= $row->merchant_id."~Remove";
	$ChangePassword	= $row->merchant_id."~ChangePassword";
	$ViewProfile	= $row->merchant_id."~ViewProfile";
	$Suspend		= $row->merchant_id."~Suspend";
	$adjust        	= $row->merchant_id."~adjust";
	$payment        = $row->merchant_id."~payment";
	$transaction    = $row->merchant_id."~transaction";
	$pgmapproval    = $row->merchant_id."~pgmapproval"."~".$approval;
	
	?>
	<form name="f<?=$row->merchant_id?>" action="merchant1_actions.php?page=<?=$page?>&sortby=<?=$sortby?>" method="post">
	<select name="selaction" onchange="document.f<?=$row->merchant_id?>.submit()">
	<option value="Select Action">Select Action</option>
	<? if($userobj->GetAdminUserLink('Adjust Money',$adminUserId,1)) { ?> <option value="<?=$adjust?>">Adjust Money</option><? } ?>
	<? if($userobj->GetAdminUserLink('Payment History',$adminUserId,1)) { ?> <option value="<?=$payment?>">Payment History</option><? } ?>
	<? if($userobj->GetAdminUserLink('Transaction',$adminUserId,1)) { ?> <option value="<?=$transaction?>">Transaction </option><? } ?>
	<?  /*************selecting action depending on status****************/
	if(($row->merchant_status=='waiting') || ($row->merchant_status=='NP') || ($row->merchant_status=='empty')  || ($row->merchant_status=='suspend' ))
	{
	?>
	<? if($userobj->GetAdminUserLink('Approve Merchants',$adminUserId,1)) { ?> <option value="<?=$Approve?>">Approve</option><? } ?>
	<?
	}//close if
	//show this option always so that the admin can reject them anytime
	if($row->merchant_status=='waiting')
	{
	?>
	<? if($userobj->GetAdminUserLink('Reject Merchant',$adminUserId,1)) { ?><option value="<?=$Reject?>">Reject</option><? } ?>
	<?
	}//close if
	
	if($row->merchant_status=='suspend')
	{
	?>
	<? if($userobj->GetAdminUserLink('Remove Merchant',$adminUserId,1)) { ?><option value="<?=$Remove?>">Remove</option><? } ?>
	<?
	}
	?>
	<? if($userobj->GetAdminUserLink('Change Password of Merchant',$adminUserId,1)) { ?> <option value="<?=$ChangePassword?>">ChangePassword</option><? } ?>
	<option value="<?=$ViewProfile?>">ViewProfile</option>
	<? if($userobj->GetAdminUserLink('Change PGM Approval',$adminUserId,1)) { ?> <option value="<?=$pgmapproval?>">Change PGM Approval</option><? } ?>
	<?
	if($row->merchant_status=='approved' || $row->merchant_status=='pending' )
	{
	?>
	<? if($userobj->GetAdminUserLink('Suspend Merchant',$adminUserId,1)) { ?> <option value="<?=$Suspend?>">Suspend</option><? } ?>
	<?
	}
	/*************close selecting action depending on status*****/
	?>
	<?
	////////// //////////////////////////////////
	// if($row->heap_isInvoice=="Yes"){
	if($userobj->GetAdminUserLink('Activate/Inactivate Invoice Status',$adminUserId,1)) 
	{ 		 
	if($row->heap_invoiceStatus=="active"){
	$showText = "Inactivate Invoice Status";
	?>
	<option value="<?php echo $row->merchant_id?>~invoiceInactivate"><?php echo $showText?></option>
	<?
	}else{
	$showText = "Activate Invoice Status";
	?>
	<option value="<?php echo $row->merchant_id?>~invoiceActivate"><?php echo $showText?></option>
	<?
	}
	}
	
	//  }
	/////////////////////////////////////////////
	?>
	</select>
	</form></td>
	
	<td width="7%" height="28" align="center"  valign="top">
	<? if($userobj->GetAdminUserLink('Merchant Login',$adminUserId,1)) { ?> <a href="test.php?mid=<?=$row->merchant_id?>">Log In</a><? } ?>		</td>
	
	</tr>
	<?php
	
	}   /*********close adding records*****************************************/
	
	}else
	{
	
	/************************************* Sorted Records Ends Here *************/
	
	
	
	
	
	/*********adding records************************************************/
	
	$heap_count=1;
	
	while($row=mysqli_fetch_object($ret))
	{
	
	$merchant_id        =        $row->merchant_id;
	$total=GetPaymentDetails($row->merchant_id,1); //getting pending,approved,paid amnts from GetPayments.php
	$total =explode('~',$total);
	$status1=$row->merchant_status;   //for setting picture
	//-----------------------------------------------//
	
	//geting records from table
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);	
	$merchant_sql ="SELECT * FROM   merchant_pay  WHERE pay_merchantid=$row->merchant_id";
	$merchant_ret = mysqli_query($con, $merchant_sql);
	
	//checking for each records
	if(mysqli_num_rows($merchant_ret)>0)
	{
	$merchant_row                  =mysqli_fetch_object($merchant_ret);
	$merchant_pay_amount                   =$merchant_row->pay_amount;
	}
	
	//-----------------------------------------------//
	$name         = stripslashes($row->merchant_company);
	$approval		= $row->merchant_pgmapproval;
	$inVoiceStat	= $row->merchant_invoiceStatus;
	$isInVoice	= $row->merchant_isInvoice;
	$regdate                 =$row->d;
	$approved                =$total[0];
	$pending                =$total[1];
	$paid                        =$merchant_pay_amount;
	$heap_regdate        =$row->merchant_date;
	
	$heap_sql                ="INSERT INTO admin_mer_heap ( heap_id ,merchant_id,merchant_status, heap_name , heap_regdate , heap_approved , heap_pending , heap_paid ,heap_pgmapproval,heap_isInvoice,heap_invoiceStatus)
	VALUES ('$heap_count','$merchant_id','$status1', '".addslashes($name)."', '$heap_regdate', '$approved', '$pending', '$paid' ,'$approval','$isInVoice','$inVoiceStat')";
	
	mysqli_query($con, $heap_sql);
	
	$heap_count++;
	
	?>       
	<tr >
	<td width="5%" height="25" align="center"  valign="top"><?
	if($total[1]>0)  //checking for pending transactions
	{
	?>
	<!--<img alt=" " border='0' src="../images/pending.gif" height="<?=$icon_height?>" width="<?=$icon_width?>"/>-->
	<img alt=" " border='0' src="../images/pending.gif" height="24" width="24"/>
	<?
	}
	?>			</td>
	<td width="4%" height="25" align="center" valign="top"  >
	<!--<img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/<?=$status1?>.gif"/>-->
	<img alt="" border='0' height="24" width="24" src="../images/<?=$status1?>.gif"/>			</td>
	<td width="19%" height="25" align="left" valign="top"><a href="#" onclick="viewLink(<?=$row->merchant_id?>)"><?=stripslashes($row->merchant_company)?></a></td>
	<td width="5%" height="25" align="center" valign="top"><a href="index.php?Act=crm&merchant_id=<?=$row->merchant_id?>">CRM</a></td>
	<td width="13%" height="25" align="center" valign="top"><?=$row->merchant_pgmapproval?></td>
	<td width="11%" height="25" align="center" valign="top"><?=$row->d?></td>
	<td width="10%" height="25" align="center" valign="top"><?=$currSymbol?><?=round($total[1],2)?></td>
	<td width="9%" height="25" align="center" valign="top"><?=$currSymbol?><?=round($merchant_pay_amount,2)?></td>
	<td width="17%" height="25" align="left" valign="top" >
	
	<? /* *****setting merid+action selected****** */
	$Approve=$row->merchant_id."~Approve";
	$Reject=$row->merchant_id."~Reject";
	$Remove=$row->merchant_id."~Remove";
	$ChangePassword=$row->merchant_id."~ChangePassword";
	$ViewProfile=$row->merchant_id."~ViewProfile";
	$Suspend      =$row->merchant_id."~Suspend";
	$adjust       =$row->merchant_id."~adjust";
	$payment      =$row->merchant_id."~payment";
	$transaction  =$row->merchant_id."~transaction";
	$pgmapproval   =$row->merchant_id."~pgmapproval"."~".$approval;
	/**close setting merid+action selected*******/
	?>
	
	<form name="f<?=$row->merchant_id?>" action="merchant1_actions.php?page=<?=$page?>&sortby=<?=$sortby?>" method="post">
	<select name="selaction" onchange="document.f<?=$row->merchant_id?>.submit()">
	<option value="Select Action">Select Action</option>
	<? if($userobj->GetAdminUserLink('Adjust Money',$adminUserId,1)) { ?> <option value="<?=$adjust?>">Adjust Money</option><? } ?>
	<? if($userobj->GetAdminUserLink('Payment History',$adminUserId,1)) { ?> <option value="<?=$payment?>">Payment History</option><? } ?>
	<? if($userobj->GetAdminUserLink('Transaction',$adminUserId,1)) { ?> <option value="<?=$transaction?>">Transaction </option><? } ?>
	<?  /*************selecting action depending on status****************/
	if(($row->merchant_status=='waiting') || ($row->merchant_status=='NP') || ($row->merchant_status=='empty')  || ($row->merchant_status=='suspend' ))
	{
	?>
	<? if($userobj->GetAdminUserLink('Approve Merchants',$adminUserId,1)) { ?> <option value="<?=$Approve?>">Approve</option><? } ?>
	<?
	}//close if
	//show this option always so that the admin can reject them anytime
	if($row->merchant_status=='waiting')
	{
	?>
	<? if($userobj->GetAdminUserLink('Reject Merchant',$adminUserId,1)) { ?> <option value="<?=$Reject?>">Reject</option><? } ?>
	<?
	} //close if
	
	if($row->merchant_status=='suspend')
	{
	?>
	<? if($userobj->GetAdminUserLink('Remove Merchant',$adminUserId,1)) { ?> <option value="<?=$Remove?>">Remove</option><? } ?>
	<?
	}
	?>
	<? if($userobj->GetAdminUserLink('Change Password of Merchant',$adminUserId,1)) { ?> <option value="<?=$ChangePassword?>">ChangePassword</option><? } ?>
	<option value="<?=$ViewProfile?>">ViewProfile</option>
	<? if($userobj->GetAdminUserLink('Change PGM Approval',$adminUserId,1)) { ?> <option value="<?=$pgmapproval?>">Change PGM Approval</option><? } ?>
	<?
	if($row->merchant_status=='approved' || $row->merchant_status=='pending' )
	{
	?>
	<? if($userobj->GetAdminUserLink('Suspend Merchant',$adminUserId,1)) { ?> <option value="<?=$Suspend?>">Suspend</option><? } ?>
	<?
	}
	/*************close selecting action depending on status*****/
	?>
	
	<?
	////////// //////////////////////////////////
	
	//  if($row->merchant_isInvoice=="Yes"){
	if($userobj->GetAdminUserLink('Activate/Inactivate Invoice Status',$adminUserId,1)) 
	{ 
	if($row->merchant_invoiceStatus=="active"){
	$showText = "Inactivate Invoice Status";
	?>
	<option value="<?php echo $row->merchant_id?>~invoiceInactivate"><?php echo $showText?></option>
	<?
	}else{
	$showText = "Activate Invoice Status";
	?>
	<option value="<?php echo $row->merchant_id?>~invoiceActivate"><?php echo $showText?></option>
	<?
	}
	}
	
	// }
	/////////////////////////////////////////////
	?>
	</select>
	</form>	</td>
	<td width="7%" height="28" align="center" valign="top">
	<? if($userobj->GetAdminUserLink('Merchant Login',$adminUserId,1)) { ?> <a href="test.php?mid=<?=$row->merchant_id?>">Log In</a><? } ?>		</td>
	</tr>
	<?php
	
	}   /*********close adding records*****************************************/
	} // closing of else
	?>
	
	<tr>
	<td colspan="10" align="center">
	<?
	
	$url    ="index.php?Act=merchants&status=$status&merchant=$merchantname";      //pageno adding
	include '../includes/show_pagenos.php';
	/***********************************************************************/
	
	?>    	</td>
	</tr>
	</table>
	
	<?php
	/*******************close if any records found*******************************/
	}else
  {/*******************if no records found*************************************/
?>
   <table width="100%" align="center">
    <tr>
       <td align="center" class="error"><?=$norec?></td>
    </tr>
   </table>
 <?
 }
 ?>
<br/>
<script language="javascript" type="text/javascript">
	function viewLink(merchantid){
		url	= "viewprofile_merchant.php?id="+merchantid;
		nw 	= open(url,'new','height=450,width=400,scrollbars=yes');
	}
</script>