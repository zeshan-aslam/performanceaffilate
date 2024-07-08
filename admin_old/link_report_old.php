<?
#-------------------------------------------------------------------------------
# Admin Panel Link Report
# Gets date range, merchnat id and corresponding programs
# Finds Transctions happend for this progarms through specific ad link

# Pgmmr        : RR
# Date Created :   21-10-2004
# Date Modfd   :   26-10-2004
#-------------------------------------------------------------------------------


# getting back variables
    $MERCHANTID            =   intval($_GET['merchants']);       //merchantid
    $txtfrom               =   trim($_GET['txtfrom']);    //from date
    $txtto                 =   trim($_GET['txtto']);      //to date
    $sub                   =   trim($_GET['sub']);        //submit button
    $msg                   =   trim($_GET['msg']);        //err msg
    $LINKS                 =   trim($_SESSION['LINKS']);  //all reqired infmn
    $i                     =   trim($_GET['i']);          //counter
    $programs              =   intval(trim($_GET['programs']));   //programid
    $Link                  =   explode("^",$LINKS);
    $TOTALREC              =   count($Link)-1;

# adding heading to report
    if(!empty($txtto) && !empty($txtfrom)) {
        $heading    =$txtfrom. " - ".$txtto;
    }

#setting merchant id if empty to deafault valus
    if(empty($MERCHANTID)) $MERCHANTID = 0;

   // if(empty($programs)) $programs= "All Programs";
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
             $fbody   = " AddPgms(0,'All Programs`~`AllPgms'); ";

             while ($rowMer1=mysql_fetch_object($retMer1)) {

                # getts all programs corresponding to a merchant
                $sqlfld   = "SELECT * from partners_program where program_merchantid='$rowMer1->merchant_id'";
                $resfld   = mysql_query($sqlfld) ;
                echo @mysql_error();

                # adds 'All pgms' option

                $fbody   .= "AddPgms($rowMer1->merchant_id,'All Programs`~`All'); ";

                if(mysql_num_rows($resfld)) {

                        while ($rowfld=mysql_fetch_object($resfld))
                        {
                            # adds all availble pgms to array
                            $fld      = $rowfld->program_url."`~`".$rowfld->program_id;
                            $count    = $rowfld->program_merchantid;
                            $fbody   .= " AddPgms($count,'$fld'); ";
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
           test  = REGION[intREGION][x].split("`~`");

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
</script>


<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
 <br/>
 <form name="trans" method="post" action="link_process.php">
 <table border='0' cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
	<tr>
		<td  height="19" class="tdhead" colspan="2"  align="center">
	 	Statistics For Custom Period</td>
	</tr>
	<tr>
		<td  height="19" colspan="2"  align="center" class="textred">
		<?=$msg?></td>
	</tr>
	<tr>
		<td height="19" colspan="2"  align="center" >For Period</td>
	</tr>
	<tr>
		<td width="40%" height="24" align="center">&nbsp; From</td>
		<td width="60%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" /></td>
	</tr>
	<tr>
		<td height="7" colspan="2" ></td>
	</tr>
	<tr>
		<td width="40%" height="24" align="center">&nbsp;&nbsp;&nbsp; To</td>
		<td width="60%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$txtto?>" onfocus="javascript:to_date();return false;" /></td>
	</tr>
	<tr>
		<td width="35%" height="23">&nbsp;</td>
	</tr>
	<tr>
		<td height="20" class="tdhead" colspan="2" align="center">Search Merchants
		</td>
	</tr>
	<tr>
		<td width="35%" height="13">&nbsp;</td>
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
		<td colspan="2" align="center" height="26">
		<input type="submit" name="sub" value="View" /></td>
	</tr>
</table>
</form>

<?
 if(!empty($sub))
  {
       $total=explode("~",$Link[$i]);
       if(!empty($_SESSION['LINKS']))
       {
		   $To   = $partners->date2mysql($txtto);
		   $From = $partners->date2mysql($txtfrom);
			# calculate impressions

		   $impSql = " SELECT * FROM partners_impression WHERE imp_linkid= '$total[6]'";
		   $impSql .= " And imp_date between '$From' AND '$To' ";

		   $impRet	= mysql_query($impSql);
		   $numRec	= mysql_num_rows($impRet);

		   $rawClick = GetRawTrans('click', 0, 0,0, $total[6], $From, $To, 0);
		   $rawImp   = GetRawTrans('impression',0, 0, 0,$total[6],$From, $To, 0);

       ?>
           	<table border='0'  cellpadding="0" cellspacing="0" width="75%" class="tablebdr" align="center">
				<tr>
					<td  height="25" align="center" class="tdhead" colspan="4">Report
                    <br/><?=$heading?></td>
                </tr>
                <tr>
                    <td  height="20" align="center"  colspan="4"></td>
				</tr>
				<tr>
				 	<td  height="51" align="center"  colspan="4">
                    <?
                    if (  substr($total[6],0,1)=='H' ){
                        $id=substr($total[6],1,strlen($total[6])-1);
                    ?>
                    <a href='temp.php?rowid=<?=$id ?>' target="new">Click Here to View </a>
                     <?
                     }

                     if (  substr($total[6],0,1)=='T' )
                     {
                        $id          =substr($total[6],1,strlen($total[6])-1);
                     ?>
                       <a href='text.php?rowid=<?=$id ?>' target="new">
                       Click Here to View </a>
                     <?
                     }
                      if (  substr($total[6],0,1)=='P' )
                     {

                        $id         =substr($total[6],1,strlen($total[6])-1);
                        $sql        ="select * from partners_popup where popup_id=$id";
                        $result     =mysql_query($sql);
                        $row        =mysql_fetch_object($result)
                     ?>
                       <a href="#" onclick="window.open('<?=stripslashes($row->popup_url)?>',<?=$row->popup_width?>,<?=$row->popup_height?>)" ><?=$lang_report_Click_pop?>
                       </a>
                     <?
                     }
                     if (substr($total[6],0,1)=='B')
                     {
						  $id             =substr($total[6],1,strlen($total[6])-1);
						  $sql            ="select * from partners_banner where banner_id='$id'";
						  $result         =mysql_query($sql);
						  $row            =mysql_fetch_object($result);
						  //echo $row->banner_gif;
						 ?>
						 <img border='0' src="<?=stripslashes($row->banner_name)?>" width="300" height="70" alt="" />
                     <?
                     }

                     if  (substr($total[6],0,1)=='F')
                     {
						  $id            =substr($total[6],1,strlen($total[6])-1);
						  $sql           ="select * from partners_flash where flash_id='$id'";
						  $result        =mysql_query($sql);
						  $row           =mysql_fetch_object($result);

						 ?>

					  <object type="application/x-shockwave-flash" data="<?=stripslashes($row->flash_url)?>" width="300" height="70">
		              <param name="movie" value="<?=stripslashes($row->flash_url)?>" />
			          </object>							 
						 <?
                     }

                     ?>
                     </td>
                 </tr>
				 <tr>
                 <td colspan="4">
                    <br/>
                     <? viewRawTrans($rawClick, $rawImp) ?>
                    <table width="85%"  align="center"  class="tablebdr">
                          <tr >
                               <td width="40%"  class="tdhead">Transactions</td>
                               <td width="30%"  class="tdhead">Number</td>
                               <td width="30%"  class="tdhead">Commission</td>
                          </tr>
                          <tr>
                               <td width="25%" class="grid1" height="28">Click&nbsp;<img
                               alt="" border='0' height="10" src="../images/click.gif" width="10" /></td>
                               <td width="25%"  class="grid1" height="28" ><?=$total[1]?></td>
                               <td width="25%" class="grid1" height="28">$<?=$total[0]?></td>
                          </tr>
                          <tr>
                               <td width="25%" class="grid1" height="28">Lead&nbsp;<img
                               alt="" border='0' class="grid1" height="10" src="../images/lead.gif" width="10" /></td>
                               <td width="25%" class="grid1" height="28"><?=$total[3]?></td>
                               <td width="25%" class="grid1" height="28">$<?=$total[2]?></td>
                          </tr>
                          <tr>
                               <td width="25%" class="grid1"height="28">Sale&nbsp;<img
                                alt="" border='0' class="grid1" height="10" src="../images/sale.gif" width="10" /></td>
                               <td width="25%" class="grid1" height="28"><?=$total[5]?></td>
                               <td width="25%" class="grid1" height="28">$<?=$total[4]?></td>
                          </tr>
                  </table>
				</td>
			</tr>
			<tr>
				<td colspan="4">
                  <br/>
                  <table width="100%" class="tablewbdr" align="center">
                          <tr>
                               <td width="25%"  class="tdhead" align="center">Pending</td>
                               <td width="25%"  class="tdhead" align="center">Reversed</td>
                               <td width="25%"  class="tdhead" align="center">Impressions</td>
                          </tr>
                          <tr>
                              <td width="25%" height="28" align="center">$<?=$total[8]?></td>
                              <td width="25%" height="28" align="center">$<?=$total[10]?></td>
                              <td width="25%" height="28" align="center"><?=$numRec?></td>
                          </tr>
                  </table>
				 </td>
			</tr>
			<tr>
                          <td  height="25" width="32%" class="tdhead"  align="center">
                          <?
                            if($i!=1)
                           {
                          ?>
                               <a href="index.php?Act=link_report&amp;i=<?=($i-1)?>&amp;sub=$sub&amp;txtto=<?=$txtto?>&amp;txtfrom=<?=$txtfrom?>&amp;programs=<?=$programs?>&amp;merchants=<?=$MERCHANTID?>">Previous</a>
                           <?
                           }
                           else
                           {
                                echo "Previous";
                           }
                           ?>
                           </td>
                           <td  height="25" align="center"  class="tdhead" colspan="2" >Total Record Found - <?=$TOTALREC?></td>
                          <td  height="25" width="33%" align="center" class="tdhead">
                             <?
                            if($i!=(count($Link)-1))
                            {
                            ?>
                           <a href="index.php?Act=link_report&amp;i=<?=($i+1)?>&amp;sub=$sub&amp;txtto=<?=$txtto?>&amp;txtfrom=<?=$txtfrom?>&amp;programs=<?=$programs?>&amp;merchants=<?=$MERCHANTID?>">Next</a>
                           <?
                           }
                           else
                           {
                             echo "Next";
                            }
                           ?>
                           </td>
                 </tr>
               </table>
    <?
     }
     else
     {
     ?>
     <table width="100%" align="center">
         <tr>
            <td align="center" class="textred"><?=$norec?> </td>
         <tr>
</table>


     <?
     }
     }
    ?>