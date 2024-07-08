<?
#-------------------------------------------------------------------------------
# Admin Panel Link Report
# Gets date range, merchnat id and corresponding programs
# Finds Transctions happend and its corresponding Referer

# Pgmmr        : RR
# Date Created :   21-10-2004
# Date Modfd   :   26-10-2004
#-------------------------------------------------------------------------------

	# getting all form variables
	$cfrom             = trim($_POST['txtfrom']);  //from date
	$cto               = trim($_POST['txtto']);    //to date
	$sub               = trim($_POST['sub']);      //submit button
	$programs          = intval(trim($_POST['programs'])); //program id
	$MERCHANTID        = intval($_POST['merchants']);      //merchantid
	
	$saletype       = trim($_POST['saletype']);
	$leadtype       = trim($_POST['leadtype']);
	$clicktype      = trim($_POST['clicktype']);

# setting default values for merchnatid
   if($MERCHANTID=='All') $MERCHANTID = "0";

# validating date firlds
# if incorrect format rediraects to main page
# with err msg

	$msg = "";
	if(!empty($txtto) || !empty($txtfrom)) {
		if(!$partners->is_date($cfrom) || !$partners->is_date($cto)){
			$msg="Please Enter Valid Date" ;
		}
	}
	#setting merchant id if empty to deafault valus
	if(empty($MERCHANTID)) $MERCHANTID =0;


# getting all merchnats from table
    $sqlMer   = " SELECT * FROM partners_merchant ";
    $retMer   = mysqli_query($con,$sqlMer);
    $retMer1  = mysqli_query($con,$sqlMer);

    $sqlMerc    = " SELECT max(merchant_id) AS countMer FROM partners_merchant ";
    $retMerc    = mysqli_query($con,$sqlMerc) or die(mysql_error());
    $rowMerc    = mysqli_fetch_object($retMerc);
    $countMer   = $rowMerc->countMer;

    # fills the values for Merchant and Programs
    # Generetes  a Global javascript array REGION
    # Stores all the programs corresponding to particular marchant
    # Populate the dropdown with corresponding pgms

        # script starts here
        echo "<script language='javascript' type='text/javascript'>";

             # initiates a javascript array REGION
             $code     = " var REGION = new Array ( ";
             $code    .= str_repeat(" new Array(),",$countMer+1);

             # Fills with DEfaut values
             $fbody   .= " AddPgms(0,'All Programs`~`AllPgms'); ";

             while ($rowMer1=mysqli_fetch_object($retMer1)) {

                # getts all programs corresponding to a merchant
                $sqlfld   = "SELECT * from partners_program where program_merchantid='$rowMer1->merchant_id'";
                $resfld   = mysqli_query($con,$sqlfld) ;
                echo @mysql_error();

                # adds 'All pgms' option

                $fbody   .= " AddPgms($rowMer1->merchant_id,'All Programs`~`All'); ";

                if(mysqli_num_rows($resfld)) {
                        while ($rowfld=mysqli_fetch_object($resfld)) {

                            # adds all availble pgms to array
                            $fld      = addslashes($rowfld->program_url)."`~`".$rowfld->program_id;
                            $count    = $rowfld->program_merchantid;
                            $fbody   .= "AddPgms($count,'$fld'); ";
                        }
                 }
            }

            $code   =   trim($code,",");
            $fstart =   " function LoadPrgms() {  ";
            $fend   =   "}";
            $code  .=   " );  ";
            $code  .=  $fstart;
            $code  .=  $fbody;
            $code  .= " UpdateCombos($MERCHANTID); ";

            # selecting default program
            if(($programs)){
             $code .= " document.trans.programs.value = '$programs' ;";
            }
            $code  .=  $fend;

            echo "$code";
        echo "</script>";


?>

