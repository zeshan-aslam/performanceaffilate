<?
 # getting back form variables
    $MERCHANTID		= $_SESSION['MERCHANTID'];   //merchantid

    $txtfrom        = trim($_POST['txtfrom']);    //from date
    $txtto          = trim($_POST['txtto']);      //to date
    $sub            = trim($_POST['sub']);        //submit button
    $msg            = trim($_POST['msg']);        //err msg
    $programs       = trim($_POST['programs']);

    $saletype		  = trim($_POST['saletype']);
    $leadtype		  = trim($_POST['leadtype']);
    $clicktype		  = trim($_POST['clicktype']);

    if(!empty($txtto) || !empty($txtfrom))
    {
         if((!$partners->is_date($txtto)) || (!$partners->is_date($txtfrom))){
           	$msg = $lang_report_err;
         }
    }

  # getting all programs
    $sql      = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2  = mysqli_query($con,$sql);
 ?>
 <script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.trans.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.trans.txtto,Date);
        }
</script>
  <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
 </iframe>
 <br/>
 <form name="trans" method="post" action="#">
    <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr1"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="3"  align="center">
             <?=$lang_report_stat?></td>
         </tr>
         <tr>
                  <td  height="19" colspan="3"  align="center" class="textred">
                 <?=$msg?></td>
         </tr>
                <tr>
                 <td  height="19" colspan="3"  align="center" >
                 <?=$lang_report_forperiod?></td>
        </tr>
            <tr>
                 <td width="48%" height="24" align="right">&nbsp; <?=$lang_report_from?></td>
                 <td width="4%" height="24" align="left"></td>
                 <td width="48%" align="left">
				 <input type="text" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" /></td>
            </tr>
            <tr>
                    <td width="48%" height="24" align="right">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
                 <td width="4%" height="24" align="left"></td>
                 <td align="left"><input type="text" name="txtto" size="18" value="<?=$txtto?>" onfocus="javascript:to_date();return false;" /></td>
            </tr>
            <tr>
                 <td height="23" colspan="3">&nbsp;</td>
            </tr>
        <tr>
             <td height="20" class="tdhead" colspan="3" align="center"><?=$lang_report_SearchProgram?>
             </td>
        </tr>
            <tr>
                 <td height="13" colspan="3">&nbsp;</td>
            </tr>
        <tr>
             <td height="25" colspan="3" align="center" >
                      <select name="programs" ><option value="All" ><?=$lang_report_AllProgram?> </option>
                               <?
                               while($row=mysqli_fetch_object($result2))

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
                   </select>
            </td>
      </tr>
             <tr>
                          <td height="13" colspan="3">&nbsp;</td>
      </tr>
                     <tr>
                        <td colspan="3" align="center" height="20" class="tdhead"> <input type="checkbox" name="clicktype" value="1" <?=$schk?> class="borderless" <?=($clicktype)?"checked='checked'":""?> /><?=$lhome_Click?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="saletype" value="1"  class="borderless" <?=($saletype)?"checked='checked'":""?> /> <?=$lhome_Sale?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="leadtype" value="1"  class="borderless" <?=($leadtype)?"checked='checked'":""?> /> <?=$lhome_Lead?>
                        </td>
                     </tr>
                      <tr>
                         <td height="13" colspan="3">&nbsp;</td>
             </tr>
            <tr>
                <td colspan="3" align="center" height="26">
                <input type="submit" name="sub" value="view" title="<?=$lang_report_view?>" /></td>
            </tr>
  </table>
