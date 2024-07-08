<?php
include_once '../includes/constants.php';
include_once '../includes/functions.php';
//include_once '../includes/session.php';


  $mode=$_GET['mode'];
  $pgmid=$_GET['id'];
  $_SESSION['DES']="";

  if($mode=='edit')

  {
             $subbtn="EDIT";
             //echo $pgmid;

           $sqla="SELECT * FROM  partners_program where program_id='$pgmid'";  
           $sqlb="SELECT * FROM  partners_pgmstatus where pgmstatus_programid='$pgmid'"; 
           $sqlc="SELECT * FROM  partners_secondlevel where secondlevel_programid ='$pgmid'"; 
           $sqld="select * FROM  partners_firstlevel where firstlevel_programid='$pgmid'";

          $pgmres=mysqli_query($con,$sqla);
          $stares=mysqli_query($con,$sqlb);

          $secres=mysqli_query($con,$sqlc);
          echo mysqli_error($con); 
          $fstres=mysqli_query($con,$sqld);

          //fetching values from partners_program
          while ($pgmrow=mysqli_fetch_object($pgmres))
          {

                     $url                           =   stripslashes(trim($pgmrow->program_url));
                     $description                   =   stripslashes(trim($pgmrow->program_description));
                     $ip                            =   stripslashes(trim($pgmrow->program_ipblocking));
                     $pgmDate                                                =   stripslashes(trim($pgmrow->program_date));
                     list($cookie,$cookiePeriod)        =   explode(" ",$pgmrow->program_cookie);
                     $pgmcountries                                        =   stripslashes(trim($pgmrow->program_countries));
                     $res_countryarr                                =   explode(",",$pgmcountries);

                      //Enable/Disable Geo-Targeting
                      $geo_click                                                = $pgmrow->program_geotargeting_click;
                      $geo_lead                                                = $pgmrow->program_geotargeting_lead;
                      $geo_sale                                                = $pgmrow->program_geotargeting_sale;

                     //modified by SMA on 22-Feb-06
                       $geo_impression    =  $pgmrow->program_geotargeting_impression;
                       list($eyear,$emonth,$eday)  = split("-" , $enddate);
                       $enddate           =  $eday."/".$emonth."/".$eyear;
                     //End modify

          }

          //fetching values from table partners_pgmstatus
          while ($starow=mysqli_fetch_object($stares))
          {

                       $clickr                     =stripslashes(trim($starow->pgmstatus_clickapproval));
                       $leadr                      =stripslashes(trim($starow->pgmstatus_leadapproval));
                       $saler                      =stripslashes(trim($starow->pgmstatus_saleapproval));

                       $clicke                     =stripslashes(trim($starow->pgmstatus_clickmail));
                       $leade                      =stripslashes(trim($starow->pgmstatus_leadmail));
                       $salee                      =stripslashes(trim($starow->pgmstatus_salemail));

                       $mailaffil                   =stripslashes(trim($starow->pgmstatus_mailaffiliate));

                       $mailme                      =stripslashes(trim($starow->pgmstatus_mailmerchant));

                       $affiliater                  =stripslashes(trim($starow->pgmstatus_affiliateapproval));

                       //modified by SMA on 22-Feb-06
                        $impression_approval   =  stripslashes(trim($starow->pgmstatus_impressionapproval));
                        $impression_mail       =  stripslashes(trim($starow->pgmstatus_impressionmail));
                       //End modify
          }

          //fetching values  from partners_firstlevel
          while ($fstrow=mysqli_fetch_object($fstres))
          {
                        $click                    =stripslashes(trim($fstrow->firstlevel_clickrate));
                        $lead                     =stripslashes(trim($fstrow->firstlevel_leadrate));
                        $sale                     =stripslashes(trim($fstrow->firstlevel_salerate));
                        $saletype1                =stripslashes(trim($fstrow->firstlevel_saletype));

                        //modified by SMA 22-Feb-06
                        $impression_rate   =  stripslashes(trim($fstrow->firstlevel_impressionrate));
                        $impression_unit   =  stripslashes(trim($fstrow->firstlevel_unitimpression));
						
						//Modified for Recurring Commission
						$recur_sale			= stripslashes(trim($fstrow->firstlevel_recur_sale));
						$recur_percentage	= stripslashes(trim($fstrow->firstlevel_recur_percentage));
						$recur_period		= stripslashes(trim($fstrow->firstlevel_recur_period));
						
                        //End modify

                        if($currValue != $default_currency_caption)
                        {
                            $click     =   getCurrencyValue($pgmDate, $currValue, $click);
                            $lead      =   getCurrencyValue($pgmDate, $currValue, $lead);
                            $impression_rate   =  getCurrencyValue($pgmDate, $currValue, $impression_rate);
                            if($saletype1!="%")
                                    $sale     =   getCurrencyValue($pgmDate, $currValue, $sale);
                        }
          }

           //fetching values  from partners_secondlevel
          while ($secrow=mysqli_fetch_object($secres))
          {

                         $second                ="YES";
                         $secondtype            =stripslashes(trim($secrow->secondlevel_saletype));
                         $secondtxt             =stripslashes(trim($secrow->secondlevel_salerate));
           }

  } // mode if closing
  else
  {

                  //$url                   =stripslashes(trim($_GET['url']));
                  $url                   =$_SESSION['sess_url'];
                  $description           =stripslashes(trim($_GET['description']));
                  $click                 =stripslashes(trim($_GET['click']));
                  $lead                  =stripslashes(trim($_GET['lead']));
                  $sale                  =stripslashes(trim($_GET['sale']));
                  $saletype1             =stripslashes(trim($_GET['saletype1']));

                  $clickr                =stripslashes(trim($_GET['clickr']));
                  $leadr                 =stripslashes(trim($_GET['leadr']));
                  $saler                 =stripslashes(trim($_GET['saler']));


                  $clicke                =stripslashes(trim($_GET['clicke']));
                  $leade                 =stripslashes(trim($_GET['leade']));
                  $salee                 =stripslashes(trim($_GET['salee']));

                  $second                =stripslashes(trim($_GET['second']));
                  $secondtype            =stripslashes(trim($_GET['secondtype']));
                  $secondtxt             =stripslashes(trim($_GET['secondtxt']));

                  $mailaffil             =stripslashes(trim($_GET['mailaffil']));
                  $mailme                =stripslashes(trim($_GET['mailme']));

                  $affiliater            =stripslashes(trim($_GET['affiliater']));

                  $status                =stripslashes(trim($_GET['status']));
                  $ip                    =stripslashes(trim($_GET['ip']));
                  $msg                   =stripslashes(trim($_GET['msg']));

                    $geo_click                        = $_GET['geo_click'];
                    $geo_lead                                = $_GET['geo_lead'];
                    $geo_sale                                = $_GET['geo_sale'];

                 //modified by SMA 22-Feb-06
                       $geo_impression    =  stripslashes(trim($_REQUEST['geo_impression']));
                       $impression_approval   =  stripslashes(trim($_REQUEST['impressionr']));
                       $impression_mail   =  stripslashes(trim($_REQUEST['impressione']));
                       $impression_rate   =  stripslashes(trim($_REQUEST['impression']));
                       $impression_unit   =  stripslashes(trim($_REQUEST['impressionunit']));
					   
					   $recur_sale			= stripslashes(trim($_REQUEST['recur_sale']));
					   $recur_percentage	= stripslashes(trim($_REQUEST['recur_percentage']));
					   $recur_period		= stripslashes(trim($_REQUEST['recur_period']));
					   
                 //End modify

                    echo "<p align='center' > <span class='textred'>$msg</span></p>";
  }//end if

                      //Enable/Disable GeoTargeting
                      $geo_click_checked = $geo_lead_checked = $geo_sale_checked = "";
                      if($geo_click=="1") $geo_click_checked = "checked = 'checked'";
                      if($geo_lead=="1") $geo_lead_checked = "checked = 'checked'";
                      if($geo_sale=="1") $geo_sale_checked = "checked = 'checked'";


                      if($saler=="automatic")
                      {
                          $sr="checked = 'checked'";
                      }
                      else
                      {
                            $nsr="checked = 'checked'";
                      }

                      if($clickr=="automatic")
                      {
                          $cr="checked = 'checked'";
                      }
                      else
                      {
                            $ncr="checked = 'checked'";
                      }

                      if($leadr=="automatic")
                      {
                          $lr="checked = 'checked'";
                      }
                      else
                      {
                            $nlr="checked = 'checked'";
                      }

                      if($salee=="automatic")
                      {
                          $se="checked = 'checked'";
                      }
                      else
                      {
                            $nse="checked = 'checked'";
                      }

                      if($leade=="automatic")
                      {
                          $le="checked = 'checked'";
                      }
                      else
                      {
                            $nle="checked = 'checked'";
                      }
                      if($clicke=="automatic")
                      {
                          $ce="checked = 'checked'";
                      }
                      else
                      {
                            $nce="checked = 'checked'";
                      }

                      if($second=="YES")
                      {
                         $sec="checked = 'checked'";
                      }
                      else
                      {
                            $sec="";            //   $secondtype mailaffil mailme
                      }

                      if($mailaffil=="mailaffil"  || $mailaffil=="yes" )
                      {
                          $maf="checked = 'checked'";
                      }
                      else
                      {
                            $maf="";            //   $secondtype mailaffil mailme
                      }

                      if($mailme=="mailme" || $mailme=="yes")
                      {
                          $mme="checked = 'checked'";
                      }
                      else
                      {
                            $mme="";            //   $secondtype mailaffil mailme  affiliater=automatic
                      }

                      if($affiliater=="automatic")
                      {
                          $aa="checked = 'checked'";
                      }
                      else
                      {
                            $naa="checked = 'checked'";
                      }

                      if($secondtype=="$")
                      {
                          $ds="selected = 'selected'";
                      }
                      else
                      {
                         $ps="selected = 'selected'";
                      }

                      if($saletype1=="%")
                      {
                         $ps1="selected = 'selected'";
                      }
                      else
                      {
                          $ds1="selected = 'selected'";
                      }

                      if($status=="active")
                      {
                          $ssl="selected = 'selected'";
                      }
                      else
                      {
                         $nssl="selected = 'selected'";
                      }

       //modified by SMA on 22-Feb-06
                       //finds status of impression approval
                       if($impression_approval=="automatic")
                       {
                          $impapp_automatic="checked = 'checked'";
                       }
                       else
                       {
                            $impapp_mannual="checked = 'checked'";
                       }

                       //finds status of impression mail sending
                       if($impression_mail=="automatic")
                       {
                          $impemail_automatic="checked = 'checked'";
                       }
                       else
                       {
                            $impemail_mannual="checked = 'checked'";
                       }

                       //finds if geo targeting checked for impression
                       if($geo_impression=="1")
                       {
                           $geo_imp = "checked = 'checked'";
                       }
                       else
                       {
                            $geo_imp = "";
                       }
       //End Modify


                $msg=$_GET['msg'];


       echo "<p align='center' > <span class='textred'>$msg</span></p>";

