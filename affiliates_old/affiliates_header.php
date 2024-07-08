<?php /*?><form name="langform" action="" method="post">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="216"><img src="images/admin_01.gif" width="216" height="69" alt="" /></td>
            <td height="69" align="right" valign="middle">
<table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                  <td>
<table width="300" border="0" align="right" cellpadding="0" cellspacing="0" class="toptablebdr">
  <tr>
     			<td  width="100%" align="left" valign="bottom" colspan="2" bgcolor="#8D8D8D"><div align="center" class="style2"><a href="index.php?Act=paymentlist" class="Ta"><?=$affiliate_history?></a></div></td>
             </tr>
  <tr>
     <td  width="35%" align="left" valign="bottom"   ><div align="left" class="style2"><?=$affiliate_name?></div>       </td>
     <td  width="65%" align="left"  valign="bottom"  ><span class="style3">:<?=$_SESSION['AFFILIATENAME']?></span></td>
     </tr>

             <tr>
     			<td  width="35%" align="left" valign="bottom"><div align="left" class="style2" ><?=$affiliate_amount?></div>     			  </td>
     			<td  width="65%" align="left" valign="bottom" class="style3" >:<?=$currSymbol?>&nbsp;<?=round($_SESSION['AFFILIATEBALANCE'],2)?></td>
                </tr>

     <tr>
     			<td  width="100%" align="left" valign="bottom" colspan="2" bgcolor="#8D8D8D"><div align="center" class="style2"><a href="index.php?Act=request" class="Ta" ><?=$affiliate_request?></a></div></td>
             </tr>

     </table>


                  </td>
                </tr>
              </table></td>
          </tr>
        </table></td>
	</tr>
	<tr>
      <td height="27" bgcolor="#999999">
<?php
	//Added By DPT on May/26/05 to hightlight the selected menu item
	$header_bg1  = $header_bg2 = $header_bg3 = $header_bg4 = $header_bg5 = $header_bg6 = $header_bg7 = $header_bg8 = "header_bg_yellow";
	switch($Act)
	{
		case "Home":
			$header_bg1 = "header_bg_white";
			break;

		case "Account":
			$header_bg2 = "header_bg_white";
			break;

		case "Affiliates":
        case "cat":
        case "MyAffiliates":
			$header_bg3 = "header_bg_white";
			break;

		case "rotator":
			$header_bg4 = "header_bg_white";
			break;

		case "Getlinks":
        case "getpopup":
        case "gethtml":
        case "getflash":
        case "getbanner":
        case "gettext":
			$header_bg5 = "header_bg_white";
			break;

		//for all these 5 options highlight same menu
		case "daily":
		case "forperiod":
		case "AffiliateReport":
		case "ProgramReport":
		case "LinkReport":
		case "TransReport":
			$header_bg6 = "header_bg_white";
			break;

		case "merchants":
			$header_bg7 = "header_bg_white";
			break;
	}
?>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="10" height="27">&nbsp;</td>
            <td width="85" height="27"  class="<?=$header_bg1?>"><div align="center"><a href="index.php?Act=Home"><?=$menu_home?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"  class="<?=$header_bg2?>" ><div align="center"><a href="index.php?Act=Account"><?=$menu_accounts?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"  class="<?=$header_bg3?>" ><div align="center"><a href="index.php?Act=Affiliates&amp;joinstatus=All"><?=$menu_programs?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"  class="<?=$header_bg4?>" ><div align="center"><a href="index.php?Act=rotator"><?=$menu_rotator?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"  class="<?=$header_bg5?>" ><div align="center"><a href="index.php?Act=Getlinks"><?=$menu_getlinks?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"  class="<?=$header_bg6?>" ><div align="center"><a href="index.php?Act=daily"><?=$menu_reports?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <!--
            <td width="85"     background=<?= ($Act=="group" ? "images/white.gif":"images/yellow.gif" )   ?> ><div align="center"><a href="index.php?Act=group">Groups</a></div></td>
            <td width="5"><div align="center"></div></td>
             -->
            <td width="85"  class="<?=$header_bg7?>" ><div align="center"><a href="../affiliate_quit.php"><?=$menu_quit?></a></div></td>
          </tr>
        </table></td>
	</tr>
	<tr>
	  <td align="center" valign="top" class ="tdheaderin">			<br/>
		  <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="middle"></td>
          </tr>
          <tr>
            <td height="20" valign="middle" bgcolor="#FFCC66" align="right">
    <?
   // include_once 'language_select.php';
   ?>
           <!--Languages-->
        <?
		//get all languages
		$sqllang = "select * from partners_languages where languages_status = 'active'";
		$reslang = mysqli_query($con,$sqllang);
        if(mysqli_num_rows($reslang)>0)
        {
		?>

        <b>Language :</b> <select name="languageid" onchange="javascript:langform.submit();">

          <?
		while($rowlang = mysqli_fetch_object($reslang))
		{
			$langsel = "";
			if($language==$rowlang->languages_id) $langsel = "selected = 'selected'";
         ?>

          <option value="<?=$rowlang->languages_id?>" <?=$langsel?>><?=stripslashes($rowlang->languages_name)?>
          </option>
         <?
		}
    	?>
        </select>
        <?
		}
        ?>
        <!--End of Languages-->
		</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
</form><?php */?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="96%" height="85" valign="middle">
		<table width="430" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="6"><img src="images/payment-box-left.jpg" width="6" height="75" /></td>
            <td class="payment-box-contentbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="36%" align="center" class="heading1">
				<a href="index.php?Act=paymentlist" class="link-02"><?=$affiliate_history?></a></td>
                <td width="64%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="payment-inner-box">
					<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="toptablebdr">
                      <tr>
                        <td  width="39%" height="20" align="center" valign="bottom"> <?=$affiliate_name?></td>
                        <td  width="61%" align="left"  valign="bottom"> : <?=$_SESSION['AFFILIATENAME']?>  </td>
                      </tr>
                      <tr>
                        <td  width="39%" align="center" valign="bottom"><?=$affiliate_amount?></td>
                        <td  width="61%" align="left" valign="bottom" class="style3" >
						:<?=$currSymbol?>&nbsp;<?=round($_SESSION['AFFILIATEBALANCE'],2)?></td>
                      </tr>
                      <tr>
                        <td align="center" height="28" colspan="3">
						<a href="index.php?Act=request" class="link-01" ><?=$affiliate_request?></a></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            <td width="6" align="right"><img src="images/payment-box-right.jpg" width="6" height="75" /></td>
          </tr>
        </table>
		</td>
        <td width="2%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" height="3"></td>
      </tr>
	  <tr><td colspan="3"><?php include"links.php";?> </td></tr>

    </table>