<script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.report.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.report.txtto,Date);
        }
</script>

  <?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    /****************************variables************************************/
    $MERCHANTID                   =$_SESSION['MERCHANTID'];//merchantid
    $total                        =trim($_GET['total']);   //total pending,reversed etc transactions
    $click                        =trim($_GET['click']);   //click amnt
    $nclick                       =trim($_GET['nclick']);  //no of clicks
    $lead                         =trim($_GET['lead']);    //lead amnt
    $nlead                        =trim($_GET['nlead']);   //no of leads
    $sale                         =trim($_GET['sale']);    //sale amnt
    $nsale                        =trim($_GET['nsale']);   //no of sales
    $from                         =trim($_GET['from']);    //from date
    $to                           =trim($_GET['to']);      //to date
    $msg                          =trim($_GET['err']);     //err msg
    $sub                          =trim($_GET['sub']);     //submit button
    $programs                     =intval(trim($_GET['programs']));//programid

    $sale                         =explode("~",$sale);
    $total                        =explode('~',$total);
    /**************************************************************************/


    if(!empty($to) && !empty($to))
    {
     $heading=$from. " - ".$to;
    }
  //  echo "$programs";
    $sql        = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2    = mysqli_query($con,$sql);

 ?>
  <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe>
 <br/>
 <form name="report" method="post" action="programs_process.php">
    <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2"  align="center"><b>
             <?=$lang_report_stat?></b></td>
         </tr>
         <tr>
                  <td  height="19" colspan="2"  align="center" class="textred">
                 <?=$msg?></td>
         </tr>
                <tr>
                 <td  height="19" colspan="2"  align="center"><b>
                 <?=$lang_report_forperiod?></b></td>
        </tr>
            <tr>
                 <td width="50%" height="24" align="center">&nbsp;<?=$lang_report_from?></td>
                 <td width="50%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /></td>
            </tr>
            <tr>
                    <td width="50%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
                 <td width="50%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$to?>" onfocus="javascript:to_date();return false;" /></td>
            </tr>
            <tr>
                 <td height="23" colspan="2" >&nbsp;</td>
            </tr>
        <tr>
             <td height="20" class="tdhead" colspan="2"  align="center"><b><?=$lang_report_SearchProgram?></b>
             </td>
        </tr>
            <tr>
                 <td height="13" colspan="2" >&nbsp;</td>
            </tr>
        <tr>
             <td height="25" colspan="2" align="center" >
                      <select name="programs" ><option value="All" ><?=$lang_report_AllProgram?> </option>
                               <?  while($row=mysqli_fetch_object($result2))

                               {
                               if($programs=="$row->program_id")
                                      $programName="selected = 'selected'";
                               else
                                $programName="";

                               ?>
                                 <option <?=$programName?> value="<?=$row->program_id?>"><?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?>  </option>
                               <?
                               }
                               ?>
                   </select>
            </td>
            </tr>
            <tr>
                <td colspan="2"  align="center" height="26">
                 <input name="currValue" type="hidden" value="<?=$currValue?>" />
                <input type="submit" name="sub" value="<?=$lang_report_view?>" /></td>
            </tr>
  </table>
  </form>
  <?
  if(!empty($sub))
   {
   	$selDate	= $heading ;
	$values 	= $sale[7]."~".$sale[10]."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale[0]."~".$sale[2]."~".$sale[1]."~".$total[1]."~".$total[3]."~".$currSymbol;
   ?>
 <p align="right">
	<a href="#" onClick="window.open('../print_programs.php?mid=<?=$MERCHANTID?>&date=<?=$selDate?>&program=<?=$programs?>&values=<?=$values?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_programs.php?mid=<?=$MERCHANTID?>&date=<?=$selDate?>&program=<?=$programs?>&values=<?=$values?>"><b>Export as CSV</b></a> &nbsp;&nbsp;&nbsp;	
 </p>
  <table border="0"  cellpadding="0" cellspacing="0" width="75%" class="tablebdr" align="center">
    <tr>
      <td  height="20" width="100%" align="center" class="tdhead"><b><?=$lang_report?>
      <br/><?=$heading?></b></td>
     </tr>

      <tr>
      <td  height="40" width="100%" align="center" class="red"><?=$lang_report_AllAffil?> :<?=$sale[3]?>
      </td>
     </tr>
	 <tr>
     <td>
       <form name="showreport" method="post" action="" >
       <br/>
        <table width="85%"  align="center"  class="tablebdr">
              <tr >
              <td width="40%"  class="tdhead"><b><?=$lang_report_transaction?></b></td>
              <td width="30%"  class="tdhead"><?=$lang_report_mumber?></td>
              <td width="30%"  class="tdhead"><?=$lang_report_commision?></td>
              </tr>

               <tr>
                    <td width="35%"  class="grid1" height="28"> <?=$lhome_Imp?>
                          </td>
                    <td width="26%"  class="grid1" ><?=$sale[7]?></td>
                    <td width="39%"   class="grid1" ><?=$sale[10]?> <?=$currSymbol?></td>
                  </tr>
				  <tr>
              <td width="25%" class="grid1" height="28"><?=$lang_report_click?>&nbsp;
			  <img alt="" border="0" height="10" src="../images/click.gif"
              width="10" /></td>
              <td width="25%"  class="grid1" height="28" ><?=$nclick?></td>
              <td width="25%" class="grid1" height="28"><?=$click?> <?=$currSymbol?></td>
              </tr>
              <tr>
              <td width="25%" class="grid1" height="28"><?=$lang_report_lead?>&nbsp;
			  <img alt="" border="0" class="grid1" height="10" src="../images/lead.gif"
              width="10" /></td>
              <td width="25%" class="grid1" height="28"><?=$nlead?></td>
              <td width="25%" class="grid1" height="28"><?=$lead?> <?=$currSymbol?></td>
              </tr>
              <tr>
              <td width="25%" class="grid1"height="28"><?=$lang_report_sale?>&nbsp;
			  <img alt="" border="0" class="grid1" height="10" src="../images/sale.gif"
              width="10" /></td>
              <td width="25%" class="grid1" height="28"><?=$nsale?></td>
              <td width="25%" class="grid1" height="28"><?=$sale[0]?> <?=$currSymbol?></td>
              </tr>
        </table>
         <? viewRawTrans($sale[8], $sale[9]) ?>
       <br/>
       <table width="85%" align="center" class="tablebdr" >
              <tr>
				  <td width="25%"  class="tdhead" align="center"><b><?=$lang_report_pending?></b></td>
				  <td width="25%"  class="tdhead" align="center"><b><?=$lang_report_reversed?></b></td>
              </tr>
              <tr>
				  <td width="25%" height="28" align="center"><?=$total[1]?> <?=$currSymbol?></td>
				  <td width="25%" height="28" align="center"><?=$total[3]?> <?=$currSymbol?></td>
              </tr>
      </table><br />
	  </form>
      </td>
		</tr>
  </table>
  <?
  }
  ?><br />