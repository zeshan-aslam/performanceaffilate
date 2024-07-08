<?
//Last Modified By DPT on May/25/05 to fix issues with HTML
 $Err		=$_GET['Err'];
 $Action	=$_GET['Action'];

 if ($Action=="affiliate")
    $aff="selected = 'selected' ";
 else
     $mer="selected = 'selected' ";
?>

<table width="775" height="100%" border="0" align="center" class="outtbl" cellpadding="0" cellspacing="0">
  <tr>
    <td width="215" align="left" valign="top" class="lftnavbg">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="215" height="26" align="left" valign="top" class="lanbg"><table width="175"  border="0" cellspacing="0">
            <tr>
              <td width="215" align="right" valign="middle">
              <!-- Language: <select name="select2" class="style3">
                <option>English</option>
              </select>
			  -->
			  <? include_once "language_select.php"; ?>
			  </td>
            </tr>
          </table></td>
        </tr>
      </table>

        <table width="190"  border="0" cellspacing="0" cellpadding="15">
          <tr>
            <td width="215">
			<form name="login" action="login_validate.php" method="post">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="1" colspan="2" bgcolor="#7D7D7D"></td>
                </tr>
                <tr>
                  <td height="25" colspan="2" ><div align="center"><img src="images/login.gif" width="111" height="17" alt="" /></div></td>
                </tr>
                <tr>
                  <td height="1" colspan="2" bgcolor="#7D7D7D"></td>
                </tr>
                <tr>
                  <td height="5" colspan="2" ><span class="style6">
                    <?=$Err?>
                  </span></td>
                </tr>
                <tr>
                  <td height="15" colspan="2" class="style5"><?=$lang_Choose?>:</td>
                </tr>
                <tr>
                  <td height="20" colspan="2" ><select name="flag" class="style3">
                <option <?=$mer?> value="merchant"><?=$lang_Merchants?></option>
                <option <?=$aff?> value="affiliate"><?=$lang_Affiliates?></option>
            </select></td>
                </tr>
                <tr>
                  <td height="15" colspan="2" ><span class="style5"><?=$lang_Username?>:</span></td>
                </tr>
                <tr>
                  <td height="20" colspan="2" ><input name="login" type="text" class="style3" value="" size="25"></td>
                </tr>
                <tr>
                  <td height="15" colspan="2" class="style5"><?=$lang_Password?>:</td>
                </tr>
                <tr>
                  <td width="60%"><input  name="password" type="password" class="style3" value="" size="15"></td>
                  <td width="60" height="20" class="enter"><div class="sbt" onclick="document.login.submit()" >&nbsp;&nbsp;&nbsp;&nbsp;Enter</div></td>
                </tr>
                <tr>
                  <td height="15" colspan="2" ><a href="#" onclick="viewLink()"><?=$lang_Forgot?> ? </a></td>
                </tr>
                <tr>
                  <td height="5" colspan="2" ></td>
                </tr>
                <tr>
                  <td height="1" colspan="2" bgcolor="#7D7D7D"></td>
                </tr>
                <tr>
                  <td height="10" colspan="2" ></td>
                </tr>
                <tr>
                  <td height="10" colspan="2" ><div align="justify"><?=$lang_iPartnersmanager?></div></td>
                </tr>
                <tr>
                  <td height="10" colspan="2" ></td>
                </tr>
                <tr>
                  <td height="1" colspan="2" bgcolor="#797979"></td>
                </tr>
            </table></form></td>
          </tr>
    </table></td>
    <td height="100%" rowspan="2" align="left" valign="top"> <form method="post" name="reg" action="reg_validate.php?mode=insert">     <TABLE WIDTH=95% border="0" align="left" cellpadding="0" cellspacing="0">
        <TR bgcolor="#FFA200">
          <TD width="5%" height="26" align="left" valign="top"> <IMG SRC="images/innerbox2_01.gif" width="24" height="26" ALT=""/> </TD>
          <TD width="95%" align="center" valign="middle"> <div align="center" class="style4"><?=$MerchantRegistration?></div></TD>
        </TR>
        <TR>
          <TD height="2" colspan="2" class="ltrtbrdr1">
		  <table width="100%" height="262" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#111111" class="tablewbdr" id="AutoNumber1" style="border-collapse: collapse">
            <tr>
              <td colspan="6" height="19" class="textred" align="center">
                <span class="style6"><?=$msg?> &nbsp;</span></td>
            </tr>
            <tr>
              <td width="1%" height="26">&nbsp;</td>
              <td width="14%" height="26"><?=$lang_FirstName?></td>
              <td width="35%" height="26">
                <input type="text" name="firstnametxt" size="20" value="<?=$firstname?>" ></td>
              <td width="18%" height="26"><?=$lang_Category?></td>
              <td width="31%" height="26">
                <select size="1" name="categorylst">
                  <option selected value="nill"><?=$selectacategory?></option>
                  <?php
    $sql    = "select * from partners_category";
    $result = mysql_query($sql);
?>
                  <?php
    while($row=mysql_fetch_object($result))
    {
    if($category==$row->cat_name)
    {
?>
                  <OPTION value="<?=$row->cat_name?>" selected >
                  <?=$row->cat_name?>
                  </OPTION>
                  <?php
        }
    else{
?>
                  <OPTION value="<?=$row->cat_name?>" >
                  <?=$row->cat_name?>
                  </OPTION>
                  <?php
             }
    }
