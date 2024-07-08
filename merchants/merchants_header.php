<?php /*?><?php
//if($currSymbol=="&pound") $currSymbol = "&pound;"
?>
<!-- ImageReady Slices (admin.psd) -->
<form name="langform" action="" method="post">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="216"><img src="images/admin_01.gif" width="216" height="69" alt=""/></td>
            <td height="69" align="right" valign="middle">
              <table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                  <td>
<table width="300" border="0" align="right" cellpadding="0" cellspacing="0" class="toptablebdr">
<tr>
     			<td  width="100%" align="center" valign="bottom" colspan="3" bgcolor="#8D8D8D"><div align="center" class="style2"><a href="index.php?Act=paymentlist" class="Ta"><?=$lang_PaymentHistory?></a></div></td>
</tr>
 <tr>
     <td  width="35%" align="left" valign="bottom"   ><div align="left" class="style2"><?=$lang_Merchant?></div>       </td>
     <td  width="65%" align="left"  valign="bottom"  ><span class="style3">:<?=$_SESSION['MERCHANTNAME']?></span></td>
     </tr>
             <tr>
     			<td  width="35%" align="left" valign="bottom"><div align="left" class="style2" ><?=$lang_Balance?></div>     			  </td>
     			<td  width="65%" align="left" valign="bottom" class="style3" >:<?=$basecurrSymbol?><?=round($_SESSION['MERCHANTBALANCE'],2)?><? if($currValue!= $default_currency_caption) { echo "(".round($currBalance,2)." ".$currSymbol.")";} ?> </td>
                </tr>


<tr>
     			<td  width="100%" align="center" valign="bottom" colspan="3" bgcolor="#8D8D8D"><div align="center" class="style2"><a href="index.php?Act=add_money" class="Ta"><?=$lang_AddMoneyToAccount?></a></div></td>
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
		case "home":
        case "waitrotator":
        case "waitingpgm":
        case "listaffiliate":
        case "GetCode":
			$header_bg1 = "header_bg_white";
			break;

		case "accounts":
			$header_bg2 = "header_bg_white";
			break;

		case "programs":
        case "programedit":
        case "uploadProducts":
        case "waitingaff":
		case "newprogram":
		case "add_text":
		case "add_textnew":
		case "add_html":
		case "add_flash":
		case "add_banner":
		case "add_popup":
			$header_bg3 = "header_bg_white";
			break;

		case "affiliates":
			$header_bg4 = "header_bg_white";
			break;

		case "emails":
        case "paidmail":
			$header_bg5 = "header_bg_white";
			break;

		//for all these 5 options highlight same menu
		case "daily":
		case "forperiod":
		case "AffiliateReport":
		case "ProgramReport":
		case "LinkReport":
        case "transaction_merchant":
        case "revenues":
        case "ProductReport":
			$header_bg6 = "header_bg_white";
			break;

		case "group":
        case "add_group":
			$header_bg7 = "header_bg_white";
			break;

		case "merchants":
			$header_bg8 = "header_bg_white";
			break;
	}
?>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>

            <td width="10" height="27">&nbsp;</td>
            <td width="85" height="27" class="<?=$header_bg1?>"><div align="center"><a href="index.php?Act=home"><?=$lang_Home?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"  class="<?=$header_bg2?>"     ><div align="center"><a href="index.php?Act=accounts"><?=$lang_Accounts?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"     class="<?=$header_bg3?>" ><div align="center"><a href="index.php?Act=programs"><?=$lang_Programs?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"     class="<?=$header_bg4?>" ><div align="center"><a href="index.php?Act=affiliates&amp;status=all"><?=$lang_Affiliates?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"     class="<?=$header_bg5?>" ><div align="center"><a href="index.php?Act=emails"><?=$lang_Emails?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"     class="<?=$header_bg6?>" ><div align="center"><a href="index.php?Act=daily"><?=$lang_Reports?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"     class="<?=$header_bg7?>" ><div align="center"><a href="index.php?Act=group"><?=$lang_Groups?></a></div></td>
            <td width="5"><div align="center"></div></td>
            <td width="85"     class="<?=$header_bg8?>" ><div align="center"><a href="../merchant_quit.php"><?=$lang_Quit?></a></div></td>
          </tr>
        </table></td>
	</tr>
	<tr>
	  <td align="center" valign="top" class ="tdheaderin">			<br/>
		  <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="middle"><div align="right">            </div></td>
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
			if($language==$rowlang->languages_id) $langsel = "selected";

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
<nav class="navbar navbar-expand-lg ">
	<div class="container-fluid">
		<div class="navbar-wrapper">
			<div class="navbar-minimize">
				<button id="minimizeSidebar" class="btn btn-warning btn-fill btn-round btn-icon d-none d-lg-block">
					<i class="fa fa-ellipsis-v visible-on-sidebar-regular"></i>
					<i class="fa fa-navicon visible-on-sidebar-mini"></i>
				</button>
			</div>
			<a class="navbar-brand" href="#"> Merchant Area </a>
		</div>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-bar burger-lines"></span>
			<span class="navbar-toggler-bar burger-lines"></span>
			<span class="navbar-toggler-bar burger-lines"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end">
			<ul class="nav navbar-nav mr-auto">
			</ul>
			<ul class="navbar-nav">
				<!--<li class="dropdown nav-item">
					<a href="dashboard.html#" class="dropdown-toggle nav-link" data-toggle="dropdown">
						<i class="nc-icon nc-bell-55"></i>
						<span class="notification">0</span>
						<span class="d-lg-none">Notification</span>
					</a>
					<ul class="dropdown-menu">
						<a class="dropdown-item" href="dashboard.html#">Notification 1</a>
						<a class="dropdown-item" href="dashboard.html#">Notification 2</a>
						<a class="dropdown-item" href="dashboard.html#">Notification 3</a>
						<a class="dropdown-item" href="dashboard.html#">Notification 4</a>
						<a class="dropdown-item" href="dashboard.html#">Notification 5</a>
					</ul>
				</li>-->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="nc-icon nc-bullet-list-67"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="index.php?Act=accounts">
							<i class="nc-icon nc-settings-90"></i> Settings
						</a>
						<div class="divider"></div>
						<a href="../merchant_quit.php" class="dropdown-item text-danger">
							<i class="nc-icon nc-button-power"></i> Log out
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>