<?
 $Err = isset($_GET['Err']) ? $_GET['Err'] : "";
 if ($Act=="Affiliates")
    $aff	= "selected = 'selected'";
 else
     $mer	= "selected = 'selected'";
?>

	<table width="239" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="middle" style="background-image:url(images/language-bg.jpg); background-repeat:no-repeat; height:104px; background-position:center;">
				<!--<div style="width:44%; float:left; position:relative;" class="lang">Language :&nbsp;&nbsp;&nbsp;</div>
				<div style="width:55%; float:left; position:relative;">
				<select name="select" style="width:100px; border:thin solid #d9d9d9; background-color:#ffffff;">
				</select>
				</div>-->
				<div class="langSelect"><? include_once "language_select.php"; ?></div>	
			</td>
		</tr>
		<tr>
			<td height="5"></td>
		</tr>
		<tr>
			<td align="center"><img src="images/client-login-top.jpg" width="239" height="44" /></td>
		</tr>
		<tr>
			<td bgcolor="#f7f7f7"><form name="login" action="login_validate.php" method="post">
				<div style="text-align:center; padding-top:2px; padding-bottom:2px;" class="error">&nbsp;<?php echo $Err; ?></div>
				<div style="width:40%; float:left; position:relative;" class="lang"><?=$lang_Choose?>:&nbsp;&nbsp;&nbsp;</div>
				<div style="width:59%; float:left; position:relative;">
				<select name="flag" class="selectLogin" >
					<option <?=$mer?> value="merchant"><?=$lang_Merchants?></option>
					<option <?=$aff?> value="affiliate"><?=$lang_Affiliates?></option>
				</select>
				</div>
				<div style="height:40px;">&nbsp;</div>
				<div style="width:40%; float:left; position:relative;" class="lang"><?=$lang_Username?> :&nbsp;&nbsp;&nbsp;</div>
				<div style="width:59%; float:left; position:relative;">
<!--			<input size="15" name="Input" type="text" style="border:thin solid #d9d9d9; background-color:#ffffff;" />-->
				<input size="18" name="login" type="text" value=""/>
				</div>
				<div style="height:40px;">&nbsp;</div>
				<div style="width:40%; float:left; position:relative;" class="lang"><?=$lang_Password?> :&nbsp;&nbsp;&nbsp;</div>
				<div style="width:59%; float:left; position:relative;">
                <input size="18" name="password" type="password" style="border:thin solid #d9d9d9; background-color:#ffffff;" />
                </div>
				
				</div>
				<div style="height:40px;">&nbsp;</div>
				<div style="width:62%; float:left; position:relative;">&nbsp;</div>
				<div style="width:38%; height:24px; float:left; position:relative;" class="enter">
				<!--<a href="#" class="sbt" ><?=$lang_Enter?></a>-->
				<div class="sbt" onclick="document.login.submit()" style="width:75%;height:24px; text-align:center; vertical-align:middle; padding-top:5px; " >
				 <!--<div align="center" class="sbt" onclick="javascript:document.myform.submit();" style="text-align:center; width:80%; height:24px; ">-->
				 <a href="#" class="sbt" style="color:#FFFFFF" ><?=$lang_Enter?></a></div>
				</div>
				<div style="height:40px;">&nbsp;</div>
				<div style="width:88%; float:left; position:relative; text-align:right">
				<a href="#" onclick="viewlink()" class="forgot-pass"><?=$lang_Forgot?>? </a></div>
				<div style="height:60px;">&nbsp;</div></form></td>
			</tr>
		<tr>
			<td align="center">
			
			<img src="images/client-login-bottom.jpg" width="239" height="10" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<script language="javascript" type="text/javascript">
		function viewlink(){
			url	= "forgotpass.php";
			nw = open(url,'new','height=200,width=450,scrollbars=yes');
			nw.focus();
		}
	</script>				