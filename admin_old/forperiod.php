<?
 /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW FORPERIOD REPORTS
      VARIABLES          :   click		=total click amnt
   			  				 lead		=total lead amnt
    						 sale		=total sale amnt
    						 nclick		=total no of clicks
   						     nlead      =total no of leads
   							 nsale      =total no of sales
                             Merchant   =MERCHANT ID
                             Affilaiete =AFFILAIE ID
                             from		=from date
    						 to			=to date
                             msg	  	=errmsg
                             sub		=get submit button
  //*************************************************************************************************/
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
<?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);


    /*********************getting existing merchant and affiliates*************/
    $sql ="SELECT * from partners_merchant ";
    $ret=mysqli_query($con,$sql);
    $sql ="SELECT * from partners_affiliate ";
    $ret1=mysqli_query($con,$sql);
    /**************************************************************************/


    /*********************variables********************************************/
    $total		  		=trim($_GET['total']);         // approved,pending,reversed
    $click		 		=trim($_GET['click']);         //total amnt of click
    $nclick				=trim($_GET['nclick']);        //total no of click
    $lead				=trim($_GET['lead']);          //total amnt of lead
    $nlead				=trim($_GET['nlead']);         //total no of lead
    $sale				=trim($_GET['sale']);          //total amntof sale +subsale
    $nsale				=trim($_GET['nsale']);         //total no of sale
    $from				=trim($_GET['from']);          //from date
    $to					=trim($_GET['to']);            //to date
    $merchant			=intval(trim($_GET['merchant']));      //merchantid
    $affiliate			=intval(trim($_GET['affiliate']));     //affiliateid
    $msg				=trim($_GET['err']);           //errmsg
    $sub				=trim($_GET['sub']);           // get submit button
    $impression         = trim($_REQUEST['impression']); //impression_amt

   /***************************************************************************/


    $sale=explode("~",$sale);

    if(!empty($to) && !empty($to))
    {
     $heading=$from. " - ".$to;
    }


    $total =explode('~',$total);
 ?>
  <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe>
  <form name="trans" method="post" action="forperiod_process.php">
  <table border='0' cellpadding="0" cellspacing="0"  class="tablebdr"  width="75%" >
    <tr>
      <td colspan="8" height="19" class="tdhead" align="center"><b>Statistics For Custom Period</b></td>
    </tr>
    <tr>
      <td colspan="8" height="19"  align="center" class="textred"> <?=$msg?></td>
    </tr>
    <tr>
      <td width="2%" height="13">&nbsp;</td>
      <td colspan="3" height="13" align="center"><b>For Period</b></td>
      <td colspan="4" height="13">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" >&nbsp;</td>
    </tr>
	
    <tr>
      <td width="2%" height="22">&nbsp;</td>
      <td width="14%" height="22" align="right">From</td>
      <td width="3%">&nbsp;</td>
      <td width="20%" height="22" align="left"><input type="text" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /></td>
      <td width="17%" height="22">&nbsp;</td>
      <td width="10%" height="22" align="right">Merchants </td>
      <td width="3%">&nbsp;</td>
      <td width="31%" height="22" align="left">
        <select name="Mname" ><option value="All" >All Merchants </option>
                               <?  while($row=mysqli_fetch_object($ret))
                               {
                               if($merchant=="$row->merchant_id")
                                      $MerchantName="selected = 'selected'";
                               else
                                $MerchantName="";

                               ?>
                                 <option <?=$MerchantName?> value="<?=$row->merchant_id?>"> <?=stripslashes($row->merchant_company)?> </option>
                               <?
                               }
                               ?>
                       </select>
      </td>
    </tr>
	<tr><td colspan="8">&nbsp;</td></tr>
    <tr>
      <td width="2%" height="22">&nbsp;&nbsp; </td>
      <td width="14%" height="22" align="right">To</td>
      <td width="3%">&nbsp;</td>
      <td width="20%" height="22" align="left"><input type="text" name="txtto" size="18" value="<?=$to?>" onfocus="javascript:to_date();return false;" /></td>
      <td width="17%" height="22">&nbsp;</td>
      <td width="10%" height="22" align="right">Affiliates </td>
      <td width="3%">&nbsp;</td>
      <td width="31%" height="22" align="left">
       <select name="Aname"><option value="All">All Affiliates </option>

                           <?  while($row=mysqli_fetch_object($ret1))
                           {
                           if($affiliate=="$row->affiliate_id")
                            $AffiliateName="selected = 'selected'";
                           else
                            $AffiliateName="";

                           ?>
                             <option <?=$AffiliateName?> value="<?=$row->affiliate_id?>"><?=stripslashes($row->affiliate_company)?></option>
                           <?
                           }
                           ?>
                       </select>
      </td>
    </tr>
    <tr>
      <td width="2%" height="23">&nbsp;</td>
      <td width="14%" height="23">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="20%" height="23">&nbsp;</td>
      <td width="17%" height="23">&nbsp;</td>
      <td height="23" colspan="3" >&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" align="center" height="26">
      <input type="submit" name="sub" value="View" /></td>
    </tr>
  </table>
  </form>
  <?

  if(!empty($sub))
   {

	$selDate		= $heading ;//$d.".".$m.".".$y;
	$values	= $sale[3]."~".$impression."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale[0];

   ?>
 <p align="right">
	<a href="#" onClick="window.open('../print_forperiod.php?mid=<?=$merchant?>&aid=<?=$affiliate?>&mode=admin&date=<?=$selDate?>&values=<?=$values?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_forperiod.php?mid=<?=$merchant?>&aid=<?=$affiliate?>&mode=admin&date=<?=$selDate?>&values=<?=$values?>"><b>Export as CSV</b></a>
 </p>
  <table border="0"  cellpadding="0" cellspacing="0" width="75%" class="tablebdr">
    <tr>
      <td  height="20" width="100%" align="center" class="tdhead"><b>Statistics
      <br/><?=$heading?></b></td>
     </tr>
	 <tr>
		 <td>
		   <br/>
			<table width="85%"  align="center"  class="tablebdr">
				  <tr >
				  <td width="40%"  class="tdhead">Transactions</td>
				  <td width="30%"  class="tdhead">Number</td>
				  <td width="30%"  class="tdhead">Commissions</td>
				  </tr>
				<!-- Added on 16-JUNE-06 -->
				<tr>
					<td width="25%" class="grid1" height="28">Impressions&nbsp;<img
					alt="" border='0' height="10" src="../images/impression.gif" width="10" /></td>
					<td width="25%"  class="grid1" height="28" ><?=$sale[3]?></td>
					<td width="25%" class="grid1" height="28"><?=$currSymbol?><?=round($impression,2)?></td>
				</tr>
				<!--  WEnd Add on 16-JUNE-06 -->
				  <tr>
				  <td width="25%" class="grid1" height="28">Clicks&nbsp;<img
				  alt="" border='0' height="10" src="../images/click.gif"
				  width="10" /></td>
				  <td width="25%"  class="grid1" height="28" ><?=$nclick?></td>
				  <td width="25%" class="grid1" height="28"><?=$currSymbol?><?=round($click,2)?></td>
				  </tr>
				  <tr>
				  <td width="25%" class="grid1" height="28">Leads&nbsp;<img
				  alt="" border='0' class="grid1" height="10" src="../images/lead.gif"
				  width="10" /></td>
				  <td width="25%" class="grid1" height="28"><?=$nlead?></td>
				  <td width="25%" class="grid1" height="28"><?=$currSymbol?><?=round($lead,2)?></td>
				  </tr>
				  <tr>
                      <td width="25%" class="grid1"height="28">Sales&nbsp;<img
                      alt="" border='0' class="grid1" height="10" src="../images/sale.gif"
                      width="10" /></td>
                      <td width="25%" class="grid1" height="28"><?=$nsale?></td>
                      <td width="25%" class="grid1" height="28"><?=$currSymbol?><?=round($sale[0],2)?></td>
				  </tr>
				  <tr>
				  	<td  class="grid1"  height="28" colspan="3" align="center"><b>Impressions : <?=$sale[3]?></b></td>
				  </tr>
			</table>
		</td>
	</tr>
	<tr><td>
        <? viewRawTrans($sale[4], $sale[5]) ?>
       <br/>
       <table width="100%" align="center"  class="tablewbdr">
              <tr>
              <td width="25%"  class="tdhead" align="center">Pending</td>
              <td width="25%"  class="tdhead" align="center">Reversed</td>
              </tr>
              <tr>
              <td width="25%" height="28" align="center"><?=$currSymbol?><?=round($total[1],2)?></td>
              <td width="25%" height="28" align="center"><?=$currSymbol?><?=round($total[3],2)?></td>
              </tr>
      </table>
	 </td></tr>
  </table>
  <?
  }
  ?><br/>