?>
              </select></td>
              <td width="1%" height="26">&nbsp;</td>
            </tr>
            <tr>
              <td width="1%" height="29">&nbsp;</td>
              <td width="14%" height="29"><?=$lang_LastName?></td>
              <td width="35%" height="29">
                <input type="text" name="lastnametxt" size="20" value="<?=$lastname?>"></td>
              <td width="18%" height="29"><?=$lang_Phone?></td>
              <td height="29"><input type="text" name="phonetxt" size="20" value="<?=$phone?>"></td>
              <td width="1%" height="29">&nbsp;</td>
            </tr>
            <tr>
              <td width="1%" height="31">&nbsp;</td>
              <td width="14%" height="31"><?=$lang_Company?></td>
              <td width="35%" height="31">
                <input type="text" name="companytxt" size="20" value="<?=$company ?>"></td>
              <td width="18%" height="31"><?=$lang_Fax?></td>
              <td height="31"><input type="text" name="faxtxt" size="20" value="<?=$fax?>"></td>
              <td width="1%" height="31">&nbsp;</td>
            </tr>
            <tr>
              <td width="1%" height="28">&nbsp;</td>
              <td width="14%" height="28"><?=$lang_URL?></td>
              <td width="35%" height="28"><input type="text" name="urltxt" size="20" value="<?=$url?>" ></td>
              <td width="18%" height="28"><?=$lang_EmailId?></td>
              <td height="28" ><input type="text" name="emailidtxt" size="20" value="<?=$mailid?>" >
</td>
              <td width="1%" height="28" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td width="1%" height="20">&nbsp;</td>
              <td width="14%" height="42" rowspan="2"><?=$lang_Address?></td>
              <td width="35%" height="42" rowspan="2">
                <textarea rows="2" name="addresstxt" cols="20"><?=$address ?>
          </textarea></td>
              <td width="18%" height="42" rowspan="2"><?=$lang_Type?> </td>
              <td height="42" rowspan="2"><select size="1" name="typelst">
                  <?
      if (trim($type)=="nill") {


       $nill="selected";

       }


       if (trim($type)==$lang_Advance) {


       $adv="selected";

       }

       if (trim($type)==$lang_Normal) {


       $nor="selected";

       }


       ?>
                  <option value="nill"><?=$selectatype?></option>
                  <option value="advance" <?=$adv?>><?=$lang_Advance?></option>
                  <option value="normal" <?=$nor?>><?=$lang_Normal?></option>
              </select></td>
              <td width="1%" height="20">&nbsp;</td>
            </tr>
            <tr>
              <td width="1%" height="22">&nbsp;</td>
              <td width="1%" height="22">&nbsp;</td>
            </tr>
            <tr>
              <td width="1%" height="28">&nbsp;</td>
              <td width="14%" height="28"><?=$lang_City?></td>
              <td width="35%" height="28"><input type="text" name="citytxt" size="20" value="<?=$city?>" ></td>
              <td width="18%" height="28"><?=$lang_Country?></td>
              <td height="28">
                <select size="1" name="countrylst">
                  <option value="nill" ><?=$lang_SelectaCountry?></option>
                  <?php
    $sql    = "select * from partners_country";
    $result = mysql_query($sql);
?>
                  <?php
    while($row=mysql_fetch_object($result))
    {
    if($country==$row->country_name)
    {
?>
                  <OPTION value="<?=$row->country_name?>" selected >
                  <?=$row->country_name?>
                  </OPTION>
                  <?php
        }
    else{
?>
                  <OPTION value="<?=$row->country_name?>" >
                  <?=$row->country_name?>
                  </OPTION>
                  <?php
             }
    }
?>
              </select></td>
              <td width="1%" height="28">&nbsp;</td>
            </tr>
            <tr>
              <td width="1%" height="19">&nbsp;</td>
              <td width="14%" height="19">Payment Gateway </td>
              <td width="35%" height="19">&nbsp;</td>
              <td width="18%" height="19">&nbsp;</td>
              <td height="19" valign="bottom">&nbsp;</td>
              <td width="1%" height="19">&nbsp;</td>
            </tr>
            <tr>
              <td height="18"  colspan="6">
                <p align="center">
                  <input type="submit" value="<?=$merpay_register?>" name="B1">
              </td>
            </tr>
          </table>
          <p></p></TD>
        </TR>
        <TR>
          <TD height="26" colspan="2" bgcolor="#D2D2D2" class="lftborder">
            <div align="right"><IMG SRC="images/innerbox2_07.gif" width="25" height="26" ALT=""/></div></TD>
        </TR>
</TABLE></form></td>
  </tr>
  <tr>
    <td width="215" height="23" align="left" valign="bottom" class="lftnavbg"><img src="images/lft_bt_13.gif" width="215" height="23" alt=""/></td>
  </tr>
</table>

<script language="javascript" type="text/javascript">
           function viewLink()
                {

                   url="forgotpass.php";
                   nw = open(url,'new','height=200,width=450,scrollbars=yes');
                   nw.focus();
                }
 </SCRIPT>