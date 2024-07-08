<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  AffiliateGroupForm.php                         */
/*     CREATED ON     :  27/JULY/2009                                   */

/*	 	AffiliateGroup Management section. 								*/
# Administrator can add or edit groups for the affiliates with a name and the number of levels (1 to 5) that the group will have.
/************************************************************************/

# Displays error messages if any
if($msg) { ?>
    <p align="center" class="textred" ><?=$msg?></p>
<? } ?>

<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="65%" align="center">
<form name="frm_group" method="post" action="index.php?Act=AffiliateGroup&mode=submit" >
	<input type="hidden" name="groupId" value="<?=$groupId?>" />
     <tr>
        <td align="center" colspan="2" class="tdhead"><b><?=($groupId)?"Edit ":"Add "?>New Affiliate Group</b></td>
     </tr>

     <tr>
        <td height="30" align="right" width="50%">Group Title&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td height="30" align="left" width="50%">
        	<input type="text" name="grouptitle"  value="<?=$grouptitle?>" />
        </td>
     </tr>
     <tr>
        <td height="30" align="right" width="50%">Levels of Commission&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td height="30" align="left" width="50%">
        	<select name="level" id="level" >
			<?php
				for($i=1; $i<=5; $i++) { ?>            	
            	<option value="<?=$i?>" <?=($i==$level)?"selected='selected'":""?> ><?=$i?></option>
            <?php } ?>
            </select>
        </td>
     </tr>
     <tr>
        <td height="30" align="center" colspan="2">
        	<input type="submit" name="btn_add" value="<?=($groupId)? 'Edit' : 'Add' ?>" />
        </td>
     </tr>
</form>     
</table>