?>
<!--  Modify 22-Feb-06  -->
    <script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.f1.txt_completion_date,Date);
        }

    </script>

    <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
    </iframe>
    <br/>

<form method="post" action="" name="f1" id="f1">
<input type="hidden" value="<?=$vip_pgm?>" name="vip_pgm" />
<table border="0" cellpadding="0" cellspacing="0" width="70%" class="tablebdr" align="center">
    <tr>
      <td width="100%" colspan="3" height="19" class="tdhead" align="center"><b>
      <?=$lpgm_ProgramEditor?></b></td>
    </tr>
    <tr>
      <td width="1%" height="161">&nbsp;</td>
      <td width="98%" align="center" valign="top">
      &nbsp;<table border="0" cellpadding="0" cellspacing="0" width="72%" class="tablebdr">
        <tr>
          <td height="17" colspan="5" > </td>
        </tr>
        <tr>
          <td width="1%" height="39">&nbsp;</td>
          <td width="30%" height="39"  align="left">
         <?=$lpgm_ProgramURL?> </td>
          <td width="58%" height="39" align="left">
          <input type="text" name="url" size="48" id="url" value="<?=$url?>" /></td>
          <td width="10%" height="39">
          <!--input type="button"  name="B3" onclick="window.open(f1.url.value)" value="<?=$lpgm_Test?>" /--></td>
                    <td width="1%" height="39">&nbsp;</td>
        </tr>
        <tr>
          <td width="1%" height="19">&nbsp;</td>
          <td width="30%" height="19"  align="left" valign="top">
          <?=$lpgm_Description?></td>
          <td height="19" colspan="2" align="left" >
          <textarea rows="15" name="description" cols="47"><?=stripslashes($_SESSION['DES'])?><?=stripslashes($description)?></textarea></td>
          <td width="1%" height="19">&nbsp;</td>
        </tr>

        <tr>
          <td height="1" colspan="5" >&nbsp;</td>
        </tr>
      </table>
      </td>
      <td width="1%" align="center" height="161">&nbsp;</td>
    </tr>

    <tr>
      <td width="1%" align="center" height="348">&nbsp;</td>
      <td width="98%" align="center" valign="top">
      &nbsp;<table border="0" cellpadding="0" cellspacing="0" width="95%" class="tablebdr">
        <tr>
          <td colspan="10" height="19" align="center" class="tdhead"><b><?=$lpgm_Commissions?></b></td>
        </tr>
        <tr>
          <td colspan="10" height="19" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td width="5" height="19" align="center" class="tdhead">&nbsp;</td>
          <td width="58" height="19" align="left" class="tdhead"><?=$lpgm_Type?></td>
          <td width="174" align="left" class="tdhead"><?=$lpgm_Commissions?></td>
          <td width="103" height="19" align="center" class="tdhead"><?=$lpgm_Geo_Targeting?></td>
          <td height="19" colspan="3" align="center" class="tdhead"><?=$lpgm_Approval?></td>
          <td height="19" align="center" class="tdhead" colspan="3"><?=$lpgm_EmailSettings?></td>
        </tr>

        <!-- Modified by SMA 22-FEb-06  -->
        <tr>
          <td width="5" height="21" align="center" rowspan="2" >&nbsp;</td>
          <td width="58" height="21" align="left" rowspan="2" ><?=$lpgm_Impression?></td> 
          <td width="174" align="left" rowspan="2" ><input type="text" name="impression" size="8" value="<?=$impression_rate?>" />
              <?=$currSymbol?>&nbsp;<?=$lpgm_perImpression?>&nbsp;<input type="text" name="impressionunit" size="4" value="<? if($impression_unit!=''){echo $impression_unit;}else{ echo '1000';}?>" /></td>
          <td width="103" height="21" align="center" rowspan="2" ><input name="chk_geo_impression" type="checkbox" <?=$geo_imp?> /></td>
          <td width="28" height="7" align="right" >&nbsp;</td>
          <td width="79" align="left" ><?=$lpgm_Automatic?></td>
          <td width="46" height="18" align="left" >
            <input type="radio" value="automatic" name="impressionr" <?=$impapp_automatic?> /></td>
          <td width="60" height="19" align="right" ><?=$lpgm_Automatic?></td>
          <td width="36" align="center" >&nbsp;</td>
          <td width="49" height="19" align="left" >
            <input type="radio" value="automatic" name="impressione" <?=$impemail_automatic?> /></td>
        </tr> 
        <tr>
          <td width="28" height="15" align="right" >&nbsp;</td>
          <td width="79" align="left" ><?=$lpgm_Manually?></td>
          <td width="46" height="20" align="left" >
            <input type="radio" name="impressionr" value="manual" <?=$impapp_mannual?> /></td>
          <td width="60" height="21" align="right" ><?=$lpgm_Manually?></td>
          <td width="36" align="center">&nbsp;</td>
          <td width="49" height="21" align="left" >
            <input type="radio" value="manual" name="impressione" <?=$impemail_mannual?>  /></td>
        </tr>
        <!-- End Modify   -->

        <tr>
          <td width="5" height="21" align="center" rowspan="2" class="grid1">&nbsp;</td>
          <td width="58" height="21" align="left" rowspan="2" class="grid1"><?=$lpgm_Click?></td>
          <td width="174" align="left" rowspan="2" class="grid1"><input type="text" name="click" size="8" value="<?=$click?>" />
            <?=$currSymbol?></td>
          <td width="103" height="21" align="center" rowspan="2" class="grid1"><input name="chk_geo_click" type="checkbox" <?=$geo_click_checked?> /></td>
          <td width="28" height="7" align="right" class="grid1">&nbsp;</td>
          <td width="79" align="left" class="grid1"><?=$lpgm_Automatic?></td>
          <td width="46" height="18" align="left" class="grid1">
          <input type="radio" value="automatic" name="clickr" <?=$cr?> /></td>
          <td width="60" height="19" align="right" class="grid1"><?=$lpgm_Automatic?></td>
          <td width="36" align="center" class="grid1">&nbsp;</td>
          <td width="49" height="19" align="left" class="grid1">
          <input type="radio" value="automatic" name="clicke" <?=$ce?> /></td>
        </tr>
        <tr>
          <td width="28" height="15" align="right" class="grid1">&nbsp;</td>
          <td width="79" align="left" class="grid1"><?=$lpgm_Manually?></td>
          <td width="46" height="20" align="left" class="grid1">
          <input type="radio" name="clickr" value="manual" <?=$ncr?> /></td>
          <td width="60" height="21" align="right" class="grid1"><?=$lpgm_Manually?></td>
          <td width="36" align="center" class="grid1">&nbsp;</td>
          <td width="49" height="21" align="left" class="grid1">
          <input type="radio" value="manual" name="clicke" <?=$nce?>  /></td>
        </tr>
        <tr>
          <td width="5" height="22" align="center" rowspan="2">&nbsp;</td>
          <td width="58" height="22" align="left" rowspan="2"><?=$lpgm_Lead?></td>
          <td width="174" align="left" rowspan="2"><input type="text" name="lead" size="8" value="<?=$lead?>" />
            <?=$currSymbol?></td>
          <td width="103" height="22" align="center" rowspan="2"><span class="grid1">
            <input name="chk_geo_lead" type="checkbox"  <?=$geo_lead_checked?> />
          </span> </td>
          <td width="28" height="8" align="right">&nbsp;</td>
          <td width="79" align="left"><?=$lpgm_Automatic?></td>
          <td width="46" height="8" align="left">
          <input type="radio" name="leadr" value="automatic" <?=$lr?> /></td>
          <td width="60" height="19" align="right"><?=$lpgm_Automatic?></td>
          <td width="36" align="center">&nbsp;</td>
          <td width="49" height="19" align="left">
          <input type="radio" value="automatic" name="leade" <?=$le?> /></td>
        </tr>
        <tr>
          <td width="28" height="14" align="right">&nbsp;</td>
          <td width="79" align="left"><?=$lpgm_Manually?></td>
          <td width="46" height="14" align="left">
          <input type="radio" name="leadr" value="manual" <?=$nlr?> /></td>
          <td width="60" height="21" align="right"><?=$lpgm_Manually?></td>
          <td width="36" align="center">&nbsp;</td>
          <td width="49" height="21" align="left">
          <input type="radio" value="manual" name="leade" <?=$nle?>  /></td>
        </tr>
        <tr>
          <td width="5" height="26" align="center" rowspan="2" class="grid1">&nbsp;</td>
          <td width="58" height="26" align="left" rowspan="2" class="grid1"><?=$lpgm_Sale?></td>
          <td width="174" align="left" rowspan="2" class="grid1"><input type="text" name="sale" size="8" value="<?=$sale?>" />
            <select size="1" name="saletype1" >
              <option value="$" <?=$ds1?> >
              <?=$currSymbol?>
              </option>
              <option value="%" <?=$ps1?> >%</option>
            </select></td>
          <td width="103" height="26" align="center" rowspan="2" class="grid1"><input name="chk_geo_sale" type="checkbox" <?=$geo_sale_checked?> /></td>
          <td width="28" height="6" align="right" class="grid1">&nbsp;</td>
          <td width="79" align="left" class="grid1"><?=$lpgm_Automatic?></td>
          <td width="46" height="6" align="left" class="grid1">
          <input type="radio" name="saler" value="automatic" <?=$sr?> /></td>
          <td width="60" height="19" align="right" class="grid1"><?=$lpgm_Automatic?></td>
          <td width="36" align="center" class="grid1">&nbsp;</td>
          <td width="49" height="19" align="left" class="grid1">
          <input type="radio" value="automatic" name="salee" <?=$se?> /></td>
        </tr>
        <tr>
          <td width="28" height="19" align="right" class="grid1">&nbsp;</td>
          <td width="79" align="left" class="grid1"><?=$lpgm_Manually?></td>
          <td width="46" height="19" align="left" class="grid1">
          <input type="radio" name="saler" value="manual" <?=$nsr?> /></td>
          <td width="60" height="25" align="right" class="grid1"><?=$lpgm_Manually?></td>
          <td width="36" align="center" class="grid1">&nbsp;</td>
          <td width="49" height="25" align="left" class="grid1">
          <input type="radio" value="manual" name="salee" <?=$nse?>  /></td>
        </tr>
		
	<!-- Added by SMA on 20-JUNE-2006 for recurring comission  -->
		<? $recur_sel = "selected = 'selected'"; 
		   	if($recur_period == '') $recur_period = 1;
		?>
        <tr>
          <td height="20" align="center" colspan="10">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="10" width="638">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="5" height="26" align="center" >&nbsp;</td>
						<td align="left">&nbsp;<b><?=$recur_commission_head?></b></td>
					</tr>
					<tr>
						<td width="5" height="26" align="center" >&nbsp;</td>
						<td align="left">&nbsp;
							<input type="checkbox" <? if($recur_sale) echo "checked='checked'"; ?> name="chk_recursale" />&nbsp;<?=$recur_sale_head?>
							<input type="text" name="txt_recurpercent" value="<?=$recur_percentage?>" style="width:40px;" />&nbsp;<?=$recur_percent_month_head?>&nbsp;
							<input type="text" name="cmb_recurperiod" value="<?=$recur_period?>"  onKeyPress="CheckNumeric();" style="width:40px;" />&nbsp;<?=$recur_months_head?>
