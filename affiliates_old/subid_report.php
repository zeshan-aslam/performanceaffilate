<?php
	# get sub id after submission
	$subid     = $_POST['cbo_subid'];
	
	include_once '../includes/functions.php';		
	include("../includes/function1.php");
	$imp_obj 	= new impression();
?>

<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<br/>
	<form name="trans" method="post" action="">
	<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center" >
		<tr>
			<td  height="19" class="tdhead" colspan="2" align="center" ><b><?=$lang_subid_title?></b></td>
		</tr>
		<tr>
			<td  height="19" colspan="2" >&nbsp;&nbsp;&nbsp;<b><?=$lang_subid_forperiod?></b></td>
		</tr>
		<tr>
			<td width="49%" height="24" align="center">&nbsp; <?=$lang_subid_from?></td>
			<td width="49%" height="24" align="left">
			<input type="text" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" /></td>
		</tr>
	<tr>
	<td width="49%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_subid_to?></td>
	<td width="49%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$txtto?>" onfocus="javascript:to_date();return false;" /></td>
	</tr>
	<tr>
		<td height="23" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td height="20" colspan="2" align="center"><b><?=$lang_subid_searchsubid?></b></td>
	</tr>
	<tr>
	<td height="13" colspan="2">&nbsp;</td>
	</tr>
	<tr>
	<td height="25" colspan="2" align="center" >
	<select name="cbo_subid" ><option value="All" ><?=$lang_subid_allsubid?></option>
	<?php
	//list all sub ids of this affiliate
	$sql = "SELECT * FROM partners_sub_id WHERE sub_affiliateid = '".$_SESSION[AFFILIATEID]."' ";
	$res = mysqli_query($con,$sql);
	while($row = mysqli_fetch_object($res))
	{
	$selected = "";
	if($subid == $row->sub_subid) $selected = "selected = 'selected'";
	?>
	<option value="<?=$row->sub_subid?>" <?=$selected?>><?=$row->sub_subid?></option>
	<?php
	}
	?>
	</select>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center" height="26">
	<input type="submit" name="sub" value="<?=$lang_report_view?>" /></td>
	</tr>
	</table>
	</form>

