<table width="661" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
			<td class="affiliates-reg-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;<?=$lang_contactus?></div></td>
			</tr>
			<tr>
			<td class="affiliate-reg-content-bg">
			<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td height="100%" rowspan="2" align="left" valign="top">
				<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
				  <tr>
					<td height="2" colspan="5" valign="top">
						<form  method="post" action="contact_mail.php">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td colspan="2" align="center" height="30" class="error"><?=$Err1?></td>
                            </tr>
                            <tr>
                              <td align="right">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right"><?=$lang_Name?>
&nbsp;:                              &nbsp;&nbsp;&nbsp;</td>
                              <td align="left"><input type="text" name="Name" size="37" value="<?=$Name?>"/></td>
                            </tr>
                            <tr>
                              <td align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right"><?=$lang_Address?>
&nbsp;:                              &nbsp;&nbsp;&nbsp;</td>
                              <td><textarea class="box" cols="35" name="Address" rows="5" ><?=$Address?>
                              </textarea></td>
                            </tr>
                            <tr>
                              <td align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right"><?=$lang_Location?>
&nbsp;:                              &nbsp;&nbsp;&nbsp;</td>
                              <td><input type="text" name="Location" size="37" value="<?=$Location?>"/></td>
                            </tr>
                            <tr>
                              <td align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right"><?=$lang_EmailId?>
&nbsp;:                              &nbsp;&nbsp;&nbsp;</td>
                              <td><input type="text" name="Email" size="37" value="<?=$Email?>"/></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><textarea class="box" cols="68" name="Message" rows="5" ><?=$Message?>
                              </textarea></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><input  name="contact" type="submit" value="<?=$contact_ussend?>" /></td>
                            </tr>
                            <tr>
                              <td width="32%">&nbsp;</td>
                              <td width="68%">&nbsp;</td>
                            </tr>
                          </table>
					    </form>            </td>
				  </tr>
				</table></td>
			  </tr>
			</table>
			
			</td>
			</tr>
			<tr>
			<td><img src="images/affiliate-reg-bottom.jpg" width="661" height="13" /></td>
			</tr>
		</table>


