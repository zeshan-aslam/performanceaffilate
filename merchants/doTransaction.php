<?php

function   doPayment($mid,$transid,$minimum_amount)
{

	$con = $GLOBALS["con"];

     $sql_trns ="select * from partners_transaction,partners_joinpgm where transaction_id='$transid' and joinpgm_id=transaction_joinpgmid";
     $ret_trns =mysqli_query($con,$sql_trns);

     //checking for each records
     if(mysqli_num_rows($ret_trns)>0)
     {
             $row_trns		=mysqli_fetch_object($ret_trns);
             $amount        =$row_trns->transaction_amttobepaid ;
             #$subsale       =$row_trns->transaction_subsale;
             $parentid      =$row_trns->transaction_parentid;
             $admin_amount  =$row_trns->transaction_admin_amount;
             $flag			=$row_trns->transaction_flag;
             $aid			=$row_trns->joinpgm_affiliateid;
     }


	//----------------------------------------  get merchant account   --------------------------------------//

			$sql        ="SELECT *  FROM `merchant_pay`  WHERE pay_merchantid='$mid' ";
			$res        =mysqli_query($con,$sql);
			
			$num	  = mysqli_num_rows($res);
			$cut_off  =	$minimum_amount;
			if($num>0)
			{
				$row1   			=   mysqli_fetch_object($res);
				$merchant_balance   = $row1->pay_amount;
				
				if(($merchant_balance-($amount+$admin_amount) )<=$cut_off)
				{
					return(0);
				}
				else
				{

					//---------------------------------------- Adding money to affiliate account  --------------------------//
						$sql1       ="SELECT *  FROM `affiliate_pay` where pay_affiliateid='$aid' ";
						$res1       =mysqli_query($con,$sql1);
					
						 $num=mysqli_num_rows($res1);
						 if($num>0)
						 {
							$row1	=	mysqli_fetch_object($res1);
							$curamount	= $row1->pay_amount;
							$curamount	= $curamount+$amount;
							$sql2 ="update affiliate_pay set pay_amount='$curamount' where pay_affiliateid='$aid'";
							$ret2 =mysqli_query($con,$sql2);
						 }
						 else
						 {
							$sql2 ="INSERT INTO  affiliate_pay set pay_affiliateid='$aid' , pay_amount='$amount'";
							$ret2 =mysqli_query($con,$sql2);
						 }
					//----------------------------------- affiliate account editing Ends here--------------------------//
					


    			//---------------------------------- Subtract Money From Merchant Account ---------------------------//
						$merchant_balance = $merchant_balance-($amount+$admin_amount);
						$sql        ="UPDATE  `merchant_pay` SET  pay_amount='$merchant_balance'  WHERE pay_merchantid='$mid' ";
						$res        =mysqli_query($con,$sql);
						$_SESSION['MERCHANTBALANCE'] = $merchant_balance;
    			//--------------------------------- END OF  Subtract Money From Merchant Account ---------------------------//



    			//-------------- # Provide Tier commission to the x number of parents--------------------//
						if($flag==1)
						{
							$adminTierCommission = 0;
							# Provide Tier commission to the x number of parents
							$baseAffiliateId	= $aid;
							
							# getting Tier Commissions group of the Affiliate
							$sql_aff = "select affiliate_group from partners_affiliate where affiliate_id='$aid' ";
							$ret_aff = mysqli_query($con,$sql_aff);
							list($tierGroupId)	 = mysqli_fetch_row($ret_aff);
							
							# Gets the details of the commission to be provided to this level of parent
							$sql_get = "SELECT * FROM partners_affiliategroup_commission 
								WHERE commission_groupid='$tierGroupId' ORDER BY commission_level ";
							$res_get = mysqli_query($con,$sql_get);
							if(mysqli_num_rows($res_get) > 0)
							{
								while($row_get = mysqli_fetch_object($res_get))
								{
									$tierParentId 	= 0;
									$tierCommAmt	= $row_get->commission_amount;
									$tierCommType	= $row_get->commission_type;
									$tierLevel		= $row_get->commission_level;
									
									# Calculates the tier commission to be provided
									if($tierCommType == "%")
										$tierCommAmt = $sale*($tierCommAmt)/100;
									
									$sql_parent = "SELECT affiliate_parentid FROM partners_affiliate 
										WHERE affiliate_id='$baseAffiliateId' ";
									$res_parent = mysqli_query($con,$sql_parent);
									list($tierParentId) = mysqli_fetch_row($res_parent);
										
									if($tierParentId > 0)	 
									{
										# Adds the commission details provided to table
										$sql_trans_subsale = "INSERT INTO partners_transaction_subsale SET 
											subsale_transactionid = '$transid', subsale_date='".date("Y-m-d")."', 
											subsale_affiliateid = '$tierParentId', subsale_childaffiliateid = '$baseAffiliateId', 
											subsale_level = '$tierLevel', subsale_amount = '$tierCommAmt' ";
										$res_trans_subsale = mysqli_query($con,$sql_trans_subsale);
										
										# Updates the account balance of the parent
										$sql_pay	= "SELECT *  FROM `affiliate_pay` where pay_affiliateid='$tierParentId' ";
										$res_pay 	= mysqli_query($con,$sql_pay);
										
										if(mysqli_num_rows($res_pay)) {
										   $row_pay    = mysqli_fetch_object($res_pay);
										   $curamount  = $row_pay->pay_amount;
										   $curamount  = $curamount + $tierCommAmt;
										   $sql_pay2 ="UPDATE affiliate_pay SET pay_amount='$curamount' 
										   		WHERE  pay_affiliateid='$tierParentId' ";
										   $res_pay2 =mysqli_query($con,$sql_pay2);
										}
										
										$adminTierCommission = $adminTierCommission + $tierCommAmt; 
										$baseAffiliateId	= $tierParentId;	
									}
									else {
										break;
									}
								}
							}

							/*$sql1       ="SELECT *  FROM `affiliate_pay` where pay_affiliateid=$parentid ";
							$res1       =mysqli_query($con,$sql1);
							echo mysqli_error($con);
							
							$num=mysqli_num_rows($res1);
							if($num>0)
							{
								$row1	=	mysqli_fetch_object($res1);
								$curamount	= $row1->pay_amount;
								$curamount	= $curamount+$subsale;
								$sql2 ="update affiliate_pay set pay_amount='$curamount' where pay_affiliateid=$parentid";
								$ret2 =mysqli_query($con,$sql2);
							}*/
						}

    			//--------------------------------- Adding To Admins Account-----------------------------------------//
                                 $sql1		="SELECT *  FROM `admin_pay`  ";
                                 $res1		=mysqli_query($con,$sql1);
                                 echo mysqli_error($con);
                                 $num=mysqli_num_rows($res1);
                                 if($num>0)
                                 {
                                    $row1	=	mysqli_fetch_object($res1);
                                  	$admin_curamount	= $row1->pay_amount;
                                    #$admin_curamount	= ($admin_curamount+$admin_amount)-$subsale;
									$admin_curamount	= ($admin_curamount+$admin_amount)-$adminTierCommission;
                                 }

                                $sql		="UPDATE `admin_pay` SET `pay_amount` = '$admin_curamount'";
                                $res		=mysqli_query($con,$sql);
    			 //--------------------------------- END OF Adding to admin's account -------------------------------//
                             }
                         }
      return(1);}
?>