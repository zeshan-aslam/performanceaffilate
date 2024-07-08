
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


    /***********************variabels*****************************************/

    $total                        =trim($_GET['total']);   //total pending,reversed etc transactions
    $click                        =trim($_GET['click']);   //click amnt
    $nclick                       =trim($_GET['nclick']);  //no of clicks
    $lead                         =trim($_GET['lead']);    //lead amnt
    $nlead                        =trim($_GET['nlead']);   //no of leads
    $sale                         =trim($_GET['sale']);    //sale amnt
    $nsale                        =trim($_GET['nsale']);   //no of sales
    $subsale                      =trim($_GET['subsale']); //subsale amnt
    $nsubsale                     =trim($_GET['nsubsale']);//no of subsale
    $from                         =trim($_GET['from']);    //from date
    $to                           =trim($_GET['to']);      //to date
    $merchant                     =trim($_GET['merchant']);//mercahnt id
    $affiliate                    =trim($_GET['affiliate']);//affuiliateid
    $msg                          =trim($_GET['err']);      //err msg
    $sub                          =trim($_GET['sub']);      //submit button
    /*************************************************************************/

    $sale                         =explode("~",$sale);
    $total                        =explode('~',$total);

    if(!empty($to) && !empty($to))
                    {
            $heading=$from. " - ".$to;
            }



 ?>
 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe>
 <br/>
  <form name="trans" method="post" action="forperiod_process.php">
  <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">

	<tr>
		<td  height="19" class="tdhead" colspan="2"  align="center"><b><?=$lang_report_stat?></b></td>
	</tr>
	<tr>
		<td  height="19" colspan="2"  align="center" class="textred">
		<?=$msg?></td>
	</tr>
	<tr>
		<td  height="19" colspan="2"  align="center" >
		<b><?=$lang_report_forperiod?></b></td>
	</tr>
	<tr>
		<td width="51%" height="24" align="center">&nbsp; <?=$lang_report_from?></td>
		<td width="49%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /></td>
	</tr>
	<tr>
		<td width="51%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
		<td width="49%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$to?>" onfocus="javascript:to_date();return false;" /></td>
	</tr>
	<tr>
		<td width="51%" height="23">&nbsp;</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="2" align="center" height="26">
		<input name="currValue" type="hidden" value="<?=$currValue?>" />
		<input type="submit" name="sub" value="<?=$lang_report_view?>"  /></td>
	</tr>
  </table>
  </form>
  <?

  if(!empty($sub))
   {
   
	$selDate		= $heading ;//$d.".".$m.".".$y;	
	$values	= $sale[3]."~".$sale[6]."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale[0]."~".$sale[2]."~".$sale[1]."~".$currSymbol;
   
   ?>
 <p align="right">
	<a href="#" onClick="window.open('../print_forperiod.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&values=<?=$values?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_forperiod.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&values=<?=$values?>"><b><?=$lang_export_csv_head?></b></a> 	
&nbsp;&nbsp; </p>
  <table border="0"  cellpadding="0" cellspacing="0" width="75%" class="tablebdr" align="center">
    <tr>
      <td  height="20" width="100%" align="center" class="tdhead"><b><?=$lang_report?>
      <br/><?=$heading?></b></td>
     </tr>
	 <tr>
     <td>
       <form name="showreport" method="post" >
       <br/>
        <table width="85%"  align="center"  class="tablebdr">
              <tr >
              <td width="40%"  class="tdhead"><b><?=$lang_report_transaction?></b></td>
              <td width="30%"  class="tdhead"><b><?=$lang_report_number?></b></td>
              <td width="30%"  class="tdhead"><b><?=$lang_report_commission?></b></td>
              </tr>
               <tr>
                <td width="35%"  class="grid1" height="28"> <?=$lhome_Imp?>
                      </td>
                <td width="26%"  class="grid1" ><?=$sale[3]?></td>
                <td width="39%"   class="grid1" ><?=$sale[6]?> <?=$currSymbol?></td>
              </tr>
              <tr>
              <td width="25%" class="grid1" height="28"><?=$lang_report_click?>&nbsp;<img
              alt="" border="0" height="10" src="../images/click.gif"
              width="10" /></td>
              <td width="25%"  class="grid1" height="28" ><?=$nclick?></td>
              <td width="25%" class="grid1" height="28"><?=$click?> <?=$currSymbol?></td>
              </tr>
              <tr>
              <td width="25%" class="grid1" height="28"><?=$lang_report_lead?>&nbsp;<img
              alt="" border="0" class="grid1" height="10" src="../images/lead.gif"
              width="10" /></td>
              <td width="25%" class="grid1" height="28"><?=$nlead?></td>
              <td width="25%" class="grid1" height="28"><?=$lead?> <?=$currSymbol?></td>
              </tr>
              <tr>
              <td width="25%" class="grid1" height="28"><?=$lang_report_sale?>&nbsp;<img
              alt="" border="0" class="grid1" height="10" src="../images/sale.gif"
              width="10" /></td>
              <td width="25%" class="grid1" height="28"><?=$nsale?></td>
              <td width="25%" class="grid1" height="28"><?=$sale[0]?> <?=$currSymbol?></td>
              </tr>
        </table>
		</form>
         <? viewRawTrans($sale[4], $sale[5]) ?>
       <br/>

       <table width="85%" align="center" class="tablebdr" >

              <tr>

              <td width="25%"  class="tdhead" align="center"><b><?=$lang_report_pending?></b></td>

              <td width="25%"  class="tdhead" align="center"><b><?=$lang_report_reversed?><b></td>
              </tr>
              <tr>

              <td width="25%" height="28" align="center"><?=$total[1]?> <?=$currSymbol?></td>

              <td width="25%" height="28" align="center"><?=$total[3]?> <?=$currSymbol?></td>
              </tr>
      </table><br />
      <td>
	  </tr>
  </table>
  <?

  }
  ?><br />