<?php
        //if after submission
        if(!empty($subid))
        {
                //get period
                $fromdate        = $_POST['txtfrom'];
                $todate                = $_POST['txtto'];

                //create heading
                if(!empty($fromdate) and !empty($todate)) $heading        = $fromdate." - ".$todate;
                else
                {
                        if(empty($fromdate) and !empty($todate)) $heading = $lang_subid_till." ".$todate;
                        if(empty($todate) and !empty($fromdate)) $heading = $lang_subid_from." ".$fromdate;
                }

                //convert to mysql format
                if(!empty($fromdate)) $fromdate        =        $partners->date2mysql($fromdate);
        if(!empty($todate)) $todate            =        $partners->date2mysql($todate);

                //if all sub ids
                if($subid=="All")
                {
                        //get list of all subids
                        $sql = "SELECT * FROM partners_sub_id WHERE sub_affiliateid = '".$_SESSION[AFFILIATEID]."' ";
                        $res = mysqli_query($con,$sql);
                        while($row = mysqli_fetch_object($res)) $subidlist .= $row->sub_subid.",";
                        $subidlist = trim($subidlist,",");
                }
                else $subidlist = $subid;

                //get list of programs for which the affiliate has joined
                $sql = "SELECT joinpgm_id FROM partners_joinpgm WHERE joinpgm_affiliateid = '".$_SESSION[AFFILIATEID]."' ";
                $res = mysqli_query($con,$sql);
                while($row = mysqli_fetch_object($res)) $programidlist .= $row->joinpgm_id.",";
                $programidlist = trim($programidlist,",");
?>

                 <table border="0"  cellpadding="0" cellspacing="0" width="60%" class="tablebdr" align="center">
                 <tr>
					<td height="25" width="100%" align="center" class="tdhead" >
					<b><?=$lang_subid_report?><br/><?=$heading?></b></td>
                 </tr>
                 <tr>
                         <td height="4"></td>
                 </tr>
<?php
                //if no sub ids
                if(empty($subidlist))
                {
?>
                 <tr>
                         <td height="4" align="center" class="textred"><?=$lang_subid_noreport_msg?></td>
                 </tr>
<?php
                }
                else
                {

                        //get sub ids one by one
                        $subid_arr = explode(",",$subidlist);
                        for($i=0;$i<count($subid_arr);$i++)
                        {
                                $subid = $subid_arr[$i];

                                 //modified 23-Feb-06
								$impsql = "SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE  imp_affiliateid='$AFFILIATEID' AND imp_subid = '$subid' ";
								$impsql .= " and imp_date between '".$fromdate."' and '".$todate."'";
                                $impRes = mysqli_query($con,$impsql);   
								$row_impr = mysqli_fetch_object($impRes);
								$impression_count = $row_impr->impr_count ;
								if($impression_count == '') $impression_count = 0;
								
                                 //End modify

                                //common where conditions
                                $sql_where = " AND trans_affiliateid = '".$_SESSION[AFFILIATEID]."' ";
                                //if date range is specified
                                if(!empty($fromdate)) $sql_where .= " AND trans_date >= '".$fromdate."'";
                                if(!empty($todate)) $sql_where .= " AND trans_date <= '".$todate."'";
                                $sql_where .= " AND trans_subid = '$subid'";

                                //get no. of raw clicks
								$sql = "SELECT COUNT(transdaily_click) AS count1 FROM partners_rawtrans_daily WHERE 1 ";
								//$sql1 .= " AND trans_subid = '$subid'";
								$sql_raw = " AND transdaily_affiliateid  = '".$_SESSION[AFFILIATEID]."' ";
								if(!empty($fromdate)) $sql_raw .= " AND transdaily_date >= '".$fromdate."'";
                                if(!empty($todate)) $sql_raw .= " AND transdaily_date <= '".$todate."'";  
								$sql1 = $sql.$sql_raw;
								
                                $res = mysqli_query($con,$sql1);
                                $rawclicks = 0;
                                if($row = mysqli_fetch_object($res)) $rawclicks = $row->count1;

                                //get no of impressions
								$sqlimp = "SELECT COUNT(transdaily_impression) AS countimp FROM partners_rawtrans_daily WHERE 1 ";
								$sql2 = $sqlimp.$sql_raw;
                                $res = mysqli_query($con,$sql2);
                                $impressions = 0;
                                if($row = mysqli_fetch_object($res)) $impressions = $row->countimp;

                                //common where condition for
                                $sql_where = " AND transaction_joinpgmid IN ($programidlist) ";
                                //if date range is specified
                                if(!empty($fromdate)) $sql_where .= " AND transaction_dateoftransaction >= '".$fromdate."'";
                                if(!empty($todate)) $sql_where .= " AND transaction_dateoftransaction <= '".$todate."'";
                                $sql_where .= " AND transaction_subid = '$subid'";
                                //$sql_where .= " AND transaction_status = 'approved'";

                                //get no of clicks
                                $sql = "SELECT COUNT(*) AS count1 FROM partners_transaction WHERE 1 ";
                                $sql .= $sql_where." AND transaction_type = 'click'";
                                $res = mysqli_query($con,$sql);
                                $clicks = 0;
                                if($row = mysqli_fetch_object($res)) $clicks = $row->count1;

                                //get total commission for all clicks
                                $sql = "SELECT transaction_amttobepaid,transaction_dateoftransaction FROM partners_transaction WHERE 1 ";
                                $sql .= $sql_where." AND transaction_type = 'click'";
                                $res = mysqli_query($con,$sql);
                                $click_amount = 0;
                                while($row = mysqli_fetch_object($res))
								{
								 	//$click_amount += $row->transaction_amttobepaid;
									$click_amt  	=  $row->transaction_amttobepaid;
								   	$date 		=  $row->transaction_dateoftransaction ;
									$click_amount = $click_amt + $click_amount;
								}
								
								//Added by SMA to find the impression comission amt on 8-Mar-06
                                //get total commission for all impression
                                $sql = "SELECT transaction_amttobepaid,transaction_id,transaction_dateoftransaction FROM partners_transaction WHERE 1 ";
                                $sql .= $sql_where." AND transaction_type = 'impression'"; 
                                $res = mysqli_query($con,$sql);  
                                $impression = 0;
								$impression_cnt = 0;  
                                while($row = mysqli_fetch_object($res))
								{
								 	//$impression = $row->transaction_amttobepaid + $impression;
									$imp_amt  	=  $row->transaction_amttobepaid;
								   	$date 		=  $row->transaction_dateoftransaction ;
									$impression = $imp_amt + $impression;
									
									//To get the number of impressions
									$trans_id = $row->transaction_id;
									$trans_sql = "SELECT * FROM partners_trans_rates WHERE trans_id='$trans_id'";
									$trans_result = mysqli_query($con,$trans_sql);
									if(mysqli_num_rows($trans_result) > 0)
									{ 
										$trans_row = mysqli_fetch_object($trans_result);
										$impression_cnt += $trans_row->trans_unit ;
									}
								}
								//End add on 8-Mar-06


                                //get no of leads
                                $sql = "SELECT COUNT(*) AS count1 FROM partners_transaction WHERE 1 ";
                                $sql .= $sql_where." AND transaction_type = 'lead'";
                                $res = mysqli_query($con,$sql);
                                $leads = 0;
                                if($row = mysqli_fetch_object($res)) $leads = $row->count1;

                                //get total commission for all clicks
                                $sql = "SELECT transaction_amttobepaid, transaction_dateoftransaction FROM partners_transaction WHERE 1 ";
                                $sql .= $sql_where." AND transaction_type = 'lead'";
                                $res = mysqli_query($con,$sql);
                                $lead_amount = 0;
                                while($row = mysqli_fetch_object($res))
								{
								 	//$lead_amount += $row->transaction_amttobepaid;
									$lead_amt  	=  $row->transaction_amttobepaid;
								   	$date 		=  $row->transaction_dateoftransaction ;
									$lead_amount = $lead_amt + $lead_amount;
								}

                                //get no of sales
                                $sql = "SELECT COUNT(*) AS count1 FROM partners_transaction WHERE 1 ";
                                $sql .= $sql_where." AND transaction_type = 'sale'";
                                $res = mysqli_query($con,$sql);
                                $leads = 0;
                                if($row = mysqli_fetch_object($res)) $sales = $row->count1;

                                //get total commission for all clicks
                                $sql = "SELECT * FROM partners_transaction WHERE 1 ";
                                $sql .= $sql_where." AND transaction_type = 'sale'";
                                $res = mysqli_query($con,$sql);
                                $sale_amount = 0;
                                while($row = mysqli_fetch_object($res))
								{
								 	//$sale_amount += $row->transaction_amttobepaid;
							//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
									 $transactionId	= $row->transaction_id;
									 $recur 	 = 	$row->transaction_recur;
							
									  // If the sale commission is of recurring type
									 if($recur == '1') 
									 {
										$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
										$res_Recur	= mysqli_query($con,$sql_Recur);
										if(mysqli_num_rows($res_Recur) > 0)
										{
											$row_recur	= mysqli_fetch_object($res_Recur);
											$recurId	= $row_recur->recur_id;
											
											$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
											$res_recurpay	= mysqli_query($con,$sql_recurpay);
											if(mysqli_num_rows($res_recurpay) > 0)
											{
												$row_recurpay 	= mysqli_fetch_object($res_recurpay);
												$sale_amt 	 =  $row_recurpay->recurpayments_amount; 
											}
										}
									 }
									 else
									 {	 
							// END Modified on 23-JUNE-06
										 	$sale_amt  	=  $row->transaction_amttobepaid;
									 }
								   	$date 		=  $row->transaction_dateoftransaction ;
									$sale_amount = $sale_amt + $sale_amount;
								}
?>
<?
	$AffiliateId = $_SESSION[AFFILIATEID];
	 $selDate		= $heading ;
	 $values		= $impression_count."~".$impression."~".$clicks."~".$click_amount."~".$leads."~".$lead_amount."~".$sales."~".$sale_amount."~".$currSymbol."~".$subid;
?>
 <p align="right">
	<a href="#" onClick="window.open('../print_subid.php?aid=<?=$AffiliateId?>&date=<?=$selDate?>&values=<?=$values?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_subid.php?aid=<?=$AffiliateId?>&date=<?=$selDate?>&values=<?=$values?>"><b><?=$lang_export_csv_head?></b></a> 	
 &nbsp;&nbsp;&nbsp;</p>

                                <tr>
                                        <td height="23">&nbsp;&nbsp;&nbsp;<b><?=$lang_subid_subid?>:- <?=$subid?></b></td>
                                </tr>
                 <tr>
                    <td  height="20" width="100%" align="center">
                                                <table width="50%"  border="0" align="center" cellpadding="0" cellspacing="0">
                                                  <tr>
                                                        <td height="7" colspan="3" ></td>
                                                  </tr>
                                                  <tr>
                                                          <td width="49%"  height="20" align="right"  ><b><font color='#923D4E'><?=$lang_subid_rawclicks?></font></b></td>
                                                          <td width="2%"  >&nbsp;</td>
                                                          <td width="49%"  height="20" align="left"  ><b>: <?=$rawclicks?></b></td>
                                                  </tr>
                                                   <tr>
                                                          <td  height="20" align="right"  ><b><font color='#923D4E'><?=$lang_subid_rawimpressions?></font></b></td>
                                                          <td  >&nbsp;</td>
                                                          <td  height="20" align="left"  ><b>: <?=$impressions?></b></td>
                                                  </tr>
                                                  </table>
                                        </td>
                 </tr>
                                 <tr>
                                    <td>
                                                <table width="85%"  align="center"  class="tablebdr">
                          <tr >
                               <td width="40%"  class="tdhead"><?=$lang_home_transaction?></td>
                               <td width="30%"  class="tdhead"><?=$lang_home_number?></td>
                               <td width="30%"  class="tdhead"><?=$lang_home_commission?></td>
                          </tr>
                           <tr> 
                                   <td width="35%"  class="grid1" height="15"> <?=$lang_affiliate_imp?>&nbsp;<img  alt="" border="0" height="10" src="../images/impression.gif" width="10" /></td>
                                    <td width="26%"  class="grid1" ><?=$impression_count?></td>
                                    <td width="39%"   class="grid1" ><?=$currSymbol?>&nbsp;<?=$impression?></td>
                          </tr>
                          <tr>
                               <td width="25%" class="grid1" height="15"><?=$lang_affiliate_head_click?>&nbsp;<img
                               alt="" border="0" height="10" src="../images/click.gif" width="10" /></td>
                               <td width="25%"  class="grid1" height="15"><?=$clicks?></td>
                               <td width="25%" class="grid1" height="15"><?=$currSymbol?>&nbsp;<?=$click_amount?></td>
                          </tr>
                          <tr>
                               <td width="25%" class="grid1" height="15"><?=$lang_affiliate_head_lead?>&nbsp;<img
                               alt="" border="0" class="grid1" height="10" src="../images/lead.gif" width="10" /></td>
                               <td width="25%" class="grid1" height="15"><?=$leads?></td>
                               <td width="25%" class="grid1" height="15"><?=$currSymbol?>&nbsp;<?=$lead_amount?></td>
                          </tr>
                          <tr>
                               <td width="25%" class="grid1" height="15"><?=$lang_affiliate_head_sale?>&nbsp;<img
                                alt="" border="0" class="grid1" height="10" src="../images/sale.gif" width="10" /></td>
                               <td width="25%" class="grid1" height="15"><?=$sales?></td>
                               <td width="25%" class="grid1" height="15"><?=$currSymbol?>&nbsp;<?=$sale_amount?></td>
                          </tr>
                                </table>
                                            <br/></td>
                                 </tr>
<?php
                        }//end of for loop
                }//end of checking for result
?>
                                 </table>
<?php
        }//end of checking for sub id
?>
<br />
<script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.trans.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.trans.txtto,Date);
        }
</script>