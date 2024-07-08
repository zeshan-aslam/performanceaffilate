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
   $saletype		  = trim($_POST['saletype']);
   $leadtype		  = trim($_POST['leadtype']);
   $clicktype		  = trim($_POST['clicktype']);

# setting default values for merchnatid
	if($MERCHANTID=='All')
		$MERCHANTID = "0";

# validating date firlds
# if incorrect format rediraects to main page
# with err msg

$msg = "";
if($sub=="View"){
   if(!$partners->is_date($cfrom) || !$partners->is_date($cto)){
        $msg="Please Enter Valid Date" ;
   }
   else{

#change to sql formats
   $From      = $partners->date2mysql($cfrom);
   $To        = $partners->date2mysql($cto);

# getiing all programs
   switch($programs)
   {
      case 'AllPgms':
        $sql  = " SELECT DISTINCT T.transaction_ip,T.transaction_country,T.transaction_type, T.transaction_status, T.transaction_referer, ";
        $sql .= " A.affiliate_company, A.affiliate_lastname, A.affiliate_id, ";
        $sql .= " date_format(transaction_dateoftransaction,'%b %d, %Y') As transDate ";
        $sql .= " from partners_program As P, partners_transaction As T, partners_joinpgm As J, partners_affiliate As A ";
        $sql .= " WHERE ( T.transaction_dateoftransaction BETWEEN '$From' AND '$To' )";
        $sql .= " AND T.transaction_joinpgmid = J.joinpgm_id ";
        $sql .= " AND J.joinpgm_programid = P.program_id ";
        $sql .= " AND J.joinpgm_affiliateid = A.affiliate_id ";

        if($saletype==1 or $leadtype==1 or $clicktype==1){
       	    $tsql  .= ($saletype==1) ? "OR T.transaction_type = 'sale' " : "";
	        $tsql  .= ($leadtype==1) ? "OR  T.transaction_type = 'lead' " : "";
	        $tsql  .= ($clicktype==1) ? "OR T.transaction_type = 'click' " : "";

	        $tsql = trim($tsql);
	        $tsql = trim($tsql,"OR");
	        $tsql = " AND (".$tsql.")";
	        $sql .= $tsql;
        }
        $impSql = "SELECT *,date_format(imp_date,'%b %d, %Y') As impDate FROM partners_affiliate,partners_impression ";
        $impSql.= " WHERE imp_affiliateid = affiliate_id";
        break;

     case 'All':
        $sql  = " SELECT DISTINCT T.transaction_ip,T.transaction_country,T.transaction_type, T.transaction_status, T.transaction_referer, ";
        $sql .= " A.affiliate_company, A.affiliate_lastname, A.affiliate_id, ";
        $sql .= " date_format(transaction_dateoftransaction,'%b %d, %Y') As transDate ";
        $sql .= " from partners_program As P, partners_transaction As T, partners_joinpgm As J, partners_affiliate As A  ";
        $sql .= " WHERE P.program_merchantid = '$MERCHANTID' ";
        $sql .= " AND ( transaction_dateoftransaction BETWEEN '$From' AND '$To' )";
       	if($saletype==1 or $leadtype==1 or $clicktype==1){
       	    $tsql  .= ($saletype==1) ? "OR T.transaction_type = 'sale' " : "";
	        $tsql  .= ($leadtype==1) ? "OR  T.transaction_type = 'lead' " : "";
	        $tsql  .= ($clicktype==1) ? "OR T.transaction_type = 'click' " : "";

	        $tsql = trim($tsql);
	        $tsql = trim($tsql,"OR");
	        $tsql = " AND (".$tsql.")";
	        $sql .= $tsql;
        }
        $impSql = "SELECT *,date_format(imp_date,'%b %d, %Y') As impDate FROM partners_affiliate,partners_impression ";
        $impSql.= " WHERE I.imp_merchantid = '$MERCHANTID' ";
        $impSql.= " AND imp_affiliateid = affiliate_id";
        break;

     default:
        $sql  = " SELECT Distinct T.transaction_ip,T.transaction_country,T.transaction_type, T.transaction_status, T.transaction_referer, ";
        $sql .= " A.affiliate_company, A.affiliate_lastname, A.affiliate_id, ";
        $sql .= " date_format(transaction_dateoftransaction,'%b %d, %Y') As transDate ";
        $sql .= " from partners_program As P, partners_transaction As T, partners_joinpgm As J, partners_affiliate As A  ";
        $sql .= " WHERE P.program_id = '$programs' ";
        $sql .= " AND ( transaction_dateoftransaction BETWEEN '$From' AND '$To' )";
        $sql .= " AND T.transaction_joinpgmid = J.joinpgm_id ";
        $sql .= " AND J.joinpgm_programid = P.program_id ";
        $sql .= " AND J.joinpgm_affiliateid = A.affiliate_id ";
        if($saletype==1 or $leadtype==1 or $clicktype==1){
       	    $tsql  .= ($saletype==1) ? "OR T.transaction_type = 'sale' " : "";
	        $tsql  .= ($leadtype==1) ? "OR  T.transaction_type = 'lead' " : "";
	        $tsql  .= ($clicktype==1) ? "OR T.transaction_type = 'click' " : "";

	        $tsql = trim($tsql);
	        $tsql = trim($tsql,"OR");
	        $tsql = " AND (".$tsql.")";
	        $sql .= $tsql;
        }

        $impSql = "SELECT *,date_format(imp_date,'%b %d, %Y') As impDate FROM partners_affiliate, partners_impression ";
        $impSql.= " WHERE I.imp_programid = '$programs' ";
        $impSql.= " AND imp_affiliateid = affiliate_id";
        break;
   }


   $result    = mysql_query($sql);

   $impSql .= " And imp_date between '$From' AND '$To' ";
   $impRet	= mysql_query($impSql);
  }


# adding heading to report
    if(!empty($txtto) && !empty($txtfrom)) {
        $heading    =$txtfrom. " - ".$txtto;
    }
 }