<!--
							<select name="cmb_recurperiod" >
								<option value="1" <? if($recur_period=='1') echo $recur_sel; ?>><?=$recur_period_1?></option>
								<option value="2" <? if($recur_period=='2') echo $recur_sel; ?>><?=$recur_period_2?></option>
								<option value="3" <? if($recur_period=='3') echo $recur_sel; ?>><?=$recur_period_3?></option>
								<option value="4" <? if($recur_period=='4') echo $recur_sel; ?>><?=$recur_period_4?></option>
								<option value="5" <? if($recur_period=='5') echo $recur_sel; ?>><?=$recur_period_5?></option>
								<option value="6" <? if($recur_period=='6') echo $recur_sel; ?>><?=$recur_period_6?></option>
								<option value="7" <? if($recur_period=='7') echo $recur_sel; ?>><?=$recur_period_7?></option>
								<option value="8" <? if($recur_period=='8') echo $recur_sel; ?>><?=$recur_period_8?></option>
								<option value="9" <? if($recur_period=='9') echo $recur_sel; ?>><?=$recur_period_9?></option>
								<option value="10" <? if($recur_period=='10') echo $recur_sel; ?>><?=$recur_period_10?></option>
								<option value="11" <? if($recur_period=='11') echo $recur_sel; ?>><?=$recur_period_11?></option>
								<option value="12" <? if($recur_period=='12') echo $recur_sel; ?>><?=$recur_period_12?></option>
							</select>
