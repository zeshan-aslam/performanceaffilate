<?
//Last Modified By DPT on May/25/05 to fix issues with HTML
 $Err		=$_GET['Err'];
 $Action	=$_GET['Action'];

 if ($Action=="affiliate")
    $aff="selected = 'selected'";
 else
     $mer="selected = 'selected'";
?>
<?php /*?><table width="775"  border="0" align="center" class="outtbl" cellpadding="0" cellspacing="0">
  <tr>

    <td height="100%" rowspan="2" align="left" valign="top">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="260" align="left" valign="top"><table width="260" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td> <img src="images/innerbox1_01.gif" width="24" height="26" alt="" /></td>
              <td width="105" height="26" bgcolor="#2676d1"><div align="center" class="style4"><?=$lang_AFFILIATES?></div></td>
              <td height="26" colspan="3" class="rtborder"> <img src="images/innerbox1_03.gif" width="131" height="26" alt="" /></td>
            </tr>
            <tr align="left">
              <td height="2" colspan="5"  class="ltrtbrdrw" ><table width="100%"  border="0" cellspacing="5" cellpadding="5">
                  <tr>
                    <td align="center"><p align="justify"><?=$lang_reg?></p>
                        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><div align="center"><img src="images/affilia.jpg" width="233" height="157" alt="" /></div></td>
                          </tr>
                      </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="26" colspan="3" class="lftborder"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="bottom"><table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="5" bgcolor="#d2d2d2"></td>
                        </tr>
                    </table></td>
                    <td width="21"><img src="images/innerbox1_06.gif" width="21" height="26" alt="" /></td>
                  </tr>
              </table></td>
              <td width="103" height="26" bgcolor="#d2d2d2">
                <div align="center"><a href="index.php?act=affil_regi"><?=$lang_REGISTER?>!!</a></div></td>
              <td width="25" height="26"> <img src="images/innerbox2_07.gif" width="25" height="26" alt=""/></td>
            </tr>
            <tr>
              <td> <img src="images/spacer.gif" width="24" height="1" alt=""/></td>
              <td> <img src="images/spacer.gif" width="105" height="1" alt=""/></td>
              <td> <img src="images/spacer.gif" width="3" height="1" alt=""/></td>
              <td> <img src="images/spacer.gif" width="103" height="1" alt=""/></td>
              <td> <img src="images/spacer.gif" width="25" height="1" alt=""/></td>
            </tr>
          </table>
            <br/>
        </td>
        <td width="10">&nbsp;</td>
        <td align="left" valign="top"><table width="260" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td> <img src="images/innerbox2_01.gif" width="24" height="26" alt=""/></td>
              <td width="105" height="26" bgcolor="#ffa200"><div align="center" class="style4"><?=$lang_BENEFITS?></div></td>
              <td height="26" colspan="3" class="rtborder"> <img src="images/innerbox2_03.gif" width="131" height="26" alt=""/></td>
            </tr>
            <tr>
              <td height="2" colspan="5"  class="ltrtbrdr" ><table width="100%"  border="0" cellspacing="5" cellpadding="5">
                  <tr>
                    <td><p>&nbsp; </p>
                        <ul><li><?=$afffeaturelist1?></li>
                        <li><?=$afffeaturelist2?></li>
                        <li><?=$afffeaturelist3?></li>
                        <li><?=$afffeaturelist4?></li>
                        <li><?=$afffeaturelist5?></li>
                        <li><?=$afffeaturelist6?></li>
                        <li><?=$afffeaturelist7?></li>
                        <li><?=$afffeaturelist8?></li>
                        </ul>
                        <p>&nbsp;</p></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="26" colspan="3" class="lftborder"> <img src="images/innerbox2_05.gif" width="132" height="26" alt=""/></td>
              <td width="103" height="26" bgcolor="#d2d2d2">&nbsp; </td>
              <td width="25" height="26"> <img src="images/innerbox2_07.gif" width="25" height="26" alt=""/></td>
            </tr>
            <tr>
              <td> <img src="images/spacer.gif" width="24" height="1" alt=""/></td>
              <td> <img src="images/spacer.gif" width="105" height="1" alt=""/></td>
              <td> <img src="images/spacer.gif" width="3" height="1" alt=""/></td>
              <td> <img src="images/spacer.gif" width="103" height="1" alt=""/></td>
              <td> <img src="images/spacer.gif" width="25" height="1" alt=""/></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="215" height="23" align="left" valign="bottom" class="lftnavbg"><img src="images/lft_bt_13.gif" width="215" height="23" alt=""/></td>
  </tr>
</table><?php */?>


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="50%" align="right" valign="top"><table width="349" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <!--<td><img src="images/affiliate-top.jpg" width="349" height="27" /></td>-->
                <td class="affiliates-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;AFFILIATES</div></td>
              </tr>
              <tr>
                <td class="affiliate-content-bg"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td colspan="2" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="38%" valign="top" align="center"><div><img src="images/affiliate-img.jpg" width="115" height="84" /></div>
                          <div>&nbsp;</div>
                        <div><a href="index.php?Act=affil_regi"><img src="images/affiliate-reg-btn.jpg" width="116" height="24" border="0" /></a></div></td>
                      <td width="62%" valign="top" class="text-02"><?=$lang_reg?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><img src="images/affiliate-bottom.jpg" width="349" height="10" /></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="5"></td>
        </tr>
      </table></td>
	  <td width="50%" valign="top" ><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="features-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;BENEFITS</div></td>
        </tr>
        <tr>
          <td class="fetures-content-bg"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="2" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td width="11%" height="25" align="center" valign="top" style="padding-top:5px;"><img src="images/bullet.jpg" width="8" height="10" /></td>
                <td width="89%" align="left" valign="top" class="text-02"><?=$afffeaturelist1?></td>
              </tr>
              <tr>
                <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                <td align="left" class="text-02"><?=$afffeaturelist2?></td>
              </tr>
              <tr>
                <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                <td align="left" class="text-02"><?=$afffeaturelist3?></td>
              </tr>
              <tr>
                <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                <td align="left" class="text-02"><?=$afffeaturelist4?></td>
              </tr>
              <tr>
                <td height="25" align="center" valign="top" style="padding-top:5px;"><img src="images/bullet.jpg" width="8" height="10" /></td>
                <td align="left" class="text-02"><?=$afffeaturelist5?></td>
              </tr>
              <tr>
                <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                <td align="left" class="text-02"><?=$afffeaturelist6?></td>
              </tr>
              <tr>
                <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                <td align="left" class="text-02"><?=$afffeaturelist7?></td>
              </tr>
              <tr>
                <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                <td align="left" class="text-02"><?=$afffeaturelist8?></td>
              </tr>
              <tr>
                <td colspan="2" align="center">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><img src="images/features-bottom.jpg" width="341" height="9" /></td>
        </tr>
      </table></td>
		
	</tr>
</table>

<script language="javascript" type="text/javascript">
	function viewLink(){
		url	= "forgotpass.php";
		nw 	= open(url,'new','height=200,width=450,scrollbars=yes');
		nw.focus();
	}
</script>