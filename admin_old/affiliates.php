<?php	ob_start();

	include_once 'payments.php';
	$userobj 		= new adminuser();
	$adminUserId 	= $_SESSION['ADMINUSERID'];

	$status			= trim($_GET['status']);    
	$page			= intval(trim($_GET['page']));      // page no
	$affid			= intval(trim($_GET['affid']));     // affid
	$loginflag		= trim($_GET['loginflag']); //'a' diffeerntiate affiliate in login table
	$mode			= trim($_GET['mode']);      // for view profile and change password ,reject,remove affiliate
	$sortby  		= $_GET['sortby'];          // Request for Sorting ADDED BY PRAMOD
	
	$affiliateorder	= trim($_GET['affiliateorder']);
	$regdateorder	= $_GET['regdateorder'];
	$aprovedorder	= $_GET['aprovedorder'];
	$pendingorder	= $_GET['pendingorder'];
	$paidorder		= $_GET['paidorder'];

	$sortingtable   =   $_SESSION['SORTINGTABLE'];
	if($sortingtable==""){
		$sql        = " CREATE TABLE admin_affil_heap (
						heap_id BIGINT NOT NULL ,
						affiliate_id BIGINT NOT NULL ,
						affiliate_status VARCHAR( 250 ) NOT NULL ,
						heap_name VARCHAR( 250 ) NOT NULL ,
						heap_regdate DATE NOT NULL ,
						heap_approved BIGINT NOT NULL ,
						heap_pending BIGINT NOT NULL ,
						heap_paid BIGINT NOT NULL ,
						PRIMARY KEY ( heap_id )
						) TYPE = HEAP ";
		
		mysqli_query($con, $sql);
		$_SESSION['SORTINGTABLE'] ="existing";
	}
	if($sortby==""){
		$sql		= " DELETE FROM admin_affil_heap ";
		mysqli_query($con, $sql);
    }

	if(empty($status))
		$status		= $_SESSION['SESSIONSTATUS'];      //setting for status
	else
		$_SESSION['SESSIONSTATUS']=$status;
	if(empty($page))                               //getting page no
		$page		= $partners->getpage();

	# view profile ,remove,reject,change password
  	if ($_GET['mode']=='ViewProfile' || $_GET['mode']=='ChangePassword' || $_GET['mode']=='Reject' || $_GET['mode']=='Remove' || $_GET['mode']=='Approve' || $_GET['mode']=='TierGroup' ){
		$h="400";
		$w="450";
     	if ($_GET['mode']=='ViewProfile'){
			$pageurl	= "viewprofile_affiliate.php?";                ///view profile
        }
        else if($_GET['mode']=='Remove' || $_GET['mode']=='Reject') {
			$pageurl	= "remove_affiliate.php?&loginflag=$loginflag&mode=$mode";
        }
		else if($_GET['mode'] == 'Approve'){
			$pageurl="affiliate_approve.php?page=$page&status=$status&sortby=$sortby";
		}
		else if($_GET['mode'] == 'TierGroup'){
			$pageurl="affiliate_approve.php?mode=TierGroup&page=$page&status=$status&sortby=$sortby";
		}
        else{
			$pageurl	= "change_pass.php?&loginflag=$loginflag";      //change password
        }
 ?>
	<script language="javascript" type="text/javascript">
		help();
		function help(){
			nw 	= open('<?=$pageurl?>&id=<?=$affid?>','new','height=<?=$h?>,width=<?=$w?>,scrollbars=yes');
		}
	</SCRIPT>
  <?
   } 

	# search based on status
	switch ($status){
	
		case 'waiting':        //waiting affiliates
		   $sql 	= " SELECT *,Date_format(affiliate_date,'%d-%b-%Y') d from partners_affiliate 
		   				where affiliate_status like ('waiting')";
		   if(!empty($affiliatename)){
				$affiliatename1		 =addslashes($affiliatename);
				$sql	.= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') 
							OR affiliate_company like('%$affiliatename1%')";
			}
		break;
	
		case 'approve':        //approved affiliates
		   $sql		= " SELECT *,Date_format(affiliate_date,'%d-%b-%Y') d from partners_affiliate 
		   				where affiliate_status like ('approved') ";
		   if(!empty($affiliatename)){
				$affiliatename1		 =addslashes($affiliatename);
				$sql	.= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') 
						OR affiliate_company like('%$affiliatename1%')";
			}
		break;
	
		case 'pending':       //affiliates with pending transactions
		   	$sql	= " SELECT  DISTINCT ( a.affiliate_id ), a.affiliate_firstname, a.affiliate_lastname, a.affiliate_company, a.affiliate_status, a.affiliate_date,Date_format(affiliate_date,'%d-%b-%Y') d  " ;
		   	$sql	= $sql." FROM partners_affiliate a, partners_joinpgm c, partners_transaction e";
		   	$sql	= $sql." WHERE e.transaction_status =  'pending' AND e.transaction_joinpgmid = c.joinpgm_id 
						AND c.joinpgm_affiliateid = a.affiliate_id " ;
		   	if(!empty($affiliatename)){
				$affiliatename1		 =addslashes($affiliatename);
				$sql	.= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') 
							OR affiliate_company like('%$affiliatename1%')";
			}
	  	break;
	
		case 'suspend':       //suspended affiliates
		   	$sql 	= " SELECT *,Date_format(affiliate_date,'%d-%b-%Y') d from partners_affiliate 
		   				where affiliate_status like ('suspend') ";
			if(!empty($affiliatename)){
				$affiliatename1		 =addslashes($affiliatename);
				$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') 
								OR affiliate_company like('%$affiliatename1%')";
			}
		break;
		case 'all'    :        //all affilaites
		default :
			$sql	= " SELECT *,Date_format(affiliate_date,'%d-%b-%Y') d from partners_affiliate ";
			if(!empty($affiliatename)){
				$affiliatename1		 =addslashes($affiliatename);
				$sql   .= " where CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') 
							OR affiliate_company like('%$affiliatename1%')";
			}
		break;
	
	}
  /************************************************************************************************************/

	$pgsql= $sql;
	$sql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
	$ret        =mysqli_query($con, $sql);
	

  /*******************if any records found*******************************/
  if(mysqli_num_rows($ret))
  {
	
	// 4 sorting
      switch ($sortby) 
	  {

          case 'affiliate':
				  $dateesort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				  $pendingsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				  $paidsort			="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				  $approvedsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
		
				  if($affiliateorder=="asc")
				  {
		
				  $affiliatesort	="<img src='../images/up.gif' width='10' height='10' alt='' border='0'  />";
				   $affiliateorder="desc";
				  }
				  else
				  {
				  $affiliatesort	="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0'  />";
					$affiliateorder="asc";
				  }
				break;

          case 'regdate':
				  $affiliatesort	="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
		
				  $pendingsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				  $paidsort			="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				  $approvedsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
		
				 if($regdateorder=="asc")
				  {
				   $regdateorder="desc";
				   $dateesort		="<img src='../images/up.gif' width='10' height='10' alt='' border='0'  />";
				  }
				  else
				  {
					$regdateorder="asc";
					$dateesort		="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0'  />";
				  }
		
		
					break;

          case 'aproved':

				  $affiliatesort	="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				  $dateesort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				  $pendingsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				  $paidsort			="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				 // $approvedsort		="<img src='../images/up.gif' width='10' height='10' alt='' border='0'  />";

				  if($aprovedorder=="asc")
				  {
				   $aprovedorder="desc";
				   $approvedsort		="<img src='../images/up.gif' width='10' height='10' alt='' border='0'  />";
				  }
				  else
				  {
					$aprovedorder="asc";
					$approvedsort		="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0'  />";
				  }
		
				break;

        case 'pending':

				$affiliatesort	="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				$dateesort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				// $pendingsort		="<img src='../images/up.gif' width='10' height='10' alt='' border='0'  />";
				$paidsort			="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				$approvedsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				
				// pendingorder
				
				if($pendingorder=="asc")
				{
				$pendingsort	="<img src='../images/up.gif' width='10' height='10' alt='' border='0'  />";
				$pendingorder="desc";
				}
				else
				{
				$pendingsort	="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0'  />";
				$pendingorder="asc";
				}
				break;

          case 'paid':

				$affiliatesort	="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				$dateesort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				$pendingsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				// $paidsort			="<img src='../images/up.gif' width='10' height='10' alt='' border='0'  />";
				$approvedsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				
				
				if($paidorder=="asc")
				{
				$paidsort	="<img src='../images/up.gif' width='10' height='10' alt='' border='0'  />";
				$paidorder="desc";
				}
				else
				{
				$paidsort	="<img src='../images/dawn.gif' width='10' height='10' alt='' border='0'  />";
				$paidorder="asc";
				}
				break;

          default :
				
				$affiliatesort	="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				$dateesort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				$pendingsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				$paidsort			="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";
				$approvedsort		="<img src='../images/normal.gif' width='10' height='10' alt='' border='0'  />";

        }

?>
<table border='0' cellpadding="0" cellspacing="0" width="95%" class="tablebdr">
	<tr>
	<td class="tdhead" align="center" colspan="2" >Status</td>
	<td width="31%" class="tdhead" align="left">
	<a href="index.php?Act=affiliates&status=<?=$status?>&page=<?=$page?>&sortby=affiliate&affiliateorder=<?=$affiliateorder?>"><?=$affiliatesort?>Affiliate
	</a></td>
	<td width="11%" class="tdhead" align="center"><a href="index.php?Act=affiliates&status=<?=$status?>&page=<?=$page?>&sortby=regdate&regdateorder=<?=$regdateorder?>"><?=$dateesort?>Registered</a></td>

	<td width="9%" class="tdhead" align="center"><a href="index.php?Act=affiliates&status=<?=$status?>&page=<?=$page?>&sortby=pending&pendingorder=<?=$pendingorder?>"><?=$pendingsort?>Pending</a></td>
	<td width="9%" class="tdhead" align="center"><a href="index.php?Act=affiliates&status=<?=$status?>&page=<?=$page?>&sortby=paid&paidorder=<?=$paidorder?>"><?=$paidsort?>Balance</a></td>
	<td width="22%" class="tdhead" align="left">Action</td>
	<td width="6%" class="tdhead" align="center">Notes</td>
	</tr>

   <?
	# IF SORTING REQUEST EXISTS adding sortred records
   	$sortby	=$_GET['sortby'];
    if($sortby!=""){
        switch ($sortby) {

          	case 'affiliate':
					//$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  //FROM admin_affil_heap ORDER BY heap_name '$affiliateorder'";
					$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  FROM admin_affil_heap ORDER BY heap_name ".$affiliateorder;
					$ret			=mysqli_query($con, $sql_sort);
					break;

          	case 'regdate':
					//$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  //FROM admin_affil_heap ORDER BY heap_regdate '$regdateorder'";
					$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  FROM admin_affil_heap ORDER BY heap_regdate ".$regdateorder;
					$ret			=mysqli_query($con, $sql_sort);
					break;

          	case 'aproved':
					//$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  //FROM admin_affil_heap ORDER BY heap_approved  '$aprovedorder'";
					$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  FROM admin_affil_heap ORDER BY heap_approved  ".$aprovedorder;
					$ret		=mysqli_query($con, $sql_sort);
					break;

        	case 'pending':
					//$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  //FROM admin_affil_heap ORDER BY heap_pending  '$pendingorder'";
					$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  FROM admin_affil_heap ORDER BY heap_pending   ".$pendingorder;
					$ret		=mysqli_query($con, $sql_sort);
					break;

          	case 'paid':
					$//sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  //FROM admin_affil_heap ORDER BY heap_paid '$paidorder' ";
					$sql_sort		="SELECT *,Date_format(heap_regdate,'%d-%b-%Y') d
									  FROM admin_affil_heap ORDER BY heap_paid  ".$paidorder;
					$ret		=mysqli_query($con, $sql_sort);
					break;

        }
        
		echo mysqli_error();

        while($row=mysqli_fetch_object($ret))
		{

              $total		=GetPaymentDetails($row->affiliate_id,2);  //getting pending,approved,paid amnts from GetPayments.php
              $total 		=explode('~',$total);
              $status1		=$row->affiliate_status;                 //setting picture

             //geting records from table
	          $affiliate_sql ="SELECT * FROM affiliate_pay WHERE pay_affiliateid='$row->affiliate_id'";
	          $affiliate_ret =mysqli_query($con, $affiliate_sql);

	          //checking for each records
	          if(mysqli_num_rows($affiliate_ret)>0)
	            {
	                  $affiliate_row                  =mysqli_fetch_object($affiliate_ret);
	                  $affiliate_pay_amount    	  =$affiliate_row->pay_amount;
	            }

              //-----------------------------------------------//

              $name         =stripslashes($row->heap_name);
              $regdate 		=$row->d;
              $approved		=$total[0];
              $pending		=$total[1];
              $paid			= $affiliate_pay_amount;
              $heap_regdate	=$row->heap_regdate;

              $heap_count++;
?>
         	<tr>
        		 <td width="6%" height="25" align="center"  >
				 <?
				 	if($total[1]>0) //checking for pending transactions
					{
						?>
						<img alt=" " border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif"	/>
					   <?
					 }
					?>
        		</td>
        		<td width="6%" height="25" align="middle"  ><img alt="" border='0' height="15" src="../images/<?=$status1?>.gif"  width="15" />
         		</td>
				<td width="31%" height="25" align="left"><a href="#"  onclick="viewLink(<?=$row->affiliate_id?>)"><?=$name?></a></td>
				<td width="11%" height="25" align="center"><?=$regdate?></td>
				<td width="9%" height="25" align="center"><?=$currSymbol?><?=round($pending,2)?></td>
				<td width="9%" height="25" align="center"><?=$currSymbol?><?=round($paid,2)?></td>
				<td width="22%" height="25" align="left" ><?

				  /******setting affid+action selected*******/
		
					$Approve		= $row->affiliate_id."~Approve";
					$Reject			= $row->affiliate_id."~Reject";
					$Remove			= $row->affiliate_id."~Remove";
					$ChangePassword	= $row->affiliate_id."~ChangePassword";
					$ViewProfile	= $row->affiliate_id."~ViewProfile";
					$Suspend		= $row->affiliate_id."~Suspend";
					$adjust			= $row->affiliate_id."~adjust";
					$payment		= $row->affiliate_id."~payment";
					$transaction	= $row->affiliate_id."~transaction";
					$TierGroup		= $row->affiliate_id."~TierGroup";
				 /*******************************************/
				?>
				<form name="f<?=$row->affiliate_id?>" action="affiliate_actions.php?page=<?=$page?>&amp;sortby=<?=$sortby?>" method="post">
				<select name="selaction" onchange="document.f<?=$row->affiliate_id?>.submit()">
					<option value="Select Action">Select Action</option>
				<?


        /*************selecting action depending on status****************/

        		if($row->affiliate_status=='waiting' || $row->affiliate_status=='suspend' )
                {
					//Checks if the Admin has permission to access the link
                 	if($userobj->GetAdminUserLink('Approve Affiliate',$adminUserId,2)) { ?> 
					<option value="<?=$Approve?>">Approve</option>
					<? } 
				}//close if
			
				//show this option always so that the admin can reject them anytime
                if($userobj->GetAdminUserLink('Reject Affiliate',$adminUserId,2)) { ?> 
					<option value="<?=$Reject?>">Reject</option>
				<? } 

        		if($row->affiliate_status=='suspend')
                {
                 	if($userobj->GetAdminUserLink('Remove Affiliate',$adminUserId,2)) { ?> 
					<option value="<?=$Remove?>">Remove</option>
					<? } 
                }
                
				if($userobj->GetAdminUserLink('Change Password of Affiliate',$adminUserId,2)) { ?> 
					<option value="<?=$ChangePassword?>">ChangePassword</option>
				<? } ?>
        		
				<option value="<?=$ViewProfile?>">ViewProfile</option>
         		<? if($userobj->GetAdminUserLink('Payment History',$adminUserId,2)) { ?> 
					<option value="<?=$payment?>">Payment History</option>
				<? } 
				
				if($userobj->GetAdminUserLink('Transaction',$adminUserId,2)) { ?> 
					<option value="<?=$transaction?>">Transaction</option>
				<? } 	
		        if($row->affiliate_status=='approved' || $row->affiliate_status=='pending' || $row->affiliate_status=='empty' )
                {
                   if($userobj->GetAdminUserLink('Suspend Affiliate',$adminUserId,2)) { ?> 
				   <option value="<?=$Suspend?>">Suspend</option>
				   <? } 
                }

           		if($userobj->GetAdminUserLink('Adjust Money',$adminUserId,2)) { ?> 
					<option value="<?=$adjust?>">AdjustMoney</option>
				<? }  
				
				if($userobj->GetAdminUserLink('Set Commission Group',$adminUserId,2)) { ?> 
					<option value="<?=$TierGroup?>">Set Commission Group</option>
				<? }  
							
       
			/******************end selecting action********************************/
				
				?>
        	</select>
         	</form> 
			</td>
			<td width="6%" height="25" align="center">
				<?  //Show login option only if the user has permission
				if($userobj->GetAdminUserLink('Affiliate Login',$adminUserId,2)) 
				{ ?> <a href="test1.php?aid=<?=$row->affiliate_id?>">Log In</a><? } ?>
			</td>
			</tr>

	<?php
		}

   }         /***************************************** SORTED DISPLAY ENDS HERE *********************/
   else
   {
    /***************************cl0se adding records***************************/
?>

<?     /*********adding records************************************************/

        $heap_count=1;

        while($row=mysqli_fetch_object($ret))
		{

			$affiliate_id = $row->affiliate_id;
			$total		=GetPaymentDetails($row->affiliate_id,2);  //getting pending,approved,paid amnts from GetPayments.php
			$total 		=explode('~',$total);
			$status1		=$row->affiliate_status;
			
		  	//setting picture
			//-----------------------------------------------//
			
			//geting records from table
			$affiliate_sql ="SELECT * FROM   affiliate_pay  WHERE pay_affiliateid='$row->affiliate_id'";
			$affiliate_ret =mysqli_query($con, $affiliate_sql);
			
			//checking for each records
			if(mysqli_num_rows($affiliate_ret)>0)
			{
				  $affiliate_row                  =mysqli_fetch_object($affiliate_ret);
				  $affiliate_pay_amount 		  =$affiliate_row->pay_amount;
			}
			//-----------------------------------------------//
			
			$name         =stripslashes($row->affiliate_company);
			$regdate 		=$row->d;
			$approved		=$total[0];
			$pending		=$total[1];
			$paid			= $affiliate_pay_amount;
			$heap_regdate	=$row->affiliate_date;
			
			$heap_sql		="INSERT INTO admin_affil_heap ( heap_id ,affiliate_id,affiliate_status, heap_name , heap_regdate , heap_approved , heap_pending , heap_paid )
						  VALUES ('$heap_count','$affiliate_id','$status1','".addslashes($name)."', '$heap_regdate', '$approved', '$pending', '$paid')";
			
			mysqli_query($con, $heap_sql);
			
			$heap_count++;
?>
	 <tr>
		<td width="6%" height="25" align="center"  >
		<?
		if($total[1]>0) //checking for pending transactions
		{
			?>
			<img  alt=" " border='0' height="15" src="../images/pending.gif"  width="15" />
			<?
		}
		?>
		</td>
		<td width="6%" height="25" align="center"  ><img
			alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/<?=$status1?>.gif"
			/>
		 </td>
		<td width="31%" height="25" align="left"><a href="#"  onclick="viewLink(<?=$row->affiliate_id?>)"><?=$name?></a></td>
		<td width="11%" height="25" align="center"><?=$regdate?></td>

		<td width="9%" height="25" align="center"><?=$currSymbol?><?=round($pending,2)?></td>
		<td width="9%" height="25" align="center"><?=$currSymbol?><?=round($paid,2)?></td>
		<td width="22%" height="25" align="left" ><?

          /******setting affid+action selected*******/

				$Approve		= $row->affiliate_id."~Approve";
				$Reject			= $row->affiliate_id."~Reject";
				$Remove			= $row->affiliate_id."~Remove";
				$ChangePassword	= $row->affiliate_id."~ChangePassword";
				$ViewProfile	= $row->affiliate_id."~ViewProfile";
				$Suspend		= $row->affiliate_id."~Suspend";
				$adjust			= $row->affiliate_id."~adjust";
				$payment		= $row->affiliate_id."~payment";
				$transaction	= $row->affiliate_id."~transaction";
				$TierGroup		= $row->affiliate_id."~TierGroup";
        /*******************************************/
        ?>
        <form name="f<?=$row->affiliate_id?>" action="affiliate_actions.php?page=<?=$page?>&amp;sortby=<?=$sortby?>" method="post">
        <select name="selaction" onchange="document.f<?=$row->affiliate_id?>.submit()">
        	<option value="Select Action">Select Action</option>

        <?
        /*************selecting action depending on status****************/

        	if($row->affiliate_status=='waiting' || $row->affiliate_status=='suspend' )
            {
                if($userobj->GetAdminUserLink('Approve Affiliate',$adminUserId,2)) { ?> 
				<option value="<?=$Approve?>">Approve</option>
				<? } 
            }//close if
        
			//show this option always so that the admin can reject them anytime
			if($userobj->GetAdminUserLink('Reject Affiliate',$adminUserId,2)) { ?> 
				<option value="<?=$Reject?>">Reject</option>
			<? }

        	if($row->affiliate_status=='suspend')
            {
                if($userobj->GetAdminUserLink('Suspend Affiliate',$adminUserId,2)) { ?> 
				<option value="<?=$Remove?>">Remove</option>
				<? } 
            }
            
			if($userobj->GetAdminUserLink('Change Password of Affiliate',$adminUserId,2)) { ?> 
				<option value="<?=$ChangePassword?>">ChangePassword</option>
			<? } ?>
        
			<option value="<?=$ViewProfile?>">ViewProfile</option>
         
		 	<? if($userobj->GetAdminUserLink('Payment History',$adminUserId,2)) { ?> 
				<option value="<?=$payment?>">Payment History</option>
			<? } 
			
			if($userobj->GetAdminUserLink('Transaction',$adminUserId,2)) { ?> 
				<option value="<?=$transaction?>">Transaction</option>
			<? } 
			
         	if($row->affiliate_status=='approved' || $row->affiliate_status=='pending' || $row->affiliate_status=='empty' )
            {
                  if($userobj->GetAdminUserLink('Suspend Affiliate',$adminUserId,2)) { ?> 
				  <option value="<?=$Suspend?>">Suspend</option>
				  <? } 
            }

         	if($userobj->GetAdminUserLink('Adjust Money',$adminUserId,2)) { ?> 
				<option value="<?=$adjust?>">AdjustMoney</option>
			<? }  
				
			if($userobj->GetAdminUserLink('Set Commission Group',$adminUserId,2)) { ?> 
				<option value="<?=$TierGroup?>">Set Commission Group</option>
			<? }  
		/******************end selecting action********************************/
			
			?>
        	</select>
          </form> 
		</td>
        <td width="6%" height="25" align="center">
			<? if($userobj->GetAdminUserLink('Affiliate Login',$adminUserId,2)) { ?> 
				<a href="test1.php?aid=<?=$row->affiliate_id?>">Log In</a>
			<? } ?>
		</td>
        </tr>

<?php
    }

  } // closing of sort else ADDED BY PRAMOD
    /***************************cl0se adding records***************************/
?>

      <tr>
     	 <td colspan="9" align="center">
             <?

             /**********************************for pageno***************************/
                $url    ="index.php?Act=affiliates&amp;status=$status&affiliate=$affiliatename";    //adding page nos
                include '../includes/show_pagenos.php';

              /********************************************************************************/
    ?>
    </td>
    </tr>
</table>
<?php
/******************************close if records exists************************************************/
}else{
?>
   <table width="100%" align="center">
    <tr>
       <td align="center" class="error"><?=$norec?>
       </td>
    </tr>
    <tr>
        <td></td>
    </tr>
   </table>
 <?
 }
 ?>
<br />
	<script language="javascript" type="text/javascript">
		function viewLink(affiliateid)
		{
			url="viewprofile_affiliate.php?id="+affiliateid;
			nw = open(url,'new','height=450,width=450,scrollbars=yes');
			//nw.focus();
		}
	</script>