#setting merchant id if empty to deafault valus
    if(empty($MERCHANTID)) $MERCHANTID ="0";


# getting all merchnats from table
    $sqlMer = " SELECT * FROM partners_merchant ";
    $retMer = mysql_query($sqlMer);
    $retMer1 = mysql_query($sqlMer);

     $sqlMerc    = " SELECT max(merchant_id) AS countMer FROM partners_merchant ";
    $retMerc    = mysql_query($sqlMerc) or die(mysql_error());
    $rowMerc    = mysql_fetch_object($retMerc);
    $countMer   = $rowMerc->countMer;

    # fills the values for Merchant and Programs
    # Generetes  a Global javascript array REGION
    # Stores all the programs corresponding to particular marchant
    # Populate the dropdown with corresponding pgms

        # script starts here
        echo "<script language='javascript' type='text/javascript'>";

             # initiates a javascript array REGION
             $code     = "var REGION = new Array ( ";
              $code    .= str_repeat(" new Array(),",$countMer+1);

             # Fills with DEfaut values
             $fbody   .= " AddPgms(0,'All Programs`~`AllPgms'); ";

             while ($rowMer1=mysql_fetch_object($retMer1)) {

                # getts all programs corresponding to a merchant
                $sqlfld   = "SELECT * from partners_program where program_merchantid = '$rowMer1->merchant_id'";
                $resfld   = mysql_query($sqlfld) ;
                echo @mysql_error();

                # adds 'All pgms' option

                $fbody   .= "AddPgms($rowMer1->merchant_id,'All Programs`~`All'); ";

                if(mysql_num_rows($resfld)) {
                        while ($rowfld=mysql_fetch_object($resfld)) {

                            # adds all availble pgms to array
                            $fld      = $rowfld->program_url."`~`".$rowfld->program_id;
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
            if($programs){
             $code .= " document.trans.programs.value = '$programs' ;";
            }
            $code  .=  $fend;

            echo "$code";
        echo "</script>";

?>

<script language="javascript" type="text/javascript">
      function AddPgms(intRegion, strCity) {
                REGION[ intRegion ][  REGION[ intRegion ].length++  ] = strCity;
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
             <td height="19" class="tdhead" colspan="2"  align="center">
             Statistics For Custom Period</td>
         </tr>
         <tr>
              <td height="19" colspan="2"  align="center" class="textred">
             <?=$msg?></td>
         </tr>
         <tr>
              <td height="19" colspan="2" align="center" >
              For Period</td>
        </tr>
        <tr>
             <td width="40%" height="24" align="center">&nbsp; From</td>
             <td width="60%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" /></td>
        </tr>
        <tr>
             <td colspan="2" height="7"></td>
        </tr>
		<tr>
             <td width="40%%" height="24" align="center">&nbsp;&nbsp;&nbsp; To</td>
             <td width="60%%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$txtto?>" onfocus="javascript:to_date();return false;" /></td>
        </tr>
        <tr>
             <td colspan="2" height="23">&nbsp;</td>
        </tr>
        <tr>
             <td height="20" class="tdhead" colspan="2" align="center">Search Merchants</td>
        </tr>
        <tr>
           <td colspan="2"height="13">&nbsp;</td>
        </tr>
        <tr>
             <td height="25" colspan="2" align="center" >Merchant :
                    <select name="merchants" onchange="UpdateCombos(this.value);"><option value="0" >Select Merchants</option>
                               <?
                               while($rowMer=mysql_fetch_object($retMer))

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
             <td height="25" colspan="2" align="center" > Program :
                      <select name="programs" >
                      </select>
            </td>
        </tr>
        <tr>
                  <td colspan="2" height="13">&nbsp;</td>
        </tr>
        <tr>
                <td colspan="2" align="center" height="20" class="tdhead"> 
				<input type="checkbox" name="clicktype" value="1" <?=$schk?> class="borderless" <?=($clicktype)?"checked='checked'":""?> /> Click&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="checkbox" name="saletype" value="1"  class="borderless" <?=($saletype)?"checked='checked'":""?> /> Sale &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="checkbox" name="leadtype" value="1"  class="borderless" <?=($leadtype)?"checked='checked'":""?> /> Lead
                </td>
        </tr>
        <tr>
                 <td colspan="2" height="13">&nbsp;</td>
        </tr>
        <tr>
                <td colspan="2" align="center" height="26">
                <input type="submit" name="sub" value="View" /></td>
            </tr>
  </table>
  </form>

<?
# Displaying referer logs
if($sub=="View" and empty($msg)){

    if((mysql_num_rows($result)) ){
        $rowNo = 0;
        ?>
           <table class="tablebdr" cellspacing="1" width="95%" id="AutoNumber1">
           <tr>
            <td width="10%" align="center" class="tdhead">Type</td>
            <td width="20%" align="center" class="tdhead">Affiliate</td>
            <td width="35%" align="center" class="tdhead">HTTP_REFERER</td>
            <td width="15%" align="center" class="tdhead">IP</td>
            <td width="20%" align="center" class="tdhead">Date</td>
            <td width="15%" align="center"  class="tdhead">Country</td>
          </tr>
              <?
               while($rowTrans=mysql_fetch_object($result)){
                    $rowNo++;
                    $transType      = $rowTrans->transaction_type;
                    $transStatus    = $rowTrans->transaction_status;
                    $transReferer   = $rowTrans->transaction_referer;
                    $transIp   		= $rowTrans->transaction_ip;
                    $transAff       = ucwords(strtolower(stripslashes($rowTrans->affiliate_company)));

                    $transAffid     = $rowTrans->affiliate_id;

              ?>
                <tr class="<?=($rowNo%2==0)?'grid1':'grid2'?>" >
                  <td width="10%" align="center"  ><?=$type?>&nbsp;<img
                            alt="" border='0' height="10" src="../images/<?=$transType?>.gif"
                            width="10" /></td>
                  <td width="20%" align="center" ><a href="#" onclick="help1(<?=$transAffid?>)"> <?=$transAff?></a></td>
                  <td width="10%" align="center"  ><b><?=$transReferer?></b></td>
                  <td width="10%" align="center"  ><b><?=$transIp?></b></td>
                  <td width="10%" align="center" ><?=$rowTrans->transDate?></td>
                  <td width="15%" align="left" >
                      &nbsp;<img alt="" border='0' height="15" src="../images/<?=$transStatus?>.gif"
                                        width="15" />&nbsp;<?=$transStatus?>
                  </td>
                </tr>
            <? }?>
        </table>
        <?
        }

        else {
		
        ?>
        <p class="textred" align="center">Sorry No Records Found</p>
        <?
        }

     }
  ?>