<?php

  include "transactions.php";

  /**********************variables********************************************/
  $aid                     = $_GET['aid'];                                       //affiliateid

  $AFFILIATEID             =  $aid;

  $MERCHANTID			   = $_SESSION['MERCHANTID'];
  /***************************************************************************/


  $sql		=	"SELECT * from partners_joinpgm where joinpgm_affiliateid='$AFFILIATEID' " ;

  $total	= GetAffPaymentDetails($sql, $AFFILIATEID,$currValue,$default_currency_caption); //getting payments (click,sale,lead) values
  $total    = explode('~',$total);


   # calculate impressions
   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid='$MERCHANTID' and imp_affiliateid='$AFFILIATEID'";
   $impRet	= mysqli_query($con,$impSql);
	$row_impr	= mysqli_fetch_object($impRet);
	$numRec	= $row_impr->impr_count;
	if($numRec == '') $numRec = 0; 

 $result=mysqli_query($con,$sql);
 if(mysqli_num_rows($result)>0)
  {
          $row       = mysqli_fetch_object($result);
          $joinid    = $row->joinpgm_id;
          $status    = GetAffiliateStatus($joinid);//getting affiliates information
          $status    = explode('~',$status);

          $details   = GetAffiliateDetails($joinid);//getting program payment information
          $details   = explode('~',$details);

  ?>

            <br/>

            <!-- Table 1-->
            <table border="0" cellpadding="0" cellspacing="0"  width="90%" align= "center" class="tablebdr">
               <tr>
                   <td width="100%" class="tdhead" colspan="3" align="center"><b><?=$lang_rtr_AffiliatesStaistics?></b></td>
               </tr>
               <tr>
					<td  height="10" colspan="3">          </td>
               </tr>
               <tr>
               <td  height="10" colspan="3">
               </td>
               </tr>
               <tr>

                   <td width="60%" align="center" >

                        <table border="0" cellpadding="0"  width="90%" class="tablebdr" >
                           <tr>
                            <td width="100%" colspan="2" class="tdhead" align="center"><b><?=$lang_rtr_PersonalDetails?></b></td>
                          </tr>
                           <tr>
                            <td width="50%" height="20" class="grid1"><?=$lang_rtr_Name?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[0]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$lang_rtr_status?></td>
                            <td width="50%" height="20" class="grid1"><?=$status[0]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$lang_rtr_joindate?></td>
                            <td width="50%" height="20" class="grid1"><?=$status[1]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$lang_rtr_Category ?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[4]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$lang_rtr_Company?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[1]?></td>
                          </tr>
                           <tr>
                            <td width="50%" height="20" class="grid1"><?=$lang_rtr_SiteUrl?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[2]?></td>
                          </tr>


                        </table>
                   </td>

                  <td width="1%">
                  </td>
                  <td width="40%" align="center">

                   <table border="0" cellpadding="0" width="90%" class="tablebdr">
                           <tr>
                              <td width="34%" class="tdhead" ><b><?=$lang_Transaction?></b></td>
                               <td width="26%" align="center" class="tdhead" ><b><?=$lhome_Number?></b></td>
                              <td width="40%" align="center"  class="tdhead"><b><?=$lhome_Commission?></b></td>
                     </tr>
                            <tr>
                              <td width="35%"  class="grid1"><?=$lang_report_click?>&nbsp;
							  <img alt="" border="0" height="8" src="../images/click.gif" width="8" /></td>
                                          <td width="26%" align="center" class="grid1" ><?=$total[0]?></td>
                                          <td width="39%" align="center"  class="grid1" ><?=$total[1]?> <?=$currSymbol?></td>
                            </tr>
                            <tr>
                              <td width="35%" class="grid1" height="20" ><?=$lang_report_lead?>&nbsp;
							  <img alt="" border="0" height="10" src="../images/lead.gif" width="10" /></td>
                              <td width="26%" align="center" class="grid1" ><?=$total[2]?></td>
                              <td width="39%" align="center" height="20" class="grid1"><?=$total[3]?> <?=$currSymbol?></td>
                            </tr>
                            <tr>
                              <td width="35%" class="grid1" height="20" ><?=$lang_report_sale?>&nbsp;
							  <img alt="" border="0" height="10" src="../images/sale.gif" width="10" /></td>
                             <td width="26%" align="center" class="grid1" ><?=$total[4]?></td>
                             <td width="39%" align="center"  height="20" class="grid1"><?=$total[5]?> <?=$currSymbol?></td>
                            </tr>
                            <tr>
                              <td width="35%" class="grid1"><?=$lhome_Imp?></td>
                              <td width="26%" align="center" class="grid1" ><?=$numRec?></td>
                              <td width="39%" align="center" height="20"class="grid1"><?=$total[14]?> <?=$currSymbol?></td>
                            </tr>
                            <tr>
                              <td width="35%" class="grid1"><?=$lhome_Approved?></td>
                              <td width="26%" align="center" class="grid1" ><?=$total[13]?></td>
                              <td width="39%" align="center" height="20"class="grid1"><?=$total[6]?> <?=$currSymbol?></td>
                            </tr>
                            <tr>
                              <td width="35%" class="grid1"><?=$lhome_Reversed?></td>
                              <td width="26%" align="center" class="grid1" ><?=$total[12]?></td>
                              <td width="39%" align="center" height="20"class="grid1"><?=$total[9]?> <?=$currSymbol?></td>
                            </tr>

                    </table>
                       <!-- close table 3-->


                 </td>
               </tr>
              <tr>
                   <td width="100%" height="20" colspan="3">

                   </td>
              </tr>

              <tr>
                  <td width="100%" height="20"  colspan="3" align="center" >


                </td>
              </tr>
</table>
              <!-- close table 1-->

           <?
           }
           ?><br />