<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  AffiliateGroupCommission.php                   */
/*     CREATED ON     :  28/JULY/2009                                   */

/*	 	AffiliateGroup Commission settings section. 					*/
# Admin can set the commission for each level in each group 
# and set if the commission is provided in flat rate or in percentage of the original sale amount made.
/************************************************************************/



# Displays error messages if any
if($msg) { ?>
    <p align="center" class="textred" ><?=$msg?></p>
<? 
} ?>

<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="65%" align="center">
<form name="frm_commission" method="post" action="index.php?Act=AffiliateGroup&mode=submitCommission" >
	<input type="hidden" name="groupId" value="<?=$groupId?>" />

    <tr>
        <td align="center" colspan="3" class="tdhead">
        	<b>Set Commission for Affiliate Group&nbsp;<?=$groupDetails['grouptitle']?></b>
        </td>
    </tr>

	<tr><td colspan="3" height="20" >&nbsp;</td></tr>
<?php
	for($i=1; $i<=$groupDetails['level']; $i++) {
	?>
    	<tr>
        	<td align="right" width="45%"><b>Level <?=$i?></b></td>
            <td align="center" width="5%">&nbsp;:&nbsp;</td>
            <td align="left" width="50%">
            	<input type="text" name="txt_commission_<?=$i?>" value="<?=$commisionDetails[$i]['commission']?>" maxlength="10" size="10" />
                &nbsp;&nbsp;
                <input type="radio" name="radio_type_<?=$i?>" value="flatrate" <?=($commisionDetails[$i]['type']!="percentage")?"checked='checked'":""?> />$
                &nbsp;
                <input type="radio" name="radio_type_<?=$i?>" value="percentage" <?=($commisionDetails[$i]['type']=="percentage")?"checked='checked'":""?> />%
            </td>
       	</tr>
    <?php			
	}
?>	
	<tr><td colspan="3" height="20" >&nbsp;</td></tr>
	<tr>
    	<td colspan="2" 
    	<td height="20" >
        	<input type="submit" name="Set" value="Set Commission" />
        </td>
    </tr>
	<tr><td colspan="3" height="20" >&nbsp;</td></tr>

</form>
</table>