-->							
						</td>
					</tr>
				</table>
			</td>
		</tr>	
	<!-- End Added by SMA on 20-JUNE-2006 -->
		
        <tr>
          <td height="20" align="center" colspan="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="grid1" colspan="2" >&nbsp;</td>
          <td height="19" align="left" class="grid1" colspan="6">

          <input type="checkbox" name="mailaffil" value="mailaffil" <?=$maf?> />&nbsp;&nbsp;&nbsp;
          <?= $lpgm_Sendemailtoaffiliatewhentransactionappears ?> </td>
          <td width="36" align="center" class="grid1">&nbsp;</td>
          <td width="49" height="19" align="center" class="grid1">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="grid1" colspan="2" >
          </td>
          <td height="19" align="left" class="grid1" colspan="6">

            <input type="checkbox" name="mailme" value="mailme" <?=$mme?> />&nbsp;&nbsp;&nbsp;
          <?=$lpgm_Sendemailtomewhentransactionappears?>.</td>
          <td width="36" align="center" class="grid1">&nbsp;</td>
          <td width="49" height="19" align="center" class="grid1">&nbsp;</td>
        </tr>
        <tr>
          <td height="20" align="center" colspan="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="20" align="right" colspan="4" class="grid1">

            <?= $lpgm_AffiliateApproval?>&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td height="20" align="left" colspan="6" class="grid1">&nbsp;<input type="radio" name="affiliater" value="automatic" <?=$aa?> />  <?= $lpgm_Automatic?>&nbsp;
          <input type="radio" name="affiliater" value="manual" <?=$naa?> />  <?=$lpgm_Manually?></td>
        </tr>
        <tr>
          <td height="30" align="right" colspan="4" class="grid1">
            <?= $lpgm_IPBlocking?>&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td height="20" align="left" colspan="6" class="grid1">
         &nbsp;<input name="ip" size="6" value='<?=$ip?>' />&nbsp;
            <?= $lpgm_minutes ?> </td>
        </tr>
        <!-- added by jin on 6th Jul -->
        <?
                //selecting countries and their ips
            $selq = "SELECT DISTINCT `country_name` FROM `partners_countryFlag` ORDER BY `country_name`";
            $res = mysqli_query($con,$selq);
        ?>
        <tr>
          <td height="30" align="right" colspan="4" class="grid1" valign="top">
          <?= $lpgm_OfferAvailable?>&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td height="20" align="left" colspan="6" class="grid1">
          &nbsp;<select name="sel_countries[]" multiple size="5"  style="font-size:11px" class="selectMulti">
                                  <? while($row = mysqli_fetch_object($res)){?>
                                    <option value="<?=$row->country_name?>" <?=(in_array($row->country_name,$res_countryarr) ? " selected='selected'" : "")?>><?=$row->country_name?></option>
                    <? }?>
                  </select>
          </td>
        </tr>
         <tr>
          <td height="30" align="right" colspan="4" class="grid1">
          <?= $lpgm_Cookie?>&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td height="20" align="left" colspan="6" class="grid1">
          &nbsp;<input name="cookieTime" size="6" value="<?=$cookie?>" />&nbsp;

          <select size="1" name="cookiePeriod" >
                                     <option value="minute" <?=($cookiePeriod=="minute"?"selected='selected'":"")?>><?=$common_min?></option>
                <option value="hour"   <?=($cookiePeriod=="hour"?"selected='selected'":"")?>><?=$common_hr?></option>
                <option value="day"    <?=($cookiePeriod=="day"?"selected='selected'":"")?>><?=$common_day?></option>
                <option value="year"   <?=($cookiePeriod=="year"?"selected='selected'":"")?>><?=$common_year?></option>
                    </select>

         </td>
        </tr>
        <tr>
          <td colspan="10" >&nbsp;</td>
        </tr>
		
        <tr>
          <td height="20" align="center" colspan="10" >
          <input name="currValue" type="hidden" value="<?=$currValue?>" />
          <input type="button" onclick="CheckRecurringPeriod('<?=$mode?>','<?=$pgmid?>');"   name="B1" value=" <?= $lpgm_Submit?>" />
                  <input type="reset"  name="B2"  value=" <?= $lpgm_Reset?>" /></td>
        </tr>
        <tr>
          <td colspan="10" >&nbsp;</td>
        </tr>
		
      </table>
      </td>
      <td width="1%" align="center" height="348">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" colspan="3" height="19" >
     </td>
    </tr>
  </table>


