<?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
   include_once '../includes/session.php';
   include_once '../includes/allstripslashes.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);


	// for poulating list
    $sql ="SELECT event_name from partners_event";
    $res=mysqli_query($con,$sql);


	 // To get count of active mails
    $activesql="SELECT count( * ) AS active FROM partners_adminmail A, partners_event E WHERE A.adminmail_eventname=E.event_name AND E.event_status = 'yes'";
    $activeres=mysqli_query($con,$activesql);
    $activerow = mysqli_fetch_object($activeres);


  //retriving values from submitted form
	if(!empty($_SESSION['BODY'])){
       $from        =        $_GET['from'];
       $sub         =        stripslashes($_GET['sub']);
       $event       =        $_GET['event'];
       $status      =        $_REQUEST['status'];
       $to          =                $_GET['to'];

       $body        =        stripslashes($_SESSION['BODY']);
       $header      =        stripslashes($_SESSION['HEADER']);
       $footer      =        stripslashes($_SESSION['FOOTER']);
	}else{
		$msg1  		= $email_no_msg;
	}

       $msg         =        $_GET['msg'];


	 // radio button selection
       if ($status=="yes") {
       $active="checked='checked'";
       }
       else {
          $inactive="checked='checked'";
       }
 
    ?>


<script language="javascript" type="text/javascript">


	function select1_onchange() {
		if(document.f1.select1.value!="ChooseEvent")
		{

			document.f1.flag.value="0";
			document.f1.submit();
		}
		else
		{
			  document.f1.fromtxt.value="";
			  document.f1.subjecttxt.value="";
			  document.f1.bodytxt.value="";
			  document.f1.headertxt.value="";
			  document.f1.footertxt.value="";
			  return false;
		 }
	}
	
	function msent_onclick()
	{
		if(document.f1.select1.value!="ChooseEvent")
			{
				document.f1.flag.value="1";
				document.f1.submit();
				}
			else
			{
			  return false;
			 }
	}
	
	
	function btn_onclick()
	{
			if(document.f1.select1.value!="ChooseEvent")
			{
			   document.f1.flag.value="2";
				document.f1.submit();
				}
			else
			{
			  return false;
			 }
	}
	
	
	
	function btn1_onclick()
	{
			if(document.f1.select1.value!="ChooseEvent")
			{
			   document.f1.flag.value="1";
				document.f1.submit();
				}
			else
			{
			  return false;
			 }
	}
	
</script>

