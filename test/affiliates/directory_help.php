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
         $pgm               =trim($_GET['pgm']);                 //selected pgm
         $searchtxt         =trim($_POST['searchtxt']);          //selected pgm(search)
   /****************************************************************************/



   /************************intialisation*****************************************/
         if(empty($joinstatus))
             $joinstatus=$_SESSION['JOINSTATUS'];          //checking status for search
         else
             $_SESSION['JOINSTATUS']=$joinstatus;

         if(empty($joinstatus))
             $joinstatus="All";
         if(empty($page))                                 //getting page no
             $page=$partners->getpage();
    /***************************************************************************/





   /************serach query**************************************************/
    switch ($joinstatus)
    {
       case 'All':              //all pgms
           	$sql="select * from partners_program,partners_firstlevel where program_status like ('active') and firstlevel_programid=program_id  		 ";
           	break;


       case 'catwise':         //category wise seacrh
             $sql="select * from partners_merchant,partners_program,partners_firstlevel where program_status='active' and merchant_category='$cat' and merchant_id=program_merchantid and  firstlevel_programid=program_id "   ;
             break;

       case 'pgmwise':       //pgm wise search
             $sql="select * from partners_program,partners_firstlevel where program_id=$pgm and  firstlevel_programid=program_id "   ;
             break;

       case 'search':        //search particular pgm
             $sql="select * from partners_program,partners_firstlevel where program_url like '%$searchtxt%' and program_status='active' and  firstlevel_programid=program_id "   ;
             break;

       case 'myprograms':     //search for only myprograms
             $sql="select * from partners_program,partners_firstlevel,partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID and joinpgm_programid=program_id and  firstlevel_programid=program_id "   ;
             break;

    }

  $lines1=2;
  $sql  .="LIMIT ".($page-1)*$lines1.",".$lines1;
  $ret   =mysqli_query($con,$sql);
  /****************************************************************************/



   if(mysqli_num_rows($ret)>0) {  //if records exists

        ?>

                 <form name="SearchResultsForm" method="POST" action="affiliates_process.php?page=<?=$page?>&joinstatus=<?=$joinstatus?>">
                 <table  cellpadding="1" cellspacing="0"  width="95%" class="tablewbdr" align="center" height="20">



                       <?
                       while($row=mysqli_fetch_object($ret)){
                           ?>
                          <tr>

                            <td width="30%"   height="20"><?=stripslashes($row->program_url)?></td>
                            <td width="20%"   align="center"  height="20"><?=$row->program_merchantid?></td>
                            <td width="10%"  align="center"  height="20">$<?=$row->firstlevel_clickrate?></td>
                            <td width="15%"  align="center"  height="20">$<?=$row->firstlevel_leadrate?></td>
                            <td width="10%"  align="center" height="20"><?=$row->firstlevel_saletype?><?=$row->firstlevel_salerate?></td>
                            <td width="15%"   align="center"  height="20"><a href="index.php?Act=affil_regi">Join</a></td>

                           </tr>

                   <?php
                    }
                    ?>

                   <tr>
                       <td width="100%" colspan="9" align="center" >
                     <?
      /*****************for page no**********************************************/
       switch ($joinstatus)
    {

         case 'All':
           $pgsql="select * from partners_program,partners_firstlevel where program_status like ('active') and firstlevel_programid=program_id ";
           break;

         case 'waiting':
           $pgsql         =" SELECT   * " ;
           $pgsql         =$pgsql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $pgsql         =$pgsql." WHERE joinpgm_status='waiting' and c.joinpgm_affiliateid=$AFFILIATEID and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
             break;

         case 'approved':
           $pgsql         =" SELECT   * " ;
           $pgsql         =$pgsql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $pgsql         =$pgsql." WHERE joinpgm_status='approved' and c.joinpgm_affiliateid=$AFFILIATEID and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
            break;

        case 'suspend':
           $pgsql         =" SELECT   * " ;
           $pgsql         =$pgsql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $pgsql         =$pgsql." WHERE joinpgm_status='suspend' and c.joinpgm_affiliateid=$AFFILIATEID and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
           break;

       case 'notjoined':
            $query="select * from partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID";
            $ret=mysqli_query($con,$query);

            // finding not joined pgms/////////////
            $a  ="(";
            $i  =1;
            while($row=mysqli_fetch_object($ret))
            {
              if (mysqli_num_rows($ret)==$i)
                 $a  =$a.$row->joinpgm_programid;
              else
                 $a  =$a.$row->joinpgm_programid.",";
              $i=$i+1;
            }
            $a  .= ")";
            ///////////////////////////////////////

            if (mysqli_num_rows($ret)==0)
                $pgsql="select * from partners_program,partners_firstlevel where program_status like ('active') and firstlevel_programid=program_id   ";
             else
                 $pgsql         ="select * from partners_program,partners_firstlevel where program_status like ('active') and program_id not in $a and  firstlevel_programid=program_id ";
             break;

          case 'catwise':
               $pgsql="select * from partners_merchant,partners_program,partners_firstlevel where program_status='active' and merchant_category='$cat' and merchant_id=program_merchantid and  firstlevel_programid=program_id "   ;
               break;

          case 'pgmwise':
               $pgsql="select * from partners_program,partners_firstlevel where program_id=$pgm and  firstlevel_programid=program_id "   ;
               break;

          case 'search':
               $pgsql="select * from partners_program,partners_firstlevel where program_url like '%$searchtxt%' and program_status='active' and  firstlevel_programid=program_id "   ;
               break;

          case 'myprograms':
               $pgsql="select * from partners_program,partners_firstlevel,partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID and joinpgm_programid=program_id and  firstlevel_programid=program_id "   ;
               break;

    }
                       $url    ="index.php?Act=$Act";    //adding page nos
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