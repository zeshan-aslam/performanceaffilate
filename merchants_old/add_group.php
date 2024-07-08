<?

 /***************************variables*****************************************/
 $groupname                = trim(stripslashes($_GET['groupname']));  //group name
 $click                    = trim(($_GET['click']));                  //click rate
 $lead                     = trim(($_GET['lead']));                   //lead rate
 $sale                     = trim(($_GET['sale']));                   //sale rate
 $saletype                 = trim(($_GET['saletype']));               //sale type
 $programs                 = trim(($_GET['programs']));               //programid
 $Err                      = trim($_GET['Err']);                      //err msg
 $id                       = intval(trim($_GET['id']));               // group id for editing
 $addvalue                 = trim($_GET['addvalue']);                 //edit or add
 /*****************************************************************************/


 if (empty($addvalue)) 
      $addvalue = $group_add;
          //checking   edit or add

/***************selecting sale type*******************************************/
 if ($saletype=="%")
 {
       $ps1="selected = 'selected'";   //percentage seected
       $ds1="";
  }
 else
 {
      $ds1="selected = 'selected'";     //dollar selected
      $ps1="";
   }
 /*****************************************************************************/


 /*************************adding programs to dropdown box*********************/
   $sql="SELECT * from partners_program where program_merchantid ='$MERCHANTID'"; //adding to drop down box
   $result=mysqli_query($con,$sql);
   $result1=mysqli_query($con,$sql);;
   if(empty($programs))
     {
      $rows=mysqli_fetch_object($result1);
      $programs=$rows->program_id;
     }

     if($programs=="")
     {


     }
     else
	    {
		   $query="select * from partners_group where group_programid ='$programs'";
            $ret=mysqli_query($con,$query);
            }

  /****************************************************************************/
