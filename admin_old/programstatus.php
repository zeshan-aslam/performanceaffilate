<?

     /*****************************list affiliate pgms*******************/
         $pgmstatus=$_GET['pgmstatus'];
         if(empty($pgmstatus))
                $pgmstatus		='active'  ;    //setting for status
          if(empty($page))                               //getting page no
                  $page         =$partners->getpage();



          switch ($pgmstatus) {

	            case 'inactive':        //waiting affiliates

                        $pic         ="waiting";
                        $sql         =" SELECT   * " ;
                        $sql         =$sql." FROM partners_program ,partners_merchant ";
          			    $sql         =$sql." WHERE program_status='inactive' and merchant_id=program_merchantid  order by merchant_firstname  " ;
	                   break;


	            case 'active':        //approved affiliates
                       $pic         ="approved";
                       $sql         =" SELECT   * " ;
                       $sql         =$sql." FROM partners_program ,partners_merchant ";
           			   $sql         =$sql." WHERE program_status='active' and merchant_id=program_merchantid order by merchant_firstname  " ;
	                   break;

         }
       /*******************************************************************/
      $sql1	 =$sql;
      $sql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
      $ret        =mysqli_query($con,$sql);
?>

<br/>
<?
 /*******************if any records found*******************************/
  if(mysqli_num_rows($ret)){

?>
	        <table border='0' cellpadding="2" cellspacing="0" width="95%" class="tablebdr">
	              <tr >
	                <td class="tdhead" align="center" colspan="2" height="10" ><b>Program</b></td>
	                <td width="17%" class="tdhead" align="center"><b>Merchant</b></td>
	                <td width="11%" class="tdhead" align="center"><b>Products</b></td>
	                <td width="9%" class="tdhead" align="center"><b>Banner</b></td>
	                <td width="9%" class="tdhead" align="center"><b>Text</b></td>
	                <td width="9%" class="tdhead" align="center"><b>Popup</b></td>
	                <td width="9%" class="tdhead" align="center"><b>Flash</b></td>
	                <td width="9%" class="tdhead" align="center"><b>Html</b></td>
					<td width="11%" class="tdhead" align="center"><b>Template</b></td>
              </tr>

                    <tr>

	                <td  align="center" colspan="9" height="10"></td>

	                </tr>
                    <?
                       $LINKS			=GetLinks($sql);
                       $Link   			=explode("^",$LINKS);

    				 //  echo $TOTALREC  	=count($Link)-1;
                       $i				=1;
                      while($row=mysqli_fetch_object($ret))
                      {

                        $total=explode("~",$Link[$i]);   //getting statistics
                    ?>
                    <tr  >
                    	<td   align="left" colspan="2" height="10">
						<img alt="" border='0' height="24" src="../images/<?=$pic?>.gif" width="24" /> 
						<a href="index.php?Act=programs&amp;programId=<?=$row->program_id?>"><?=stripslashes($row->program_url)?></a> </td>
	                    <td width="17%"  align="center"  height="20"><?=stripslashes($row->merchant_company)?></td>
	                    <td width="11%"  align="center"  height="20">
                                <table border='0' class="tablewbdr">
	                                      <tr>
	                                        <td ><img alt="" border='0' height="16" width="16" src="<?=($total[10]>0 ? '../images/aniwaiting.gif' : '../images/waiting.gif' )?>" /></td>
	                                        <td><a href="index.php?Act=products&amp;pgmid=<?=$row->program_id?>&amp;status=Inactive"><?=$total[10]?></a>
	                                        </td>
	                                     </tr>
	                                     <tr>
	                                        <td ><img alt="" border='0' height="24" width="24" src="../images/approved.gif" /></td>
	                                        <td ><a href="index.php?Act=products&amp;pgmid=<?=$row->program_id?>&amp;status=Active"><?=$total[11]?></a>
	                                       </td>
	                                     </tr>
                          </table>
                      </td>
	                    <td width="9%"  align="center"  height="20">
	                            <table border='0' class="tablewbdr">
	                                      <tr>
	                                        <td ><img alt="" border='0' height="16" width="16" src="<?=($total[0]>0 ? '../images/aniwaiting.gif' : '../images/waiting.gif' )?>" /></td>
	                                        <td><a href="index.php?Act=add_banner&amp;programid=<?=$row->program_id?>&amp;adstatus=inactive"><?=$total[0]?></a>
	                                        </td>
	                                     </tr>
	                                     <tr>
	                                        <td ><img alt="" border='0' height="24" width="24" src="../images/approved.gif" /></td>
	                                        <td ><a href="index.php?Act=add_banner&amp;programid=<?=$row->program_id?>&amp;adstatus=active"><?=$total[5]?></a>
	                                       </td>
	                                     </tr>
                          </table>
                      </td>
	                    <td width="9%"  align="center"  height="20">
	                            <table border='0' class="tablewbdr">
	                                      <tr>
	                                        <td ><img alt="" border='0' height="16" width="16" src="<?=($total[12]>0 ? '../images/aniwaiting.gif' : '../images/waiting.gif' )?>" /></td>
	                                        <td><a href="index.php?Act=add_text1&amp;programid=<?=$row->program_id?>&amp;adstatus=inactive"><?=$total[12]?></a>
	                                        </td>
	                                     </tr>
	                                     <tr>
	                                        <td ><img alt="" border='0' height="24" width="24" src="../images/approved.gif" /></td>
	                                        <td ><a href="index.php?Act=add_text1&amp;programid=<?=$row->program_id?>&amp;adstatus=active"><?=$total[13]?></a>
	                                       </td>
	                                     </tr>
                          </table>
                      </td>
	                    <td width="9%"  align="center"  height="20">
	                             <table border='0' class="tablewbdr">
	                                      <tr>
	                                        <td ><img alt="" border='0' height="16" width="16" src="<?=($total[2]>0 ? '../images/aniwaiting.gif' : '../images/waiting.gif' )?>" /></td>
	                                        <td><a href="index.php?Act=add_popup&amp;programid=<?=$row->program_id?>&amp;adstatus=inactive"><?=$total[2]?></a>
	                                        </td>
	                                     </tr>
	                                     <tr>
	                                        <td ><img alt="" border='0' height="24" width="24" src="../images/approved.gif" /></td>
	                                        <td ><a href="index.php?Act=add_popup&amp;programid=<?=$row->program_id?>&amp;adstatus=active"><?=$total[7]?></a>
	                                       </td>
	                                     </tr>
	                             </table>
                      </td>
	                    <td width="9%"  align="center"  height="20">
	                        <table border='0' class="tablewbdr">
	                                    <tr>
	                                        <td ><img alt="" border='0' height="16" width="16" src="<?=($total[3]>0 ? '../images/aniwaiting.gif' : '../images/waiting.gif' )?>" /></td>
	                                        <td><a href="index.php?Act=add_flash&amp;programid=<?=$row->program_id?>&amp;adstatus=inactive"><?=$total[3]?></a>
	                                        </td>
                              </tr>
	                                     <tr>
	                                        <td ><img alt="" border='0' height="24" width="24" src="../images/approved.gif" /></td>
	                                        <td ><a href="index.php?Act=add_flash&amp;programid=<?=$row->program_id?>&amp;adstatus=active"><?=$total[8]?></a>
	                                       </td>
	                                     </tr>
                          </table>
                      </td>
	                    <td width="9%"  align="center"  height="20">
	                             <table border='0' class="tablewbdr">
	                                     <tr>
	                                        <td ><img alt="" border='0' height="16" width="16" src="<?=($total[4]>0 ? '../images/aniwaiting.gif' : '../images/waiting.gif' )?>" /></td>
	                                        <td><a href="index.php?Act=add_html&amp;programid=<?=$row->program_id?>&amp;adstatus=inactive"><?=$total[4]?></a>
	                                        </td>
	                                     </tr>
	                                     <tr>
	                                        <td ><img alt="" border='0' height="24" width="24" src="../images/approved.gif" /></td>
	                                        <td ><a href="index.php?Act=add_html&amp;programid=<?=$row->program_id?>&amp;adstatus=active"><?=$total[9]?></a>
	                                       </td>
	                                     </tr>
	                             </table>
                      </td>
						<!--  Added for Template Text -->
	                    <td width="11%"  align="center"  height="20">
	                            <table border='0' class="tablewbdr">
	                                      <tr>
	                                        <td ><img alt="" border='0' height="16" width="16" src="<?=($total[1]>0 ? '../images/aniwaiting.gif' : '../images/waiting.gif' )?>" /></td>
	                                        <td><a href="index.php?Act=add_text&amp;programid=<?=$row->program_id?>&amp;adstatus=inactive"><?=$total[1]?></a>
	                                        </td>
	                                     </tr>
	                                     <tr>
	                                        <td ><img alt="" border='0' height="24" width="24" src="../images/approved.gif" /></td>
	                                        <td ><a href="index.php?Act=add_text&amp;programid=<?=$row->program_id?>&amp;adstatus=active"><?=$total[6]?></a>
	                                       </td>
	                                     </tr>
                          </table>
                      </td>
						
                    </tr>
                    <tr >
                        <td colspan="10" class="grid1">&nbsp;
                        </td>
                    </tr>

                    <?
                    $i=$i+1;
                    }
                    ?>
                    <tr >
                        <td colspan="10" align="center">
                    <?


                      $pgsql =$sql1;
                      $url    ="index.php?Act=status&amp;pgmstatus=$pgmstatus";    //adding page nos
                      include '../includes/show_pagenos.php';
                    ?>
                    </td>
                    </tr>
	        </table>
 <?
 }else {
 ?>
   <table width="100%" align="center">
    <tr>
       <td align="center" class="textred">Sorry, no program(s) found </td>
    </tr>
    <tr>
        <td></td>
    </tr>
   </table>
 <?
 }
 ?>
 <br />