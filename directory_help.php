<?php

     //include "../includes/admin_show_pagenos.php";

   $partners         =new partners;
   $partners->connection($host,$user,$pass,$db);


     function show_page_nos($sql,$url,$lines1,$page){

    $tmp	=explode("LIMIT",$sql);

    if(count($tmp)<1) $tmp	=explode("limit",$sql);
  	$pgsql	=$tmp[0];

    include 'includes/admin_show_pagenos.php';
  }

   /************************variables******************************************/
         $page              =trim($_GET['page']);                //page no
         $joinstatus        =trim($_GET['joinstatus']);          //joinpgm status
         $cat               =trim($_GET['category']);            //selected category
         $pgm       		=trim($_GET['pgm']);             //selected pgm
         $newpgm			=$pgm;
         //$searchtxt         =trim($_POST['searchtxt']);          //selected pgm(search)
		 $searchtxt         =trim(addslashes($_POST['searchtxt']));          //selected pgm(search)
   /****************************************************************************/



   /************************intialisation*****************************************/


         if(empty($joinstatus))
             $joinstatus="All";
         if(empty($page))                                 //getting page no
             $page=$partners->getpage();
    /***************************************************************************/





   /************serach query**************************************************/
    switch ($joinstatus)
    {
         case 'All':              //all pgms
           $sql="select * from partners_merchant,partners_program,partners_firstlevel where program_status like ('active') and firstlevel_programid=program_id    and merchant_id= program_merchantid		 ";
           break;


       case 'catwise':         //category wise seacrh
             $sql ="  select * from partners_merchant,partners_program,partners_firstlevel where program_status='active' ";
             if(!empty($cat))$sql.= " and merchant_category='$cat' ";
             $sql.= " and merchant_id=program_merchantid and  firstlevel_programid=program_id "   ;
             break;

       case 'pgmwise':       //pgm wise search
             $sql="select * from partners_merchant,partners_program,partners_firstlevel where program_id=$pgm and  firstlevel_programid=program_id  and merchant_id= program_merchantid "   ;
             break;

       case 'search':        //search particular pgm
             $sql="select * from partners_merchant,partners_program,partners_firstlevel where program_url like '%$searchtxt%' and program_status='active' and  firstlevel_programid=program_id  and merchant_id= program_merchantid "   ;
             break;


   }
  $lines1=$lines;


  if(!empty($SortBy))  $sql .= " order by $SortBy $OrderByValue ";
  $pgsql=$sql;
  $sql  .="LIMIT ".($page-1)*$lines1.",".$lines1;
  $ret   =mysql_query($sql);  
  /****************************************************************************/



   if(mysql_num_rows($ret)>0) {  //if records exists

        ?>

                 <form name="SearchResultsForm" method="post" action="affiliates_process.php?page=<?=$page?>&amp;joinstatus=<?=$joinstatus?>">
                 <table  cellpadding="1" cellspacing="0"  width="95%" class="tablewbdr" align="center" >



                       <?
                       while($row=mysql_fetch_object($ret))
					   {
					   		$saleType = $row->firstlevel_saletype;
							$saleRate = $row->firstlevel_salerate;
							if($saleType != '%')
							{
								$saleType = $currSymbol;
								$saleRate = number_format($saleRate,2);
							}
                           ?>
                          <tr>

                            <td width="25%"   height="20"><?=stripslashes($row->program_url)?></td>
                            <td width="20%"   align="center"  height="20"><?=$row->merchant_company?></td>
                            <td width="10%"  align="center"  height="20"><?=$currSymbol?><?=number_format($row->firstlevel_clickrate,2)?></td>
                            <td width="10%"  align="center"  height="20"><?=$currSymbol?><?=number_format($row->firstlevel_leadrate,2)?></td>
                            <td width="10%"  align="center" height="20"><?=$saleType?><?=$saleRate?></td>
                            <td width="20%"  align="center"  height="20"><?=$currSymbol?><?=number_format($row->firstlevel_impressionrate,2)."/".$row->firstlevel_unitimpression?></td>
                            <td width="5%"   align="center"  height="20"><a href="index.php?Act=affil_regi"><?=$directory_help_join?></a></td>

                           </tr>

                      <?
                      }
                      ?>

                   <tr>
                       <td width="100%" colspan="9" align="center" >
                     <?

      /*****************for page no**********************************************/

                       $url    ="index.php?Act=$Act&amp;category=$cat&amp;joinstatus=$joinstatus&amp;SortBy=$SortBy&amp;OrderBy=$OrderBy&amp;pgm=$pgm";    //adding page nos
                       show_page_nos($pgsql,$url,$lines1,$page);
                     //  include 'includes/show_pagenos.php';
     /************************************************************************/
                      ?>
                     </td>
                     </tr>


</table>

<?
}
else  //if no records
{
  ?>
  <table width="100%" align="center">
         <tr>
            <td align="center" class="red"><?=$norec?> </td>
         </tr>
   </table>
           <?
           }
         ?>
</form>