<script language="javascript" type="text/javascript">
      function AddPgms(intRegion, strCity) {
                var newitem = REGION[intRegion].length ;
                REGION[intRegion][newitem] =  strCity;

        }
       function UpdateCombos(intREGION) {

         document.trans.programs.length = REGION[intREGION].length;
         for (x=0; x < REGION[intREGION].length; x++){
           test=REGION[intREGION][x].split("`~`");

           if(test[1]!="All" && test[1]!="AllPgms")
                 var showString = "ID:"+test[1]+"..."+test[0];
           else  var showString = test[0];
           document.trans.programs[x] = new Option(showString,test[1]);
         }
       }

       function from_date(){
         gfPop.fStartPop(document.trans.txtfrom,Date);
       }

       function to_date() {
         gfPop.fStartPop(document.trans.txtto,Date);
       }
        function help1(afiliateid) {
               url = "viewprofile_affiliate.php?id="+afiliateid;
               nw  = open(url,'new','height=0,width=400,scrollbars=yes');
               nw.focus();
       }
</script>


<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
 <br/>
 <form name="trans" method="post" action="">
    <table border='0' cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2"  align="center"><b>
             Statistics For Custom Period</b></td>
         </tr>
         <tr>
              <td height="19" colspan="2" align="center" class="textred" >
              <?=$msg?></td>
         </tr>
         <tr>
              <td height="19" colspan="2"  align="center"><b>
              For Period</b></td>
        </tr>
        <tr>
             <td height="24" align="center" width="40%">&nbsp; From</td>
             <td  height="24" align="left" width="60%"><input type="text" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" /></td>
        </tr>
		<tr>
             <td height="7" colspan="2"></td>
        </tr>
        <tr>
             <td height="24" align="center">&nbsp;&nbsp;&nbsp; To</td>
             <td height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$txtto?>" onfocus="javascript:to_date();return false;" /></td>
        </tr>
        <tr>
             <td height="23" colspan="2" >&nbsp;</td>
        </tr>
        <tr>
             <td height="20" class="tdhead" colspan="2" align="center"><b>Search Merchants</b>
             </td>
        </tr>
        <tr>
           <td height="13" colspan="2">&nbsp;</td>
        </tr>
        <tr>
             <td height="25" colspan="2" align="center" >Merchant :
                    <select name="merchants" onchange="UpdateCombos(this.value);"><option value="0" >Select Merchants</option>
                               <?
                               while($rowMer=mysqli_fetch_object($retMer))

                               {
                               ?>
                                 <option <?=($merchants==$rowMer->merchant_id)?"selected='selected'":""?> value="<?=$rowMer->merchant_id?>"> <?=stripslashes($rowMer->merchant_firstname)?>&nbsp;<?=stripslashes($rowMer->merchant_lastname)?> </option>
                               <?
                               }
                               ?>
                    </select>
            </td>
        </tr>
        <tr>
             <td height="25"  colspan="2" align="center" > Program :
                      <select name="programs" >
                      </select>
            </td>
         </tr>
	    <tr>
	    	<td colspan="2" height="13">&nbsp;</td>
	    </tr>
	    <tr>
            <td colspan="2" align="center" height="20" class="tdhead"> <input type="checkbox" name="clicktype" value="1" <?=$schk?> class="borderless" <?=($clicktype)?"checked='checked'":""?> /> Click&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="saletype" value="1"  class="borderless" <?=($saletype)?"checked='checked'":""?> /> Sale &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="leadtype" value="1"  class="borderless" <?=($leadtype)?"checked='checked'":""?> /> Lead
            </td>
		</tr>
	    <tr>
	    <td height="13" colspan="2">&nbsp;</td>
	    </tr>
         <tr>
                <td colspan="2" align="center" height="26">
                <input type="submit" name="sub" value="View" /></td>
            </tr>
  </table>
  </form>

