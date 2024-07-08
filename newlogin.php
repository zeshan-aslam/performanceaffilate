<?php /*?><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" class="outtbl">
  <tr>
    <td height="90%" rowspan="2" align="left" valign="top" ><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="260" align="left" valign="top">
				<form name="myform1" action="login_validate.php" method="post" >		  
		  <table width="260" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td> <img src="images/innerbox1_01.gif" width="24" height="26" alt="" /></td>
                <td width="105" height="26" bgcolor="#2676d1"><div align="center" class="style4"><?=$lang_MERCHANTS?></div></td>
                <td height="26" colspan="3" class="rtborder"> <img src="images/innerbox1_03_new.gif" width="131" height="26" alt="" /></td>
              </tr>
              <tr align="left">
                <td height="2" colspan="5"  class="ltrtbrdr" >

				<table width="100%"  border="0" cellspacing="5" cellpadding="20">                      
                  <tr>
                      <td align="center" valign="top"><div align="justify"><?=$lang_Increase?><br/>
                              <br/><div align="center" class="textred"><?=$Err1?>&nbsp;</div>
                        </div>
                          <table width="150"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="15" colspan="3"><div align="left"><span class="style7"><?=$lang_Username?>:</span></div></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="3"><div align="left">
                                  <input name="login" type="text" class="style3" value="" size="25"/>
                              </div></td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3" class="style5"><div align="left" class="style7"><?=$lang_Password?>:</div></td>
                            </tr>
                            <tr>
                              <td width="81"><div align="left">
                                  <input  name="password" type="text" class="style3" value="" size="15"/>
                                   <input name="flag" type="hidden" value="merchant"/>
                              </div></td>
                              <td width="56" height="20" align="center" valign="middle" class="enter"><div class="sbt" onclick="javascript:document.myform1.submit()">Enter</div></td>
                              <td >&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3"><div align="left"><a href="#" onclick="viewLink1()"><?=$lang_Forgot?> ? </a></div></td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3">&nbsp;</td>
                            </tr>
                            <tr bgcolor="#2676D1">
                              <td height="20" colspan="3"><div align="center" class="style4"><?=$lang_NEWm?>?</div></td>
                            </tr>
                            <tr>
                              <td height="25" colspan="3"><div align="center"><a href="index.php?Act=register"><?=$lang_REGISTER?>!! </a></div></td>
                            </tr>
                        </table>
                        </td>
                    </tr>        

                </table>				
				</td>
              </tr>
              <tr>
                <td height="26" colspan="3" class="lftborder"><img src="images/innerbox2_05.gif" width="132" height="26" alt=""/></td>
                <td width="103" height="26" bgcolor="#d2d2d2">
                  <div align="center"></div></td>
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
			<input name="flag" type="hidden" value="merchant"/>
			</form>
			
              <br/>
          </td>
          <td width="10">&nbsp;</td>
          <td align="left" valign="top">
          <form name="myform" action="login_validate.php" method="post">
			<table width="260" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td> <img src="images/innerbox2_01.gif" width="24" height="26" alt=""/></td>
                <td width="105" height="26" bgcolor="#ffa200"><div align="center" class="style4"><?=$lang_AFFILIATES?></div></td>
                <td height="26" colspan="3" class="rtborder"> <img src="images/innerbox2_03.gif" width="131" height="26" alt=""/></td>
              </tr>
              <tr>
                <td height="2" colspan="5"  class="ltrtbrdr" ><table width="100%"  border="0" cellspacing="5" cellpadding="20">
                    <tr>


                      <td align="center" valign="top"><div align="justify"><?=$lang_turnyour?><br/>
                              <br/>

                             <div align="center" class="textred"><?=$Err?>&nbsp;   </div>
                                                   </div>
                          <table width="150"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="15" colspan="3"><div align="left"><span class="style7"><?=$lang_Username?>:</span></div></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="3"><div align="left">
                                  <input name="login" type="text" class="style3" value="" size="25"/>
                              </div></td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3" class="style5"><div align="left" class="style7"><?=$lang_Password?>:</div></td>
                            </tr>
                            <tr>
                              <td width="81"><div align="left">
                                  <input name="password" type="text" class="style3" value="" size="15"/>
                                  <input name="flag" type="hidden" value="affiliate"/>
                              </div></td>
                              <td width="56" height="20" align="center" valign="middle" class="enter"><div class="sbt"  onclick="javascript:document.myform.submit();">Enter</div></td>
                              <td >&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3"><div align="left"><a href="#" onclick="viewLink1()"><?=$lang_Forgot?> ? </a></div></td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3">&nbsp;</td>
                            </tr>
                            <tr bgcolor="#FFA200">
                              <td height="20" colspan="3"><div align="center" class="style4"><?=$lang_NEWa?>?</div></td>
                            </tr>
                            <tr>
                              <td height="23" colspan="3"><div align="center"><a href="index.php?Act=affil_regi"><?=$lang_REGISTER?>!! </a></div></td>
                              </tr>
                        </table>
                                                </td></tr>
                </table> </td>
              </tr>
              <tr>
                <td height="26" colspan="3" class="lftborder"> <img src="images/innerbox2_05.gif" width="132" height="26" alt=""/></td>
                <td width="103" height="26" bgcolor="#d2d2d2">
                  <div align="center"></div></td>
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
		</form>
		</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td width="215" height="23" align="left" valign="bottom" class="lftnavbg"><img src="images/lft_bt_13.gif" width="215" height="23" alt=""/></td>
  </tr>
</table><?php */?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="top"  >
		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