</form>
  <?
  # get records od seleted values

  if(($sub=="view") and empty($msg)){
       $To   = $partners->date2mysql($txtto);
       $From = $partners->date2mysql($txtfrom);

       $transSql = "SELECT *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
       $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
       if($programs != "All"){
       	    $transSql.= " AND joinpgm_programid = '$programs' ";
       }else  $transSql.= " AND joinpgm_merchantid = '$MERCHANTID'";
       if($partners->is_date($txtto) && $partners->is_date($txtfrom)){
          $transSql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
       }
       $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
       $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
       $transSql.= " AND affiliate_id = joinpgm_affiliateid ";
       if($saletype==1 or $leadtype==1 or $clicktype==1){
           $tsql  .= ($saletype==1) ? "OR transaction_type = 'sale' " : "";
           $tsql  .= ($leadtype==1) ? "OR  transaction_type = 'lead' " : "";
           $tsql  .= ($clicktype==1) ? "OR transaction_type = 'click' " : "";

           $tsql = trim($tsql);
           $tsql = trim($tsql,"OR");
           $tsql = " AND (".$tsql.")";
           $transSql .= $tsql;
        }
		//echo $transSql;
       $transRet = mysqli_query($con,$transSql);

  ?>
   <table border="0" cellpadding="2" cellspacing="2"  class="tablebdr"  width="100%" align="center" >

  <?
  if(mysqli_num_rows($transRet)>0){
   ?>
   <tr><td colspan="6" class="sphead" align="center"><?=$trans_existing?></td></tr>
   <tr class="<?=$classid?>" >
    <td width="10%" align="center"  class="tdhead"><?=$lang_product_Type?></td>
    <td width="20%" align="center"  class="tdhead"><?=$lang_product_Product?></td>
    <td width="20%" align="center" class="tdhead"><?=$lang_product_Affiliate?></td>
    <td width="10%" align="center" class="tdhead"><?=$lang_product_Commission?></td>
    <td width="20%" align="center" class="tdhead"><?=$lang_product_Date?></td>
    <td width="10%" align="center" class="tdhead"><?=$lang_product_Status?></td>

  </tr>
   <?
   $i  = 0;
  	while($transRow = mysqli_fetch_object($transRet)){

     $type       = trim(stripslashes($transRow->transaction_type));
     $tstatus    = trim(stripslashes($transRow->transaction_status));
     $transDate  = trim(stripslashes($transRow->transaction_dateoftransaction));
     $affAmnt    =   $transRow->transaction_amttobepaid;
	 $adminAmnt  =   $transRow->transaction_admin_amount;

     if($currValue != "Dollar"){
	          $affAmnt     =   getCurrencyValue($transDate, $currValue, $affAmnt);
	          $adminAmnt   =   getCurrencyValue($transDate, $currValue, $adminAmnt);
	 }
     $commission = trim(stripslashes($affAmnt)) + trim(stripslashes($adminAmnt));

     $date		 = trim(stripslashes($transRow->DATE));
     $product	 = trim(stripslashes($transRow->prd_product));
     $productid	 = trim(stripslashes($transRow->prd_id));
     $affiliateid= trim(stripslashes($transRow->affiliate_id));
     $affiliate  = trim(stripslashes($transRow->affiliate_company));
     $classid    = ($i%2==0)?"grid1":"grid2";
  ?>

  <tr class="<?=$classid?>" >
    <td width="10%" align="center"  ><b><?=$i+1?></b>. <?=$type?>&nbsp;
	<img alt="" border="0" height="10" src="../images/<?=$type?>.gif" width="10" /></td>
    <td width="20%" align="center"  ><?=$product?>
    </td>

    <td width="20%" align="center" ><a href="index.php?Act=affiliate_page&amp;aid=<?=$affiliateid?>" id="show" > <?=$affiliate?></a></td><!-- onclick="help1(<?=$affiliateid?>)"-->

    <td width="10%" align="center"  ><?=$commission?> <?=$currSymbol?></td>
    <td width="20%" align="center" ><?=$date?></td>

    <td width="10%" align="left" >
        &nbsp;<img alt="" border="0" height="15" src="../images/<?=$tstatus?>.gif" width="15" />&nbsp;<?=$tstatus?></td>


  </tr>
  <?
   $i++;
   }
  }else{
   ?>
   <tr><td colspan="6" class="sphead" align="center"><?=$lang_report_head?></td></tr>
   <tr><td colspan="6" class="textred" align="center"><?=$lang_report_no_rec?></td></tr>
   <?
   }
  ?>
  </table> <? }?>