?>
<br/>
	<form name="Getprogram" action="group_validate.php?id=<?=$id?>"  method="post" >
	<?
	if($programs!=""){
	?>
	<table cellpadding="0" cellspacing="0" width="70%" class="tablebdr" align="center">
		<tr>
		<td width="20%" height="30" class="tdhead"><b><?=$lnewgrp_AffiliatePrograms?></b></td>
		<td width="50%" height="30" class="tdhead"><select name="programs" onchange="document.Getprogram.submit()">
		<?  while($row=mysqli_fetch_object($result))
		
		{
		if($programs=="$row->program_id")
		$programName="selected = 'selected'";
		else
		$programName="";
		
		?>
		<option <?=$programName?> value="<?=$row->program_id?>"><?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> </option>
		<?
		}
		?>
		</select></td>
		<td height="30" class="tdhead">&nbsp;</td>
		
		</tr>
		<tr>
			<td colspan="2" class="red" align="center"><?=$Err?></td>
		</tr>
		<tr>
			<td width="100%" height="210" colspan="4"><br/>
			
				<table  cellpadding="0" cellspacing="0" width="60%" class="tablebdr" align="center">
				<tr>
					<td width="100%" colspan="2" align="center" class="tdhead" ><b><?=$addvalue?></b></td>
				</tr>
				<tr>
					<td width="100%" colspan="2" align="center">&nbsp;</td>
				</tr>
				<tr>
					<td width="20%" align="center" height="30"><?=$lnewgrp_GroupName?></td>
					<td width="70%"  height="30"><input type="text" name="txtgroupname" value="<?=$groupname?>" size="40" /></td>
				</tr>
				<tr>
					<td width="100%" colspan="2" align="center">&nbsp;</td>
				</tr>
				</table><br />
				<table  cellpadding="0" cellspacing="0" width="60%" class="tablebdr" align="center">
				<tr>
				<td width="100%" colspan="3"  align="center">&nbsp;</td>
				</tr>
				<tr>
				<td width="100%" colspan="3" class="tdhead" align="center"><b><?=$lnewgrp_Commissions?></b></td>
				</tr>
				<tr>
				<td width="100%" colspan="3"  align="center">&nbsp;</td>
				</tr>
				<tr>
				
				<td width="30%" height="30" align="right"><?=$lnewgrp_Click?></td>
				<td width="5%" height="30" align="center"></td>
				<td width="65%" height="30" align="left"><input type="text" name="txtclick" size="10" value="<?=$click?>" /></td>
				</tr>
				<tr>
				
				<td width="30%" height="30" align="right"><?=$lnewgrp_Lead?></td>
				<td width="5%" height="30" align="center"></td>
				<td width="65%" height="30" align="left"><input type="text" name="txtlead" size="10" value="<?=$lead?>" /></td>
				</tr>
				<tr>
				
				<td width="30%" align="right" height="30"><?=$lnewgrp_Sale?></td>
				<td width="5%" align="center" height="30"></td>
				<td width="65%" align="left" height="30"><input type="text" name="txtsale" size="10" value="<?=$sale?>" />
				<select size="1" name="txtsaletype">
				<option value="$" <?=$ds1?> ><?=$currSymbol?></option>
				<option value="%" <?=$ps1?> >%</option>
				</select></td>
				</tr>
				<tr>
				<td width="100%" colspan="3"  align="center">&nbsp;</td>
				</tr>
				
				</table><br />
		</td>
		</tr>
	<tr>
	<td width="100%" colspan="4" height="30" align="center">
	<input name="currValue" type="hidden" value="<?=$currValue?>" />
	<input  type="submit" name="add" value="<?=$addvalue?>" align="left" />
	</td>
	</tr>
	</table><br />
	
	<?
	}
	?>
	</form>
   <?

        if($programs!="")
     {

    if(mysqli_num_rows($ret)>0){
    ?>

  <form name="DeleteGroup"  method="post" action="delete_group.php?programs=<?=$programs?>">
   <table  cellpadding="0" cellspacing="1"  width="90%" class="tablebdr" align="center" >
                      <tr class="tdhead">
                            <td width="3%"  align="center" height="20">&nbsp;</td>
                            <td width="36%"  align="center"><b><?=$lnewgrp_GroupName?></b></td>
                            <td width="6%"  align="center"><b><?=$lnewgrp_Id?></b></td>
                            <td width="11%"  align="center"><b><?=$lnewgrp_Click?></b></td>
                            <td width="11%"  align="center"><b><?=$lnewgrp_Lead?></b></td>
                            <td width="10%"  align="center"><b><?=$lnewgrp_Sale?></b></td>
                             <td width="10%"  align="center"><b><?=$lnewgrp_Action?></b></td>
                         </tr>
                           <?
                       while($row=mysqli_fetch_object($ret)){
                               $pgmDate    = $row->group_date;
                               $clickGroup = $row->group_clickrate ;
                               $leadGroup  = $row->group_leadrate ;
                               $saleGroup  = $row->group_salerate;
                               $typeGroup  = $row->group_saletype;
	                            if($typeGroup != "%" )
								{
                                    $typeGroup     = $currSymbol;   
								}

                              if($currValue != $default_currency_caption){
                            	$clickGroup     =   getCurrencyValue($pgmDate, $currValue, $clickGroup);
	                            $leadGroup      =   getCurrencyValue($pgmDate, $currValue, $leadGroup);
	                            if($typeGroup != "%" )
								{
	                                $saleGroup     =   getCurrencyValue($pgmDate, $currValue, $saleGroup);
								}
	           		   		 }
                           ?>
                         <tr>
                            <td width="3%"  align="center"  height="20"> <input type="checkbox" name="elements[]" value="<?=$row->group_id?>" /></td>
                            <td width="36%"  align="center"  height="20"><?=stripslashes($row->group_name)?></td>
                            <td width="6%"  align="center"  height="20"><?=$row->group_id?></td>
                            <td width="11%"  align="center"  height="20"><?=$currSymbol?> <?=$clickGroup?></td>
                            <td width="11%"  align="center"  height="20"><?=$currSymbol?> <?=$leadGroup?></td>
                            <td width="10%"  align="center" height="20"><?=$typeGroup?> <?=$saleGroup?></td>
                            <td width="10%"  align="center" height="20"><a href="index.php?Act=add_group&amp;groupname=<?=$row->group_name?>&amp;click=<?=$clickGroup?>&amp;lead=<?=$leadGroup?>&amp;sale=<?=$saleGroup?>&amp;saletype=<?=$row->group_saletype?>&amp;programs=<?=$row->group_programid?>&amp;id=<?=$row->group_id?>&amp;addvalue=Edit Group" ><?=$lnewgrp_Edit?></a></td>

                                            </tr>

                   <?php
                    }
                    ?>

     </table>
     <table  cellpadding="0" cellspacing="1"  width="95%" class="tablewbdr" align="center">
<tr>
  <td width="3%">
  </td>
  <td width="90%" colspan="9" align="left" height="30" >
      <img src="../images/arrow_ltr.gif" alt="" />
      <a href="#" onclick="flagall()"  > <?=$lnewgrp_CheckAll?> /</a>
      <a href="#" onclick="unflagall()"><?=$lnewgrp_UnCheckAll?>&nbsp;&nbsp;&nbsp;</a>
       <input name="currValue" type="hidden" value="<?=$currValue?>" />
       <input type="submit" name="sub" value="<?=$lnewgrp_Delete?>" style="width: 110" onclick=" return validatesuspend()" />
  </td>
  </tr>
</table>
 </form>

 <?
 }
 }
  else
    {
    ?>
     <table width="100%" align="center">
         <tr>
            <td align="center" class="red"><?=$norec?> </td>
         <tr>
         </table>
    <?
    }
 ?><br />
<script language="javascript" type="text/javascript">
	function flagall()
	{
		for(i=0;i<document.DeleteGroup.elements.length;i++)
		{
			document.DeleteGroup.elements[i].checked = true;
		}
	}
	function unflagall()
	{
		for(i=0;i<document.DeleteGroup.elements.length;i++)
		{
			document.DeleteGroup.elements[i].checked = false;
		}
	}

	function validatejoin()
	{
		var del=window.confirm("Are You Sure You Want To Join Selected Programs? ") ;
		if (del)
		return true;
		else
		return false;
	}

	function validatesuspend()
	{
		var del=window.confirm("Are You Sure You Want To Delete Selected Groups? ") ;
		if (del)
		return true;
		else
		return false;
	}
	function ChangeCaption()
	{
		document.DeleteGroup.hidden.value="Edit Group" ;
	}

</script>