<?
  # Merchant Id
   $id 			   =   $_SESSION['MERCHANTID'];

   $saletype       = trim($_POST['saletype']);
   $leadtype       = trim($_POST['leadtype']);
   $clicktype      = trim($_POST['clicktype']);
   $programs	   = trim($_POST['programs']);
   $txtfrom        = trim($_POST['txtfrom']);    //from date
   $txtto          = trim($_POST['txtto']);      //to date
   $trans_id	   = $_GET['trans_id'];
   ##modified on 01.mar.06 to add impressions
   $impr_type         = trim($_POST['impr_type']);
   $gridcounter	=	0;

    $msg = "";

    if((empty($txtto)) and (empty($txtfrom))){
    }else {
       if((!$partners->is_date($txtto)) || (!$partners->is_date($txtfrom))){
           		$msg = "Please Enter Valid Dates";
       }
    }

   # getting page no
   $page		=   (empty($page))? $partners->getpage(): trim($_GET['page']);

   # geting records from table
   $sql		=	" SELECT *,date_format(transaction_dateoftransaction,'%d, %m %Y') AS DATE FROM partners_transaction AS t, partners_joinpgm AS j,partners_merchant as a where merchant_id='$id'";
   $sql	   .=	" AND  t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_merchantid=a.merchant_id ";
   $sql    .=   (!empty($trans_id)) ? " AND transaction_id = '$trans_id' " :"";

   $sql    .=   ($programs != "All" and !empty($programs))?" AND joinpgm_programid = '$programs'":"";

   if($partners->is_date($txtto) && $partners->is_date($txtfrom)){
           $To   = $partners->date2mysql($txtto);
           $From = $partners->date2mysql($txtfrom);

          $sql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
    }

    if($saletype==1 or $leadtype==1 or $clicktype==1  or $impr_type==1){
     $tsql  .= ($saletype==1)  ? "  OR  t.transaction_type = 'sale' " : "";
     $tsql  .= ($leadtype==1)  ? "  OR  t.transaction_type = 'lead' " : "";
     $tsql  .= ($clicktype==1) ? "  OR  t.transaction_type = 'click' " : "";
	 $tsql  .= ($impr_type==1) ? "  OR  t.transaction_type = 'impression' " : "";

     $tsql = trim($tsql);
     $tsql = trim($tsql,"OR");
     $tsql = " AND (".$tsql.")";
     $sql .= $tsql;
    }


   $pgsql	= 	$sql;
   $sql    .=	" LIMIT ".($page-1)*$lines.",".$lines; //adding page no

   $ret 	=	mysqli_query($con,$sql);


   # getting all programs
    $sql1      = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2  = mysqli_query($con,$sql1);
 ?>
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
  <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
 </iframe>
 <br/>
 <form name="trans" method="post" action="#">
    <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2" align="center"><b><?=$lang_report_stat?></b></td>
         </tr>
         <tr>
             <td  height="19" colspan="2"  align="center" class="textred"><?=$msg?></td>
         </tr>
        <tr>
                 <td  height="19" colspan="2" align="center" ><b><?=$lang_report_forperiod?></b></td>
        </tr>
        <tr>
             <td width="50%" height="24" align="center">&nbsp; <?=$lang_report_from?></td>
             <td width="50%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" /></td>

        </tr>
        <tr>
                <td width="50%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
             <td width="50%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$txtto?>" onfocus="javascript:to_date();return false;" /></td>

        </tr>
        <tr>
             <td height="23" colspan="2">&nbsp;</td>
        </tr>
        <tr>
             <td height="20" class="tdhead"  colspan="2" align="center"><b><?=$lang_report_SearchProgram?></b>
             </td>
        </tr>
            <tr>
                 <td height="13" colspan="2">&nbsp;</td>
            </tr>
        <tr>
             <td height="25" colspan="2" align="center" >
                      <select name="programs" ><option value="All" ><?=$lang_report_AllProgram?> </option>
                               <?
                               while($row=mysqli_fetch_object($result2))

                               {
                               if($programs=="$row->program_id")
                                      $programName="selected = 'selected'";
                               else
                                $programName="";

                               ?>
                                 <option <?=$programName?> value="<?=$row->program_id?>"><?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> </option>
                               <?
                               }
                               ?>
                   </select>
            </td>
            </tr>
             <tr>
                          <td height="13" colspan="2">&nbsp;</td>
                     </tr>
                     <tr>
                        <td colspan="2" align="center" height="20" > 
						<input type="checkbox" name="impr_type" value="1" class="borderless" <?=($impr_type)?"checked='checked'":""?> /> Impression&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="clicktype" value="1" <?=$schk?> class="borderless" <?=($clicktype)?"checked='checked'":""?> /> Click&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="saletype" value="1"  class="borderless" <?=($saletype)?"checked='checked'":""?> /> Sale &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="leadtype" value="1"  class="borderless" <?=($leadtype)?"checked='checked'":""?> /> Lead
                        </td>
                     </tr>
                      <tr>
                         <td height="13" colspan="2">&nbsp;</td>
             </tr>
            <tr>
                <td colspan="6" align="center" height="26">
                <input type="submit" name="sub" value="<?=$lang_report_view?>" /></td>
            </tr>
  </table>
  </form>
  <?

  # checking for each records
  if(mysqli_num_rows($ret)>0){
  ?>
 <br/>
 <br/>
<p align="right"><a href="#" onClick="window.open('../print_transaction.php?mid=<?=$id?>&programs=<?=$programs?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$saletype?>&lead=<?=$leadtype?>&impr=<?=$impr_type?>&click=<?=$clicktype?>&mode=merchant&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_transaction.php?mid=<?=$id?>&programs=<?=$programs?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$saletype?>&lead=<?=$leadtype?>&impr=<?=$impr_type?>&click=<?=$clicktype?>&mode=merchant&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>"><b><?=$lang_export_csv_head?></b></a>&nbsp;&nbsp;&nbsp;</p>
 <table class="tablebdr" cellspacing="1" width="95%" id="AutoNumber1" align="center">
    <tr>
    <td width="10%" align="center" class="tdhead"><b><?=$trans_type?></b></td>
    <td width="5%" align="center" class="tdhead"><b><?=$trans_orderId?></b></td>
    <td width="20%" align="center" class="tdhead"><b><?=$trans_affiliate?></b> </td>
    <td width="30%" align="center" class="tdhead"><b><?=$trans_comm?></b></td>
    <td width="20%" align="center" class="tdhead"><b><?=$trans_date?></b></td>
    <td width="15%" align="center"  class="tdhead"><b><?=$trans_status?></b></td>
  </tr>
  <?
          while($rows=mysqli_fetch_object($ret))
          {
            $type		   		=	$rows->transaction_type ;
            $merchantid	   		=	$rows->joinpgm_merchantid ;
            $merchantname  		=	stripslashes($rows->merchant_compnay);
            $affiliateid   		=	$rows->joinpgm_affiliateid ;

            $sql2 =	"select * from partners_affiliate where affiliate_id='$affiliateid' ";
            $ret2 =	mysqli_query($con,$sql2);

            if(mysqli_num_rows($ret2)>0){
              	$row2		=	mysqli_fetch_object($ret2);
                $affiliate	=	stripslashes($row2->affiliate_company);
            }

            $tstatus 	  		=	$rows->transaction_status ;
            $commission			=	$rows->transaction_amttobepaid ;
            $date				=	$rows->transaction_dateoftransaction ;
            $dateoftransaction  =	$rows->DATE ;
            $astatus			=	$rows->joinpgm_status;
            $adminComm			=   $rows->transaction_admin_amount;
             # converting to user currency
             if($currValue != $default_currency_caption){
                   $commission     =   getCurrencyValue($date, $currValue, $commission);
                   $adminComm     =   getCurrencyValue($date, $currValue, $adminComm);
              }
            $classid = ($gridcounter%2==1)? "grid1" : "grid2" ;

 	       ?>

	         <tr class="<?=$classid?>" >
	            <td width="10%" align="center"  ><?=$type?>&nbsp;
				<img alt="" border="0" height="10" src="../images/<?=$type?>.gif" width="10" /></td>
	            <td width="5%" align="center"  ><?=$rows->transaction_orderid?>
	            </td>

	            <td width="20%" align="center" ><a href="#" onclick="help1(<?=$affiliateid?>)"> <?=$affiliate?></a></td>
                <td width="30%" align="center"  >
                <table class="tablewbdr">
					<tr>
                   <td width="40%" align="right"  ><?=$currSymbol?> <?=number_format($commission,2)?></td>
                   <td width="10%" align="center"  >
                   <img src="../images/add.gif" width="10" height="10" alt="" border="0" /></td>
                   <td width="40%" align="left"  ><?=$currSymbol?> <?=number_format($adminComm,2)?>  </td>
					</tr>
                </table>

                </td>
	            <td width="20%" align="center" ><?=$dateoftransaction?></td>

	            <td width="15%" align="left" >
	                &nbsp;<img alt="" border="0" height="15" src="../images/<?=$tstatus?>.gif"
	                                  width="15" />&nbsp;<?=$tstatus?></td>


	          </tr>

	         <?

    		$gridcounter	 =	$gridcounter+1;
            }
      		$classid		 = ($gridcounter%2==1)? "grid1" : "grid2" ;


	        ?>
            </table>
			<table cellspacing="1" width="95%" align="center">
	        <tr>
	        <td width="100%" colspan="6" align="left">
	        <?
	        $url    ="index.php?Act=transaction_merchant&amp;merid=$id&amp;trans_id=$trans_id";    //adding page nos
	        include '../includes/show_pagenos.php';
	        ?>
	        </td>
	        </tr>
	        </table>
    <?
     } // outer if closing
    else{
    ?>
    	<p align="center" class="textred"><?=$norec?></p><?
    }
    ?>

	<script language="javascript" type="text/javascript">
		function help(merchantid)
		{
			url="viewprofile_merchant.php?id="+merchantid;
			nw = open(url,'new','height=400,width=400,scrollbars=yes');
			nw.focus();
		}
		
		function help1(afiliateid)
		{
			url="viewprofile_affiliate.php?id="+afiliateid;
			nw = open(url,'new','height=400,width=400,scrollbars=yes');
			nw.focus();
		}
	</script>