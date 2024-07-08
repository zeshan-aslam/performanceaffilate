<?
    /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AFFILIATE REPORTS
      VARIABLES          :    	$page                     =page no
  							  	$MERCHANTID               =mercahnt id
        						$from                     =from date
                                $to                       =to date
                                $sub                      =submit button
                                $msg                      =errmsg
                                $affiliate                =affilaite name
                                $total                    =statistics
  //*************************************************************************************************/
?>
<script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.report.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.report.txtto,Date);
        }
</script>

  <?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/function1.php';
  include_once '../includes/session.php';
  include_once 'affiliate_payments.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    /************************variables*****************************************/
    $page                                =$partners->getpage();                 //page no
    $MERCHANTID                          =$_SESSION['MERCHANTID'];              //mercahnt id
    $from                                =trim($_POST['txtfrom']);              //from date
    $to                                  =trim($_POST['txtto']);                //to date
    $sub                                 =trim($_POST['sub']);                  //submit button
    $msg                                 =trim($_GET['msg']);                   //errmsg
    $affiliate                           =stripslashes(trim($_POST['search'])); //affilaite name

    $saletype		= trim($_POST['saletype']);
    $leadtype		= trim($_POST['leadtype']);
    $clicktype		= trim($_POST['clicktype']);

    /*************************************************************************/

    /**************************initialisation*********************************/
    if (empty($from))
        $from =trim($_GET['txtfrom']);

    if (empty($to))
        $to=trim($_GET['txtto']);

    if (empty($sub))
        $sub=trim($_GET['sub']);

     if (empty($affiliate))
        $affiliate=stripslashes(trim($_GET['search']));

     if(!empty($sub))   {

                  if(!$partners->is_date($from) || !$partners->is_date($to) )
                   {
                    $Err=$lang_report_err;

                   }
                   }
    /*************************************************************************/

 ?>


 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe>
 <br/>
  <form name="report" method="post" action="index.php?Act=AffiliateReport&amp;page=1">
  <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2"  align="center"><b>
             <?=$lang_report_stat?></b></td>
         </tr>
         <tr>
                  <td  height="19" colspan="2"  align="center" class="textred">
                 <?=$Err?></td>
         </tr>
                <tr>
                 <td  height="19" colspan="2"  align="center"><b>
                 <?=$lang_report_forperiod?></b></td>
        </tr>
            <tr>
                 <td width="50%" height="24" align="center">&nbsp; <?=$lang_report_from?></td>
                 <td width="50%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /></td>
            </tr>
            <tr>
                    <td width="50%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
                 <td width="50%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$to?>" onfocus="javascript:to_date();return false;" /></td>
            </tr>
            <tr>
                 <td height="23" colspan="2"  >&nbsp;</td>
            </tr>
        <tr>
             <td height="20" class="tdhead"  colspan="2"   align="center"><b><?=$lang_report_searchaff?></b></td>
        </tr>
            <tr>
                 <td height="13" colspan="2"  >&nbsp;</td>
            </tr>
            <tr>
                 <td  colspan="2"   align="center" height="27">
                 &nbsp;<input type="text" name="search" size="30" value="<?=$affiliate?>" /></td>
            </tr>

            <tr>
                 <td  colspan="2"   align="center" height="26">
                 <input type="submit" name="sub" value="<?=$lang_report_view?>" /></td>
            </tr>
  </table>
  </form>


  <?

   if(!empty($sub))   {

                if(!$partners->is_date($from) || !$partners->is_date($to) )
                {
                $Err                        ="Please Enter Valid Date" ;
                }

                else
                {
               $cFrom                        =$partners->date2mysql($from);  //change date format
               $cTo                          =$partners->date2mysql($to);
               //echo $affiliate;
               $search						=addslashes($affiliate);
               $sql                          ="SELECT * from partners_joinpgm j,partners_program p,partners_affiliate where program_merchantid='$MERCHANTID' and joinpgm_status not like ('waiting') and affiliate_company like('%$search%') and j.joinpgm_programid=p.program_id and affiliate_id=joinpgm_affiliateid ";
               $sql                         .="LIMIT ".($page-1)*$lines.",".$lines;
               $result                       =mysqli_query($con,$sql);
              // echo $sql;
               if (mysqli_num_rows($result)>0)
               {
               ?>
				 <p align="right">
					<a href="#" onClick="window.open('../print_affiliates.php?mid=<?=$MERCHANTID?>&search=<?=$affiliate?>&from=<?=$cFrom?>&to=<?=$cTo?>&currency=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_affiliates.php?mid=<?=$MERCHANTID?>&search=<?=$affiliate?>&from=<?=$cFrom?>&to=<?=$cTo?>&currency=<?=$currSymbol?>&currValue=<?=$currValue?>"><b>Export as CSV</b></a> &nbsp;&nbsp;&nbsp;	
				 </p>
                    <table border="0" cellpadding="1" cellspacing="1" width="95%" align="center" class="tablebdr1">
                        <tr>
                        <td width="25%" class="tdhead" align="center"><b><?=$lang_report_affiliate?></b></td>
                        <td width="5%"  class="tdhead" align="center"><b><?=$lang_report_pgm?></b></td>
                        <td width="15%" class="tdhead" align="center"><b><?=$lpgm_Impression?></b></td>
                        <td width="15%" class="tdhead" align="center"><b><?=$lang_report_click?></b></td>
                        <td width="15%" class="tdhead" align="center"><b><?=$lang_report_lead?></b></td>
                        <td width="15%" class="tdhead" align="center"><b><?=$lang_report_sale?></b></td>
                        <td width="25%" class="tdhead" align="center"><b><?=$lang_report_commission?></b></td>
                        </tr>
                        <?
                        while($row=mysqli_fetch_object($result)){

                            $total                        =GetPaymentDetails1($row->joinpgm_id,$cTo,$cFrom,$currValue,$default_currency_caption);   //getting pending,approved,paid amnts from GetPayments.php
                            $total                        =explode('~',$total);

                            $imp_count					  =   get_impression_count($row->joinpgm_programid,$row->joinpgm_merchantid,$row->joinpgm_affiliateid,$cFrom,$cTo);
                         ?>
                       <tr  class="grid1">


                        <td width="25%" height="25" align="center" ><?=stripslashes(trim($row->affiliate_company))?></td>
                        <td width="5%" height="25" align="center"><a href='index.php?Act=programs&mode=editprogram&programId=<?=$row->joinpgm_programid?>'><?=stripslashes($row->program_url)?></a></td>
                        <td width="15%" height="25" align="center" ><?=$imp_count?></td>
                        <td width="15%" height="25" align="center" ><?=$total[0]?></td>
                        <td width="15%" height="25" align="center" ><?=$total[1]?></td>
                        <td width="15%" height="25" align="center" ><?=$total[2]?></td>
                        <td width="10%" height="25" align="center" ><?=$total[3]?> <?=$currSymbol?></td>
                        </tr>

                        <?php
                          }
                        ?>
                    <tr>
                    <td colspan="7" align="center" class="grid1">
                           <?
                           $pgsql                        ="SELECT * from partners_joinpgm j,partners_program p,partners_affiliate where program_merchantid='$MERCHANTID' and joinpgm_status not like ('waiting') and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$search%') and j.joinpgm_programid=p.program_id and affiliate_id=joinpgm_affiliateid ";
                           $url                          ="index.php?Act=AffiliateReport&amp;sub=$sub&amp;txtfrom=$from&amp;txtto=$to&amp;search=$affiliate";    //adding page nos
                           include '../includes/show_pagenos.php';
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
                        <td align="center" class="red"><?=$lang_report_no_rec?> </td>
                     <tr>
                     </table>
                      <?
                 }
  }
      }
  ?><br />