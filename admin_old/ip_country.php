<?php
        include '../includes/session.php';
		
		//delete or edit
		if($_GET['mode']=="delete" or $_GET['mode']=="edit")
		{
			//get details
			$from 		= $_GET['from'];
			$to			= $_GET['to'];
			$code2		= $_GET['code2'];
			$code3		= $_GET['code3'];
			$country	= $_GET['country'];		
		}
		
		//if delete
		if($_GET['mode']=="delete")
		{
			//delete the ip range from database
			$sql = "DELETE FROM partners_countryFlag WHERE ip_from = '$from' AND ip_to = '$to' AND country_code2 = '$code2' AND country_code3 = '$code3' AND country_name = '$country'";
			mysqli_query($con,$sql);
		}
		
		//if update
		if($_GET['mode']=="update")
		{
			//get old values
			$old_from 		= $_POST['old_from'];
			$old_to			= $_POST['old_to'];
			$old_code2		= $_POST['old_code2'];
			$old_code3		= $_POST['old_code3'];
			$old_country	= $_POST['old_country'];		
			
			//get new values
			$from 		= $_POST['from'];
			$to			= $_POST['to'];
			$code2		= $_POST['code2'];
			$code3		= $_POST['code3'];
			$country	= $_POST['country'];		

			//update new values
			$sql = "UPDATE partners_countryFlag SET ip_from = '$from', ip_to = '$to', country_code2 = '$code2', country_code3 = '$code3', country_name = '$country'";
			$sql .= " WHERE ip_from = '$old_from' AND ip_to = '$old_to' AND country_code2 = '$old_code2' AND country_code3 = '$old_code3' and country_name = '$old_country'";
			mysqli_query($con,$sql);
		}		

		//if edit
		if($_GET['mode']=="edit")
		{			
?>
	<form name="frm_ip" action="index.php?Act=ip_country&mode=update" method="post">	
	<input type="hidden" name="old_from" value="<?=$from?>" />
	<input type="hidden" name="old_to" value="<?=$to?>" />
	<input type="hidden" name="old_code2" value="<?=$code2?>" />
	<input type="hidden" name="old_code3" value="<?=$code3?>" />
	<input type="hidden" name="old_country" value="<?=$country?>" />				
			<table cellpadding="0" cellspacing="0" align="center" width="50%" class="tablebdr">
				<tr>
					<td colspan="3" class="tdhead" height="25" align="left">Update IP Range</td>
				</tr>
				<tr>
					<td width="48%" height="25" align="right">From</td>
					<td width="3%"></td>
					<td width="49%" align="left"><input type="text" name="from" value="<?=$from?>" /></td>
				</tr>
				<tr>
					<td width="48%" height="25" align="right">To</td>
					<td width="3%"></td>
					<td width="49%" align="left"><input type="text" name="to" value="<?=$to?>" /></td>
				</tr>
				<tr>
					<td width="48%" height="25" align="right">Country Code(2 digit)</td>
					<td width="3%"></td>
					<td width="49%" align="left"><input type="text" name="code2" value="<?=$code2?>" /></td>
				</tr>
				<tr>
					<td width="48%" height="25" align="right">Country Code(3 digit)</td>
					<td width="3%"></td>
					<td width="49%" align="left"><input type="text" name="code3" value="<?=$code3?>" /></td>
				</tr>
				<tr>
                  <td height="25" align="right">Country Name</td>
                  <td></td>
                  <td align="left"><input type="text" name="country" value="<?=$country?>" /></td>
			  </tr>
				<tr>
					<td width="48%" height="25" align="right">&nbsp;</td>
					<td width="3%"></td>
					<td width="49%" align="left"><input type="submit" name="Submit" value="Update" /></td>
				</tr>				
			</table>
			</form>
<?php		
		}
?>
<div align="center"><center>

	<table border='0' cellpadding="2" cellspacing="1" width="90%" class="tablebdr">
		<tr>
    		<td colspan="7" height="18" class="tdhead">IP - Country Database</td>
  		</tr>
		<tr>
			<td colspan="7" align="right"><a href="index.php?Act=ip_country_update">Import Data From SQL</a></td>
		</tr>
<?php
  	if(empty($page))                          //getting page no
    	$page        =$partners->getpage();
	
	//get all records from ip-country database
	$sql = "SELECT * FROM partners_countryFlag";
	$pgsql = $sql;
	$sql  .= " LIMIT ".($page-1)*$lines.",".$lines;	
	$res = mysqli_query($con,$sql);
	if(mysqli_num_rows($res)<=0)
	{
?>
		
  		<tr>
    		<td colspan="7" height="18" align="center" class="textred">
    			Sorry....The IP-Country Database is empty right now.
    		</td>
  		</tr>
<?php
	}
	else
	{
?>
  		<tr class="tdhead">
  		  <td width="13%" align="left">IP(From)</td>
	      <td width="12%" align="left">IP(To)</td>
		  <td width="17%">CountryCode(2 digit)</td>
		  <td width="17%">CountryCode(3 digit)</td>
		  <td width="31%" align="left">Country</td>
      	  <td width="5%" align="left">&nbsp;</td>
      	  <td width="5%" align="left">&nbsp;</td>
  		</tr>
<?php
		while($row = mysqli_fetch_object($res))
		{
?>		
  		<tr>
  		  <td align="left"><?=$row->ip_from?></td>
	      <td align="left"><?=$row->ip_to?></td>
		  <td><?=$row->country_code2?></td>
		  <td><?=$row->country_code3?></td>
		  <td align="left"><?=$row->country_name?></td>
      	  <td align="left"><a href="index.php?Act=ip_country&amp;mode=edit&amp;from=<?=$row->ip_from?>&amp;to=<?=$row->ip_to?>&amp;code2=<?=$row->country_code2?>&amp;code3=<?=$row->country_code3?>&amp;country=<?=$row->country_name?>">Edit</a></td>
      	  <td align="left"><a href="#" onclick="javascript:confirm_deletion(<?=$row->ip_from?>,<?=$row->ip_to?>,'<?=$row->country_code2?>','<?=$row->country_code3?>','<?=$row->country_name?>')">Delete</a></td>
  		</tr>
<?php
		}
	}
?>		
		<tr>
    		<td height="4" colspan="7">
<?

        $url    ="index.php?Act=ip_country";      //pageno adding
        include '../includes/show_pagenos.php';
       /***********************************************************************/

?>			
			</td>
  		</tr>
	</table>
  </center>
</div><br />
<script language="javascript" type="text/javascript">
	function confirm_deletion(from,to,code2,code3,country)
	{
		//confirm
		if(confirm("Are you sure you want to delete this IP range?"))
			window.location = 'index.php?Act=ip_country&amp;mode=delete&amp;from=' + from + "&amp;to=" + to + "&amp;code2=" + code2 + "&amp;code3=" + code3 + "&amp;country=" + country;
	}
</script>