</form>
<br />
<script language="javascript" >
    /*--------------------------------------------------------------------------
    Description   :- function to allow only Numeric values in a textbox.
        Called in the onKeyPress event.
    Programmer    :- SMA
    Last Modified :- 18/MAY/2006
    --------------------------------------------------------------------------*/
        function CheckNumeric()
        {	 
                if((window.event.keyCode>57 || window.event.keyCode<48) && (window.event.keyCode!=8))
                {
                        alert('<?=$js_numeric_value?>');
                        window.event.returnValue = null;
                        return false;
                }
                return true;
        }

    /*--------------------------------------------------------------------------
    Description   :- function to validate the Recurring Period.
    Programmer    :- SMA
    Last Modified :- 27/JUNE/2006
    --------------------------------------------------------------------------*/
		function CheckRecurringPeriod(mode,pgmid)
		{
			if(document.f1.chk_recursale.checked == true)
			{
				if(document.f1.cmb_recurperiod.value == '')
				{
					alert('<?=$err_enterRecurperiod?>');
					document.f1.cmb_recurperiod.focus();
					return false;
				}
				if(document.f1.cmb_recurperiod.value == '0')
				{
					alert('<?=$err_validRecurPeriod?>');
					document.f1.cmb_recurperiod.focus();
					return false;
				}
			}
			document.f1.action="pgmedit_validate.php?mode="+mode+"&id="+pgmid;
			document.f1.submit(); 
		}
</script>
