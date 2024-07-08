<?
  include "../merchants/transactions.php";
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
 include_once '../includes/session.php';





  $programs=trim($_POST['programs']);


  if(empty($_POST['programs']))
         {
           $programs=$_SESSION['PGMID'];
          }



  $sql="SELECT * from partners_program "; //adding to drop down box
  $result=mysql_query($sql);
  $ret=mysql_query($sql);
  $row=mysql_fetch_object($ret);
  $programid=$row->program_id;
   if (empty($programs))
           {
              $programs=$programid;
            }
  $pgmid=$programs;
  $_SESSION['PGMID']=$pgmid;


  switch ($programs)//checking program
      {

       default:    //selected pgm
           $sql="SELECT * from partners_joinpgm where joinpgm_programid=$programs";

           $pgmid=$programs;
           $_SESSION['PGMID']=$pgmid;

           $sqla="SELECT * FROM  partners_program where program_id='$pgmid'";
           $sqlb="SELECT * FROM  partners_pgmstatus where pgmstatus_programid='$pgmid'";
           $sqlc="SELECT * FROM  partners_secondlevel where secondlevel_programid ='$pgmid'";
           $sqld="select * FROM  partners_firstlevel where firstlevel_programid='$pgmid'";


           $flag=1;

            break;
      }
  $total=GetPaymentDetails($sql,'',$default_currency_caption); //getting payments (click,sale,lead) values
  $total =explode('~',$total);

  $afftotal=GetTotalAffiliates($sql); //getting total affiliates,waiting affiliates,transactions
  $afftotal =explode('~',$afftotal);

  $totallink=GetLinks($pgmid,$MERCHANTID);       //getting advertising links
  $totallink =explode('~',$totallink);


              if($flag==1)
              {
                  $pgmres=mysql_query($sqla);
                  $stares=mysql_query($sqlb);

                  $secres=mysql_query($sqlc);
                  echo mysql_error();
                  $fstres=mysql_query($sqld);

                  while ($pgmrow=mysql_fetch_object($pgmres))
                   {

                     $url                           =stripslashes(trim($pgmrow->program_url));
                     $description                   =stripslashes(trim($pgmrow->program_description));
                     $ip                            =stripslashes(trim($pgmrow->program_ipblocking));
                     $saletype                      =stripslashes(trim($pgmrow->program_saletype));
                     $status                        =stripslashes(trim($pgmrow->program_status));
                     //echo "$url,$description,$ip,$saletype,"."ss";

                   }

                     while ($starow=mysql_fetch_object($stares))
                   {


                       $stclick                       =stripslashes(trim($starow->pgmstatus_clickapproval));
                       $stlead                        =stripslashes(trim($starow->pgmstatus_leadapproval));
                       $stsale                        =stripslashes(trim($starow->pgmstatus_saleapproval));

                       $stmailaffiliate               =stripslashes(trim($starow->pgmstatus_mailaffiliate));
                       $stmailmerchant                =stripslashes(trim($starow->pgmstatus_mailmerchant));
                       $staffiliateapproval           =stripslashes(trim($starow->pgmstatus_affiliateapproval));

                        // echo "$click,$lead,$sale,$mailaffiliate,$mailmerchant,$affiliateapproval";

                     }

                      while ($fstrow=mysql_fetch_object($fstres))
                   {

                       //    firstlevel_salerate

                        $click                    =stripslashes(trim($fstrow->firstlevel_clickrate));
                        $lead                     =stripslashes(trim($fstrow->firstlevel_leadrate));
                        $sale                     =stripslashes(trim($fstrow->firstlevel_salerate));
                        $saletype                 =stripslashes(trim($fstrow->firstlevel_saletype));

                        //echo $click,$sale,$lead,$saletype;



                   }

                   if(mysql_num_rows($secres)>0)
                   {
                       while ($secrow=mysql_fetch_object($secres))
                   {
                        //$sclick                    =$secrow->secondlevel_clickrate;
                        //$slead                     =$secrow->secondlevel_leadrate;
                        $ssale                       =stripslashes(trim($secrow->secondlevel_salerate));
                        $st                          =stripslashes(trim($secrow->secondlevel_saletype));    /// error



                    }
                   }
                   else
                   {
                    $ssale    ="nill";
                  }


              } // closing




  ?>



  <DIV align=center>
  <CENTER>
  <TABLE border='1'  cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" width="98%" class="tablewbdr">
           <TBODY>
             <TR>
                   <TD align="center" height="1" noWrap><? echo "<p align='center' > <span class='textred'>$msg</span></p>";?></TD>
             </TR>
           </TBODY></TABLE></CENTER></DIV>
           <form name="Getprogram" method="POST">
                 <INPUT name=policybtn type=hidden value=1>
                 <INPUT name=aprdays type=hidden value=0>
                 <INPUT name=PID type=hidden>
                 <INPUT name=adtype type=hidden>
                 <INPUT name=adID type=hidden>
                 <INPUT name=proID type=hidden value=98>
                 <TABLE align=center border='0' cellpadding="0" cellspacing="0" width="80%">
                   <TBODY>
                   <TR>
                       <TD vAlign=top width="60%">
                             <TABLE align=center bgColor="#000000" border='0' cellPadding=1 cellspacing="0"  width="100%">
                                     <TBODY>
                                     <TR>
                                          <TD>
                                              <TABLE bgColor='#FFFFFF' border=1 cellPadding=5 cellspacing="0" width="624" style="border-collapse: collapse"  class="tablebdr" bordercolor="#FFFFFF">
                                                 <TBODY>
                                                      <TR bgColor="#ffcc33">
                                                          <TD width="70%" bgcolor="#FFFFFF" class="tdhead">
                                                          <B>Affiliate Program&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </B>
                                                              <select name="programs" onchange="document.Getprogram.submit()">

                                                                    <?  while($row=mysql_fetch_object($result))
                                                                        {
                                                                           if($programs=="$row->program_id")
                                                                                $programName="selected";
                                                                           else
                                                                                 $programName="";
                                                                   ?>
                                                               <option <?=$programName?> value="<?=$row->program_id?>">ID :<?=$row->program_id?>..<?=stripslashes($row->program_url)?> </option>
                                                               <?
                                                               }
                                                               ?>
                                                              </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
                                                            <TD align=right width="40%" bgcolor="#FFFFFF" class="tdhead">
                                                                <?
                                                                   if($status=="active")
                                                                       {
                                                                       ?>
                                                                       <a href="program_process.php?pgmstatus=Reject&programs=<?=$pgmid?>">Reject</a>
                                                                       <?
                                                                       }
                                                                   else
                                                                       {
                                                                       ?>
                                                                       <a href="program_process.php?pgmstatus=Approve&programs=<?=$pgmid?>">Approve</a>
                                                                       <?
                                                                       }

                                                                 ?>
                                                            &nbsp;</TD>
                                                      <TR>
                                                             <TD colspan="2" width="614">
                                                                   <TABLE border='0' cellPadding=2 cellspacing="0" width="100%" height="459" style="border-collapse: collapse" bgcolor="#FFFFFF" class="hdbdr">
                                                                      <TBODY>
                                                                      <TR>
                                                                          <TD bgColor='#FFFFFF' height=45 width="50%" class="grid1" align="left">
                                                                                 <DIV align=left><b>Registered Affiliates&nbsp; -<?=$afftotal[0]?></b></DIV>
                                                                          </TD>
                                                                         <TD bgColor='#FFFFFF' height=45 width="50%" class="grid1" align="left">
                                                                                 <p align="right"><b>Waiting Affiliates -<?=$afftotal[1]?> </b>
                                                                         </TD>
                                                                    </TR>
                                                                    <TR>
                                                                         <TD bgColor='#FFFFFF' colspan="2" height=45>
                                                                                 <DIV align=center><B>Program URL</B><br/>
                                                                                 <A href="<?=$url?>"><?=$url?> </A></DIV><br/>
                                                                         </TD>
                                                                    </TR>
                                                                    <TR>
                                                                         <TD align="center" bgColor='#FFFFFF' colspan="2" height="15" class="grid1">
                                                                                <DIV align=center><B>Description</B><br/></DIV>
                                                                         </TD>
                                                                    </TR>
                                                                    <TR>
                                                                         <TD align="center" bgColor='#FFFFFF' colspan="2" height="81" class="grid1">
                                                                                <textarea rows="4" name="S1" cols="51"><?=$description?></textarea>
                                                                         </TD>
                                                                    </TR>
                                                                    <TR>
                                                                         <TD colspan="2" height="81">
                                                                               <DIV align=center><CENTER>
                                                                                         <TABLE border='0' cellPadding=2 cellspacing="0" width="100%" class="tablewbdr" style="border-collapse: collapse" bordercolor="#111111">
                                                                                           <TBODY>
                                                                                                <TR bgColor="#cccccc">
                                                                                                       <TD align="center" bgcolor="#FFFFFF" colspan="4"><B>Commissions</B></TD>
                                                                                                </TR>
                                                                                                <TR bgColor='#cccccc'>
                                                                                                       <TD align="center" bgcolor="#FFFFFF" colspan="4">&nbsp;</TD>
                                                                                                </TR>
                                                                                                <TR bgColor='#cccccc'>
                                                                                                      <TD align="center" bgcolor="#FFFFFF" class="tdhead">
                                                                                                              <SPAN lang=bg><B>Type</B></SPAN>
                                                                                                      </TD>
                                                                                                      <TD align="center" bgcolor="#FFFFFF" class="tdhead"><B>
                                                                                                             <SPAN lang=bg>Commissions</SPAN></B>
                                                                                                      </TD>
                                                                                                      <TD align="center" bgcolor="#FFFFFF" class="tdhead"><B>
                                                                                                            <SPAN lang=bg>Approval</SPAN></B>
                                                                                                      </TD>
                                                                                                      <TD align="center" bgcolor="#FFFFFF" class="tdhead">
                                                                                                            <SPAN lang=bg><B>IP Blocking</B></SPAN>
                                                                                                      </TD>
                                                                                                </TR>
                                                                                                <TR>
                                                                                                      <TD bgColor="#FFFFFF" class="grid1">
                                                                                                           <IMG border='0' height=10 src="../images/click.gif" width=10>
                                                                                                           <SPAN lang=bg> </SPAN>- click</TD>
                                                                                                      <TD align="center" bgColor="#FFFFFF" class="grid1"><?="$".$click?></TD>
                                                                                                      <TD align="center" bgColor="#FFFFFF" class="grid1"><?=$stclick?></TD>
                                                                                                      <TD align="center" bgColor="#FFFFFF" class="grid1"><?=$ip?>
                                                                                                          <SPAN lang=bg></SPAN>minutes
                                                                                                      </TD>
                                                                                                </TR>
                                                                                                <TR>
                                                                                                      <TD bgColor="#FFFFFF">
                                                                                                          <IMG border='0' height=10 src="../images/lead.gif" width=10> - lead

                                                                                                      </TD>
                                                                                                      <TD align="center" bgColor="#FFFFFF"><?="$".$lead?></TD>
                                                                                                      <TD align="center" bgColor="#FFFFFF"><?=$stlead?></TD>
                                                                                                      <TD bgColor="#FFFFFF">&nbsp;</TD>
                                                                                               </TR>
                                                                                               <TR>
                                                                                                      <TD bgColor="#FFFFFF" class="grid1">
                                                                                                              <IMG border='0' height=10 src="../images/sale.gif" width=10> - sale
                                                                                                      </TD>
                                                                                                      <TD align="center" bgColor="#FFFFFF" class="grid1"><?=$saletype?><?=$sale?></TD>
                                                                                                      <TD align="center" bgColor="#FFFFFF" class="grid1"><?=$stsale?></TD>
                                                                                                      <TD align="center" bgColor="#FFFFFF" class="grid1">&nbsp;</TD>
                                                                                               </TR>
                                                                                               <TR>
                                                                                                      <TD bgColor='#FFFFFF' colspan="4">&nbsp;</TD>
                                                                                               </TR>
                                                                                               <TR>
                                                                                                      <TD bgColor='#FFFFFF' class="tdhead" colspan="5" >
                                                                                                      <p align="center"><b>Second Tire Commission</b></TD>

                                                                                               </TR>
                                                                                               <TR>
                                                                                                      <TD bgColor='#FFFFFF' colspan="4">
                                                                                                         <p align="center"></TD>
                                                                                               </TR>
                                                                                               <TR>
                                                                                                      <TD bgColor='#FFFFFF' class="grid1">
                                                                                                            <IMG border='0' height=10 src="../images/sale.gif" width=10> - sale</TD>
                                                                                                            <?
                                                                                                              if($ssale =="nill")
                                                                                                              {
                                                                                                              ?>
                                                                                                       <TD align="center" bgColor='#FFFFFF' class="grid1">No Second Tire Offering</TD>
                                                                                                       <TD align="right" bgColor='#FFFFFF' class="grid1">
                                                                                                       Add New</TD>
                                                                                                            <?
                                                                                                              }
                                                                                                              else
                                                                                                              {
                                                                                                            ?>
                                                                                                       <TD align="center" bgColor='#FFFFFF' class="grid1"><?=$st?><?=$ssale?>
                                                                                                       </TD>
                                                                                                       <TD align="right" bgColor='#FFFFFF' class="grid1">
                                                                                                       Edit</TD>
                                                                                                            <?
                                                                                                              }
                                                                                                            ?>


                                                                                                      <TD align="center" bgColor='#FFFFFF' class="grid1"></TD>
                                                                                                      <TD align="center" bgColor='#FFFFFF' class="grid1">&nbsp;</TD>
                                                                                               </TR>
                                                                                           </TBODY>
                                                                                          </TABLE>
                                                                               </CENTER></DIV>
                                                                         </TD>
                                                                    </TR>
                                                                    <TR>
                                                                         <TD bgColor='#FFFFFF' colspan="2" height=12>&nbsp;</TD>
                                                                    </TR>
                                                                    <TR>
                                                                          <TD bgColor='#FFFFFF' colspan="2" height=12 class="tdhead">
                                                                                 <p align="center"><B>Email&nbsp; and Program Settings</B></TD>
                                                                    </TR>
                                                                    <TR>
                                                                          <TD bgColor='#FFFFFF' colspan="2" height=12>
                                                                                 <DIV align=center>&nbsp;</DIV>
                                                                          </TD>
                                                                    </TR>
                                                                    <TR>
                                                                          <TD colspan="2" height="22">
                                                                                 <DIV align=center><CENTER>
                                                                                 <TABLE border='0' cellPadding=2 cellspacing="0" width="608" class="tablewbdr" style="border-collapse: collapse" bordercolor="#111111" height="85">
                                                                                       <TBODY>
                                                                                       <TR>
                                                                                             <TD bgColor='#FFFFFF' class=2text height="26" width="3"58>
                                                                                                         <p align="left"><SPAN class=2text>Send email to affiliate when transaction appears
                                                                                                         </SPAN><FONT face="Arial, Helvetica, sans-serif">
                                                                                                         <SPAN class=2text>: </SPAN></FONT></TD>
                                                                                             <TD bgColor='#FFFFFF' class=2text height="26"  width="24"2>
                                                                                                         <DIV align=left><span class="2text"><b>
                                                                                                          <?=$stmailaffiliate?></b></span></DIV>
                                                                                              </TD>
                                                                                       </TR>
                                                                                       <TR>
                                                                                              <TD bgColor='#FFFFFF' class=2text height=28 width="3"58>
                                                                                                          <SPAN class=2text>Send email to me when transaction appears</SPAN></TD>
                                                                                              <TD bgColor='#FFFFFF' class=2text height=28 width="24"2>
                                                                                                          <span class="2text"><b><?=$stmailmerchant?></b></span></TD>
                                                                                       </TR>
                                                                                       <TR>
                                                                                              <TD bgColor='#FFFFFF' class=2text height=19 width="3"58>Affiliate Approval</TD>
                                                                                              <TD bgColor='#FFFFFF' class=2text height=19 width="24"2>
                                                                                                     <FONT face="Arial, Helvetica, sans-serif"><SPAN class=2text><B><?=$staffiliateapproval?></B></SPAN></FONT></TD></TR></TBODY></TABLE></CENTER></DIV></TD></TR>
                                                                                                         <TABLE border='0' cellPadding=2 cellspacing="0" width=600 height="57" class="tablewbdr" style="border-collapse: collapse" bordercolor="#111111">
                                                                                                            <TBODY>
                                                                                                              <TR>
                                                                                                                  <TD bgColor='#FFFFFF' height=15>
                                                                                                                     <DIV align=center>&nbsp;<table border='0' cellpadding="0"  width="100%" class="tablewbdr" style="border-collapse: collapse" bordercolor="#111111" cellspacing="0">
                                                                                                              <TR>
                                                                                                                 <TD width="25%" class="tdhead" align="center" colspan="5">Advertising Links</TD>
                                                                                                              </TR>
                                                                                                              <TR height="20">
                                                                                                              <?
                                                                                                                          $tot=$totallink[0]+$totallink[1]+$totallink[2]+$totallink[3]+$totallink[4];
                                                                                                                          if($tot==0)
                                                                                                                                 {
                                                                                                                                  ?>
                                                                                                                                  <td width="20%" align="center" class="textred"  colspan="5" >No Links Added to This Program</td>
                                                                                                                                 <?
                                                                                                                                  }
                                                                                                                         else
                                                                                                                                 {
                                                                                                                                 ?>
                                                                                                                                 <td width="20%" align="center" class="grid1" ><a href="index.php?Act=add_text">Text - <?=$totallink[1]?></a></td>
                                                                                                                                 <td width="20%" align="center"class="grid1"  ><a href="index.php?Act=add_html">HTML - <?=$totallink[4]?></a></td>
                                                                                                                                 <td width="20%" align="center" class="grid1" ><a href="index.php?Act=add_banner">Banner -<?=$totallink[0]?></a></td>
                                                                                                                                 <td width="20%" align="center" class="grid1" ><a href="index.php?Act=add_popup">Popup - <?=$totallink[2]?></a></td>
                                                                                                                                 <td width="20%" align="center" class="grid1" ><a href="index.php?Act=add_flash">Flash - <?=$totallink[3]?></a></td>
                                                                                                                                 <?
                                                                                                                                 }  //// else close

                                                                                                                         ?>
                                                                                                              </TR>
                                                                                                         </table>
                                                                                                         </DIV>
                                                                                              </TD>
                                                                                       </TR>
                                                                                       </TBODY>
                                                                                 </TABLE>
                                                                                 </center></div>
                                                                          </TD>
                                                                    </TR>
                                                                   </TBODY>
                                                                   </TABLE>
                                                             </TD>
                                                      </TR>
                                                 </TBODY>
                                               </TABLE>
                                              </TD>
                                          </TR>
                                          </TBODY>
                             </TABLE>
                         </TD>
                       </TR>
                       </TBODY>
                 </TABLE><br/>
             </FORM>
<br/>

  <SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>

<!--

function del_onclick() {
if(confirm("Do you Want to Delete This Program"))
        {
                return true;
        }
        else
        {
        return false;
        }

}


       function help()
                {
                nw = open('secondtire.php','new','height=300>,width=400>,scrollbars=yes');
                nw.focus();
                }

//-->
</SCRIPT>