<!--		<td><img src="images/merchants-top.jpg" width="348" height="26" /></td>-->	
			<td class="merchants-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;MERCHANTS</div></td>

	</tr>
		<tr>
		<td class="merchants-content-bg">
		<form name="myform1" action="login_validate.php" method="post" >
		<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			  <td colspan="2" align="center">&nbsp;</td>
			</tr>
			<tr>
			  <td width="38%" valign="top" align="center"><div><img src="images/merchants-img.jpg" width="117" height="86" /></div>
				  <div>&nbsp;</div>
				<div><a href="index.php?Act=register"><img src="images/merchants-reg-btn.jpg" border="0" /></a></div></td>
			  <td width="62%" valign="top" class="text-02"><?=$lang_Increase?><br/><br/>
			  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="15" colspan="3"><div align="left"><span class="style7"><?=$lang_Username?>:</span></div></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="3"><div align="left">
                                  <input name="login" type="text" class="style3" value="" size="25"/>
                              </div></td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3" class="style5"><div align="left" class="style7"><?=$lang_Password?>:</div></td>
                            </tr>
                            <tr>
                              <td width="91"><div align="left">
                                  <input  name="password" type="password" class="style3" value="" size="15"/>
                                   <input name="flag" type="hidden" value="merchant"/>
                              </div></td>
                              <td width="91" height="24" align="center" valign="middle" class="enter">
							  <div class="sbt" onclick="javascript:document.myform1.submit()"><?=$lang_Enter?></div></td>
                              <td width="55" >&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3"><div align="left">
							  <a href="#" onclick="viewLink1()"><?=$lang_Forgot?> ? </a></div></td>
                            </tr>
                    </table>
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="center" valign="top">&nbsp;</td>
			</tr>
		</table>
		</form>
		</td>
		</tr>
		<tr>
		<td><img src="images/merchants-bottom.jpg" width="348" height="9" /></td>
		</tr>
		</table>
	</td>
	<td valign="top" align="right">
		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<!--<td><img src="images/affiliate-top.jpg" width="349" height="27" /></td>-->
				<td class="affiliates-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;AFFILIATES</div></td>
			</tr>
			<tr>
			<td class="affiliate-content-bg">
			<form name="myform" action="login_validate.php" method="post">
			<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td colspan="2" align="center">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="38%" valign="top" align="center">
				<div><img src="images/affiliate-img.jpg" width="115" height="84" /></div>
				<div>&nbsp;</div>
				<div><a href="index.php?Act=affil_regi"><img src="images/affiliate-reg-btn.jpg" width="116" height="24" border="0" /></a></div>
				</td>
				<td width="62%" valign="top" class="text-02"><?=$lang_turnyour?><br/><br/><br/>
				<table width="95%"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="15" colspan="3"><div align="left"><span class="style7"><?=$lang_Username?>:</span></div></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="3"><div align="left">
                                  <input name="login" type="text" class="style3" value="" size="25"/>
                              </div></td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3" class="style5"><div align="left" class="style7"><?=$lang_Password?>:</div></td>
                            </tr>
                            <tr>
                              <td width="94"><div align="left">
                                  <input name="password" type="password" class="style3" value="" size="15"/>
                                  <input name="flag" type="hidden" value="affiliate"/>
                              </div></td>
                              <td width="118" height="24" align="center" valign="middle" class="enter">
							  <div class="sbt" onclick="javascript:document.myform.submit();"><?=$lang_Enter?></div></td>
                              <td width="55" >&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="15" colspan="3">
							  <div align="left"><a href="#" onclick="viewLink1()"><?=$lang_Forgot?> ? </a></div></td>
                            </tr>
                        </table>
				</td>
			  </tr>
			  <tr>
				<td colspan="2" align="center" valign="top">&nbsp;</td>
				</tr>
			</table>
			</form>
			</td>
			</tr>
	<tr>
	<td><img src="images/affiliate-bottom.jpg" width="349" height="10" /></td>
	</tr>
	</table></td>
	</tr>
</table>
<script language="javascript" type="text/javascript">
	function viewLink1(){
	   url	= "forgotpass.php?Action=affiliate";
	   nw 	= open(url,'new','height=200,width=450,scrollbars=yes');
	   nw.focus();
	}
	function viewLink(){
	   url	= "forgotpass.php";
	   nw 	= open(url,'new','height=200,width=450,scrollbars=yes');
	   nw.focus();
	}
</script>