<?
 if(($sub=="View") and empty($msg)){
        $From      = $partners->date2mysql($cfrom);
   		$To        = $partners->date2mysql($cto);

       switch($programs)
       {
         case 'AllPgms':
           $transSql = "SELECT *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
           $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";

            if($partners->is_date($cto) && $partners->is_date($cfrom)){
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
           $transRet = mysqli_query($con,$transSql);
            break;

      case 'All':
       $transSql = "SELECT *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
       $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
       $transSql.= " AND joinpgm_merchantid = '$MERCHANTID' ";
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
       $transRet = mysqli_query($con,$transSql);
       break;

     default:
       $transSql = "SELECT *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
       $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
       $transSql.= " AND joinpgm_programid = '$programs' ";
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

       $transRet = mysqli_query($con,$transSql);
        break;
   }

  ?>
   <table border='0' cellpadding="2" cellspacing="2"  class="tablebdr"  width="100%" align="center" >

  <?
  if(mysqli_num_rows($transRet)>0){
   ?>
 <p align="right">
	<a href="#" onClick="window.open('../print_product.php?mid=<?=$MERCHANTID?>&mode=admin&date=<?=$selDate?>&from=<?=$From?>&to=<?=$To?>&program=<?=$programs?>&currValue=<?=$currValue?>&currsymbol=<?=$currSymbol?>&sale=<?=$saletype?>&lead=<?=$leadtype?>&click=<?=$clicktype?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_product.php?mid=<?=$MERCHANTID?>&mode=admin&date=<?=$selDate?>&from=<?=$From?>&to=<?=$To?>&program=<?=$programs?>&currValue=<?=$currValue?>&currsymbol=<?=$currSymbol?>&sale=<?=$saletype?>&lead=<?=$leadtype?>&click=<?=$clicktype?>"><b>Export as CSV</b></a> 	
 </p>
   
   <tr>
   <tr><td colspan="6" class="sphead" align="center"><b>Existing Transaction(s)</b></td></tr>
   <tr class="<?=$classid?>" >
    <td width="10%" align="center"  class="tdhead">Type</td>
    <td width="20%" align="center"  class="tdhead">Product</td>
    <td width="20%" align="center" class="tdhead">Affiliate</td>
    <td width="10%" align="center" class="tdhead">Commission</td>
    <td width="20%" align="center" class="tdhead">Date</td>
    <td width="10%" align="center" class="tdhead">Status</td>
    </td>

  </tr>
   <?
   $i  = 0;
  	while($transRow = mysqli_fetch_object($transRet)){

     $type       = trim(stripslashes($transRow->transaction_type));
     $tstatus    = trim(stripslashes($transRow->transaction_status));
     $commission = trim(stripslashes($transRow->transaction_admin_amount));
     $date		 = trim(stripslashes($transRow->DATE));
     $product	 = trim(stripslashes($transRow->prd_product));
     $productid	 = trim(stripslashes($transRow->prd_id));
     $affiliateid= trim(stripslashes($transRow->affiliate_id));
     $affiliate  = trim(stripslashes($transRow->affiliate_firstname))." ".trim(stripslashes($transRow->affiliate_lastname));
     $classid    = ($i%2==0)?"grid1":"grid2";
  ?>

  </tr>
  <tr class="<?=$classid?>" >
    <td width="10%" align="center"  ><b><?=$i+1?></b>. <?=$type?>&nbsp;<img
              alt="" border='0' height="10" src="../images/<?=$type?>.gif"
              width="10" /></td>
    <td width="20%" align="center"  ><?=$product?>
    </a></td>

    <td width="20%" align="center" ><?=$affiliate?></td>

    <td width="10%" align="center"  ><?=$commission?>&nbsp;<?=$currSymbol?></td>
    <td width="20%" align="center" ><?=$date?></td>

    <td width="10%" align="left" >
        &nbsp;<img alt="" border='0' height="15" src="../images/<?=$tstatus?>.gif"
                          width="15" />&nbsp;<?=$tstatus?></td>
    </td>

  </tr>
  <?
   $i++;
   }
  }else{
   ?>
   <tr><td colspan="6" class="sphead" align="center">Existing Transaction(s)</td></tr>
   <tr><td colspan="6" class="textred" align="center"><?=$norec?></td></tr>
   <?
   }
  ?>
  </table> <? }?><br />