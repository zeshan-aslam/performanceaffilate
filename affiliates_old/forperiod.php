	<script language="javascript" type="text/javascript">
		function from_date(){
			gfPop.fStartPop(document.trans.txtfrom,Date);
		}
		function to_date(){
			gfPop.fStartPop(document.trans.txtto,Date);
		}
	</script>

	<?

    $total                        =trim($_GET['total']);         //statistics
    $click                        =trim($_GET['click']);         //total click amnt
    $nclick                       =trim($_GET['nclick']);        //total click
    $lead                         =trim($_GET['lead']);          //total lead amnt
    $nlead                        =trim($_GET['nlead']);         //total lead
    $sale                         =trim($_GET['sale']);          //total sale amnt
    $nsale                        =trim($_GET['nsale']);         //total sale
    $from                         =trim($_GET['from']);          //from date
    $to                           =trim($_GET['to']);            //to date
    $merchant                     =intval(trim($_GET['merchant']));      //merchant id
    $affiliate                    =intval(trim($_GET['affiliate']));     //affiliateid
    $msg                          =trim($_GET['err']);           //err msg
    $sub                          =trim($_GET['sub']);           //submit button
    $sale                         =explode("~",$sale);
    $total                        =explode('~',$total);
	$impression						=trim($_REQUEST['impression']);      //impression_amt

	if(!empty($to) && !empty($to)){
		$heading=$from. " - ".$to;
	}
 ?>
 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe>
 <br/>
  <form name="trans" method="post" action="forperiod_process.php?currCaption=<?=$currValue?>" >
  <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2" >&nbsp;&nbsp;<b> <?=$lang_report_stat?> </b></td>
         </tr>
         <tr>
            <td  height="19" colspan="2" class="error" align="center"> <?=$msg?></td>
         </tr>
         <tr>
            <td  height="19" colspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;<b><?=$lang_report_forperiod?></b></td>
         </tr>
         <tr>
            <td width="49%" height="24" align="center">&nbsp; <?=$lang_report_from?></td>
            <td width="51%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" />
            </td>
        </tr>
        <tr>
            <td width="49%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
            <td width="51%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$to?>"  onfocus="javascript:to_date();return false;" />
            </td>
        </tr>
        <tr>
            <td width="49%" height="23">&nbsp;</td>
        </tr>
       <tr>
           <td colspan="6" align="center" height="26">
           <input type="submit" name="sub"  value="<?=$lang_report_view?>" /></td>
      </tr>
  </table>
  </form>
  <?

  if(!empty($sub))
   {
   
	$selDate		= $heading ;//$d.".".$m.".".$y;	
	$values	= $sale[3]."~".$impression."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale[0]."~".$sale[2]."~".$sale[1]."~".$currSymbol;
   
   ?>
 <p align="right">
	<a href="#" onClick="window.open('../print_forperiod.php?aid=<?=$AFFILIATEID?>&mode=affiliate&date=<?=$selDate?>&values=<?=$values?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_forperiod.php?aid=<?=$AFFILIATEID?>&mode=affiliate&date=<?=$selDate?>&values=<?=$values?>"><b><?=$lang_export_csv_head?></b></a> 	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
  <table border="0"  cellpadding="0" cellspacing="0" width="75%" class="tablebdr" align="center">
    <tr>
      <td  height="20" width="100%" align="center" class="tdhead"><b><?=$lang_report?><br/><?=$heading?></b></td>
     </tr>
	<tr>
     <td>

       <br/>
        <table width="85%"  align="center"  class="tablebdr">
              <tr >
              <td width="40%"  class="tdhead"><b><?=$lang_home_transaction?></b></td>
              <td width="30%"  class="tdhead"><b><?=$lang_home_number?></b></td>
              <td width="30%"  class="tdhead"><b><?=$lang_home_commission?></b></td>
              </tr>
              <tr>
               <td width="25%" class="grid1" height="25"><?=$lang_affiliate_imp?>&nbsp;<img alt="" border='0' height="10" src="../images/impression.gif" width="10" /></td>
               <td width="25%" class="grid1"  height="25"><?=$sale[3]?></td>
               <td width="25%" class="grid1"  height="25"><?=$currSymbol?><?=$impression?></td>
              </tr>
              <tr>
              <td width="25%" class="grid1" height="28"><?=$lang_affiliate_head_click?>&nbsp;<img
              alt="" border="0" height="10" src="../images/click.gif"
              width="10" /></td>
              <td width="25%"  class="grid1" height="28" ><?=$nclick?></td>
              <td width="25%" class="grid1" height="28"><?=$currSymbol?><?=$click?></td>
              </tr>
              <tr>
              <td width="25%" class="grid1" height="28"><?=$lang_affiliate_head_lead?>&nbsp;<img
              alt="" border="0" class="grid1" height="10" src="../images/lead.gif"
              width="10" /></td>
              <td width="25%" class="grid1" height="28"><?=$nlead?></td>
              <td width="25%" class="grid1" height="28"><?=$currSymbol?><?=$lead?></td>
              </tr>
              <tr>
              <td width="25%" class="grid1"height="28"><?=$lang_affiliate_head_sale?>&nbsp;<img
              alt="" border="0" class="grid1" height="10" src="../images/sale.gif"
              width="10" /></td>
              <td width="25%" class="grid1" height="28"><?=$nsale?></td>
              <td width="25%" class="grid1" height="28"><?=$currSymbol?><?=$sale[0]?></td>
              </tr>

        </table>
       <br/>
       <? viewRawTrans($sale[4], $sale[5]) ?>
        <br/>
       <table width="70%" align="center"  class="tablebdr" >

            <tr>
            	<td width="25%"  class="tdhead" align="center"><b><?=$lang_home_pending?></b></td>
            </tr>
            <tr>
            	<td width="25%" height="28" align="center"><?=$currSymbol?><?=$total[1]?></td>
            </tr>
      </table>
       <p>&nbsp;</p></td>
	  </tr>

  </table>
  <?
  }
  ?>
  <br />