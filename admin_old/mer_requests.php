<?php
 #-------------------------------------------------------------------------------
 # Mercahnt Payment Form

 # Pgmmr           : RR
 # Date Created :   28-11-2004
 # Date Modfd   :   28-11-2004
 #-------------------------------------------------------------------------------

//Added by SMA on 14-JUly-2006 for Admin Users
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
//End Add on 14-July-2006

   if(empty($page)) $page        =$partners->getpage();

   $newSql = "SELECT *,date_format(addmoney_date,'%d-%b-%Y') AS DATE FROM partners_addmoney WHERE addmoney_status like 'waiting'";
   $pgsql  = $newSql ;
   $newSql.= "LIMIT ".($page-1)*$lines.",".$lines; //adding page no
   $newRet = mysqli_query($con, $newSql);


 if(mysqli_num_rows($newRet)>0){
 $i = 0;
  echo "<div align='center' class='textred'><b>$_GET[msg]</b></div>" ;
?>
 <br/>
 <table width="85%" class="tablebdr" align="center">
    <tr class="tdhead">
        <td height="20" width="20%">Date </td>
        <td height="20" width="20%">Merchant </td>
        <td height="20" width="10%" align='center'>Amount  </td>
        <td height="20" width="10%" align='center'>Purpose  </td>
        <td height="20" width="20%" align='center'>Pay Method</td>
        <td height="20" width="20%" align='center'>Dopayments</td>
    </tr>
    <?
    while($newRow = mysqli_fetch_object($newRet)){
      $class =($i%2==0)?'grid1':'grid2';

      $merSql = "SELECT merchant_company FROM partners_merchant WHERE merchant_id= '$newRow->addmoney_merchantid'";
      $merRet = mysqli_query($con, $merSql);

      if(mysqli_num_rows($merRet)>0){
      		$merRow  = mysqli_fetch_object($merRet);
            $merName = stripslashes($merRow->merchant_company);
      }
      switch($newRow->addmoney_mode){
        case "register":
              $cap = "Registration Fee";
              break;
        case "upgrade";
              $cap = "Upgradation Amount";
              break;
        case "addmoney";
        	  $cap = "Deposited";
              break;

      }
    ?>
     <tr class="<?=$class?>">
        <td height="20" width="20%" class='textred'><b><?=$newRow->DATE?></b></td>
        <td height="20" width="20%"><?=ucwords($merName)?></td>
        <td height="20" width="10%" align='center'><?=$currSymbol?>&nbsp;<?=round($newRow->addmoney_amount,2)?></td>
        <td height="20" width="10%" align='center'> <?=$cap?></td>
        <td height="20" width="20%" class='textred' align='center'><b><?=$newRow->addmoney_paytype?></b></td>
        <td height="20" width="20%" align='center'>
		<? if($userobj->GetAdminUserLink('Manage Merchant Requests',$adminUserId,4)) {  ?>
			<a href="paysuccess.php?id=<?=$newRow->addmoney_id?>">Pay Now</a> /
			<a href="paysuccess.php?id=<?=$newRow->addmoney_id?>&mode=reject">Reject</a>
		<? } else { ?>Pay Now / Reject<? } ?>
        </td>
    </tr>
   <? $i++;}$class =($i%2==0)?'grid1':'grid2';
   ?><tr class="<?=$class?>">
                <td height="20" colspan="6" align="center"><?
                $url    ="index.php?Act=mer_requests";    //adding page nos
                include '../includes/show_pagenos.php';
                ?>
   			   </td>
    </tr>

</table>
<?
}else{
  echo "<br/><div align='center' class='textred'><b>Sorry No Requests Found</b></div>" ;
}
?>