<form method="post" action="emailvalidate.php" id="f1" name="f1">
<table cellpadding="0" cellspacing="0" class="tablebdr" align="center" width="100%" >
	<tr><td colspan="3" height="10">&nbsp;</td></tr>
	<tr>
		<td width="60%" align="left">
			<table border='0' cellpadding="0"  class="tablebdr" width="100%" id="AutoNumber1" cellspacing="0">
				<tr>
				  <th width="119%" colspan="4" class="tdhead" height="19">Email Messages</th>
				</tr>
				<tr>
				  <td width="119%" height="19" colspan="4" align="center" class="textred"><?=$msg ?></td>
				</tr>
				<tr>
				  <td width="11%" height="19" >&nbsp;</td>
				  <td width="49%" height="19" >Active Messages</td>
				  <td width="67%" height="19" class="textred" colspan="2" align="left">: <?=$activerow->active?></td>
				</tr>
				<tr>
				  <td width="11%" height="28" class="body">&nbsp;</td>
				  <td width="49%" height="28">Choose Action </td>
				  <td width="25%" height="28" class="body" colspan="2" align="left">
					  <select size="1" name="eventcompo" id="select1" onchange="return select1_onchange()">
					  <option selected="selected" >ChooseEvent</option>
					  <?
				
					  while($row = mysqli_fetch_object($res))
					  {
							   
							   if (trim($event)==trim($row->event_name)) {
									$var="selected='selected'";
							   }
							   else {
									$var="";
							   }
				
					  ?>
							   <option <?=$var?>> <?=$row->event_name?> </option>
					  <?
					   }
				
				
					  ?>
				
					  </select>
					</td>
				</tr>
				 <tr>
				  <td width="11%" height="35" class="body">&nbsp;</td>
				  <td width="49%" height="35">Current Status</td>
				  <td width="67%" height="35" colspan="2" align="left">Active <input type="radio" value="active" <?=$active?> name="statusradio" />&nbsp;&nbsp;
				  Inactive <input type="radio" name="statusradio" value="inactive" <?=$inactive?> /></td>
				</tr>
				<tr>
				  <td width="11%" height="38" class="body">&nbsp;</td>
				  <td width="49%" height="38">From</td>
				  <td width="67%" height="38" colspan="2" align="left"><input type="text" name="fromtxt" size="27" value="<?=$from ?>" /></td>
				</tr>
				<tr>
				  <td width="11%" height="43" class="body">&nbsp;</td>
				  <td width="49%" height="43">Subject</td>
				  <td width="67%" height="43" colspan="2" align="left"><input type="text" name="subjecttxt" size="27" value="<?=$sub ?>" /></td>
				</tr>
				<tr>
				 <th align="center"width="119%" colspan="4" class="tdhead" height="19">
				  Please Paste HTML code on Header Body and Footer&nbsp;
				  Fields</th>
				</tr>
				<tr>
				  <td height="5" class="body">&nbsp;</td>
				  <td height="5">&nbsp;</td>
				  <td height="5" colspan="2" >&nbsp;</td>
				</tr>
				<tr>
				  <td width="11%" height="32" class="body">&nbsp;</td>
				  <td width="49%" height="32">Header</td>
				  <td width="67%" height="32" colspan="2" >
				  <textarea rows="2" name="headertxt" cols="41"><?=$header?></textarea></td>
				</tr>
				<tr>
				  <td width="11%" height="148" class="body">&nbsp;</td>
				  <td width="49%" height="148">Body</td>
				  <td width="67%" height="148" colspan="2" >
				  <textarea rows="8" name="bodytxt" cols="41" class="bodytxt"><?=$body ?></textarea></td>
				</tr>
				  <tr>
				  <td width="11%" height="24" >&nbsp;</td>
				  <td width="49%" height="24"  >Footer</td>
				  <td width="67%" height="24" colspan="2" >
				  <textarea rows="2" name="footertxt" cols="41"><?=$footer ?></textarea></td>
			
				</tr>
				  <tr>
				  <td width="11%" height="6" >
				  </td>
				  <td width="49%" height="6"  ></td>
				  <td width="67%" height="6" colspan="2" >
				  </td>
				</tr>
				<tr>
				  <td width="11%" height="20" >&nbsp;</td>
				  <td width="49%" height="20" >
				  </td>
				  <td width="34%" height="20" >
				  <input type="submit" value="Update" name="B1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
				  <td width="33%" height="20" >&nbsp;</td>
				</tr>
				<tr>
				  <td width="11%" height="5" ></td>
				  <td width="49%" height="5"  ></td>
				  <td width="67%" height="5" colspan="2" > </td>
				</tr>
				<tr>
				  <td width="11%" height="20" class="tdhead" ><input type="hidden" value="0" id ="flag" name="flag" /></td>
				  <td width="49%" height="20" class="tdhead" >Test</td>
				  <td width="67%" height="20" class="tdhead" colspan="2" >
					<input type="text" name="to" size="28" value ="<?=$to?>" />&nbsp;&nbsp;&nbsp;<input type="button" value="TestSend" name="B2" onclick="return btn1_onclick()" /></td>
				</tr>
			</table>
		</td>
		
		<td width="2%">&nbsp;</td>
		
		<td width="38%" align="right" valign="top">
			<table align="center" cellpadding="0" cellspacing="0" class="tablebdr" width="100%" >
				<tr>
					<td colspan="2" align="center" valign="top">The variables are included in square brackets and their description is given on the right.  Copy the required variable including the square bracket and paste them to get the values in the mail<br/><br/></td>
				</tr>
				<tr>
					<td colspan="2" align="center" valign="top" class="tdhead">Affiliate Variables</td>
				</tr>
				<tr>
				  <td width="86" class="gridNew" height="20"><b>[aff_firstname]</b></td>
				  <td align="left" width="140" class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Affiliate First Name</td>
				</tr>
				<tr>
				  <td width="86" height="20"><b>[aff_lastname]</b></td>
				  <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Last Name</td>
				</tr>
				<tr>
				  <td width="86"  class="gridNew" height="20"><b>[aff_company]</b></td>
				  <td align="left" width="140"  class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Affiliate Company Name</td>
				</tr>
				<tr>
				  <td width="86"  class="gridNew" height="20"><b>[aff_email]</b></td>
				  <td align="left" width="140"  class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Affiliate Email</td>
				</tr>
				<tr>
				  <td width="86" height="20" ><b>[aff_password]</b></td>
				  <td align="left" width="140" height="20" >&nbsp;&nbsp;&nbsp;Affiliate Password</td>
				</tr>
				<tr>
				  <td width="86"  class="gridNew" height="20"><b>[aff_loginlink]</b></td>
				  <td align="left" width="140"  height="20" class="gridNew">&nbsp;&nbsp;&nbsp;Affiliate Login Link</td>
				</tr>
				<tr>
					<td colspan="2" align="center" valign="top" class="tdhead">Merchant Variables</td>
				</tr>
				<tr>
				  <td width="86" class="gridNew" height="20"><b>[mer_firstname]</b></td>
				  <td align="left" width="140" class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Merchant First Name</td>
				</tr>
				<tr>
				  <td width="86" height="20"><b>[mer_lastname]</b></td>
				  <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Merchant Last Name</td>
				</tr>
				<tr>
				  <td width="86"  class="gridNew" height="20"><b>[mer_company]</b></td>
				  <td align="left" width="140"  class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Merchant Company Name</td>
				</tr>
				<tr>
				  <td width="86"  class="gridNew" height="20"><b>[mer_email]</b></td>
				  <td align="left" width="140"  class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Merchant Email</td>
				</tr>
				<tr>
				  <td width="86" height="20" ><b>[mer_password]</b></td>
				  <td align="left" width="140" height="20" >&nbsp;&nbsp;&nbsp;Merchant Password</td>
				</tr>
				<tr>
				  <td width="86"  class="gridNew" height="20"><b>[mer_loginlink]</b></td>
				  <td align="left" width="140"  height="20" class="gridNew">&nbsp;&nbsp;&nbsp;Merchant Login Link</td>
				</tr>
				<tr>
					<td colspan="2" align="center" valign="top" class="tdhead">Common Variables</td>
				</tr>
				<tr>
				  <td width="86" height="20" ><b>[today]</b></td>
				  <td align="left" width="140" height="20" >&nbsp;&nbsp;&nbsp;Current Time</td>
				</tr>
				<tr>
				  <td width="86" height="20" ><b>[from]</b></td>
				  <td align="left" width="140" height="20" >&nbsp;&nbsp;&nbsp;Admin Email</td>
				</tr>
				<tr>
				  <td width="86" height="20" ><b>[program]</b></td>
				  <td align="left" width="140" height="20" >&nbsp;&nbsp;&nbsp;Program Name</td>
				</tr>
				<tr>
					<td colspan="2" align="center" valign="top" class="tdhead">Transaction Variables</td>
				</tr>
				<tr>
				  <td width="86" height="20" ><b>[type]</b></td>
				  <td align="left" width="140" height="20" >&nbsp;&nbsp;&nbsp;i.e click, lead, sale</td>
				</tr>
				<tr>
				  <td width="86" height="20" ><b>[commission]</b></td>
				  <td align="left" width="140" height="20" >&nbsp;&nbsp;&nbsp;Commission</td>
				</tr>
				<tr>
				  <td width="86" height="20" ><b>[date]</b></td>
				  <td align="left" width="140" height="20" >&nbsp;&nbsp;&nbsp;Date of Transaction</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" height="10">&nbsp;</td></tr>
</table>

  
</form>