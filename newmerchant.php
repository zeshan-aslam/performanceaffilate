<?
//Last Modified By DPT on May/25/05 to fix issues with HTML
 $Err		=$_GET['Err'];
 $Action	=$_GET['Action'];

 if ($Action=="affiliate")
    $aff="selected = 'selected'";
 else
     $mer="selected = 'selected'";
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="50%" align="right" valign="top"><table width="349" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <!--<td><img src="images/merchants-top.jpg" width="348" height="26" /></td>-->
                <td class="merchants-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;MERCHANTS</div></td>
              </tr>
              <tr>
                <td class="merchants-content-bg"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td colspan="2" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="38%" valign="top" align="center"><div><img src="images/merchants-img.jpg" width="117" height="86" /></div>
                          <div>&nbsp;</div>
                        <div><a href="index.php?Act=register"><img src="images/merchants-reg-btn.jpg" border="0" /></a></div></td>
                      <td width="62%" valign="top" class="text-02"><?=$lang_When?>
                          <p> <?=$lang_Our?></p>
                          </td>
                    </tr>
                    <tr>
                      <td height="23" colspan="2" align="center" valign="top">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><img src="images/merchants-bottom.jpg" width="348" height="9" /></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
		<td width="50%" align="center" valign="top" ><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="features-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;BENEFITS</div></td>
          </tr>
          <tr>
            <td class="fetures-content-bg"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td width="12%" height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td width="88%" align="left" class="text-02"><?=$benefitlist1?></td>
                </tr>
                <tr>
                  <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td align="left" class="text-02"><?=$benefitlist2?></td>
                </tr>
                <tr>
                  <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td align="left" class="text-02"><?=$benefitlist3?></td>
                </tr>
                <tr>
                  <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td align="left" class="text-02"><?=$benefitlist4?></td>
                </tr>
                <tr>
                  <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td align="left" class="text-02"><?=$benefitlist5?></td>
                </tr>
                <tr>
                  <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td align="left" class="text-02"><?=$benefitlist6?></td>
                </tr>
                <tr>
                  <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td align="left" class="text-02"><?=$benefitlist7?></td>
                </tr>
                <tr>
                  <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td align="left" class="text-02"><?=$benefitlist8?></td>
                </tr>
                <tr>
                  <td height="25" align="center"><img src="images/bullet.jpg" width="8" height="10" /></td>
                  <td align="left" class="text-02"><?=$benefitlist9?></td>
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
           function viewLink()
                {

                   url="forgotpass.php";
                   nw = open(url,'new','height=200,width=450,scrollbars=yes');
                   nw.focus();
                }
 </script>