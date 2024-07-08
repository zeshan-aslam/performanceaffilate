<?php
   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES DETAILS
      VARIABLES          :      $MERCHANTID       =merchantid
              					$page             =page no
                                $status           =aff status
                                $affid            =for view profile
                                $loginflag        =differentiating affilaite 'a'
                                $mode             =selected action
                                $pgmname          =program url
  *************************************************************************************************/

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once 'transactions.php';

  $partners         =new partners;
  $partners->connection($host,$user,$pass,$db);
  $sortarray	    = array();
  /******************variables*************************************************/
         $MERCHANTID       = $_SESSION['MERCHANTID'];       //merchantid
         $page             = intval(trim($_GET['page']));           //page no
         $status           = trim($_GET['status']);         //status
         $affid            = trim($_GET['affid']);          // for view profile
         $loginflag        = trim($_GET['loginflag']);      //differentiating affilaite 'a'
         $mode             = trim($_GET['mode']);           //selected action
         $pgmname          = trim($_GET['pgmname']);        //program url
  /****************************************************************************/

         $OrderBy =trim(stripslashes($_GET['OrderBy']));
    	 if(empty($OrderBy))   $OrderByValue ="SORT_DESC";
    	 if($OrderBy=="SORT_DESC")
    		{
    		$image="../images/up.gif";
    		$OrderByValue ="SORT_ASC"  ;
    		}
   		 else
    		{
             $OrderByValue ="SORT_DESC"  ;
              $image="../images/dawn.gif";
      		 }

  $image1="../images/normal.gif";
  /*********************initialisation*****************************************/
  if(empty($page))                                        //getting page no
    $page           =$partners->getpage();
 if(empty($status))                                       //setting for status
     $status=$_SESSION['SESSIONSTATUS'];
  else
     $_SESSION['SESSIONSTATUS']=$status;
 /*****************************************************************************/




 /********************view profile&reject affilaite***************************/
  if ($_GET['mode']=='ViewProfile'  || $_GET['mode']=='Reject' )
        {
        if ($_GET['mode']=='ViewProfile')
               {
                $pageurl    ="viewprofile_affiliate.php?";
                $h          ="400";
                $w          ="450";
               }
         else if( $_GET['mode']=='Reject')
                     {
                $pageurl   ="remove_affiliate.php?loginflag=$loginflag&mode=$mode&pgmname=$pgmname";
                $h         ="400";
                $w         ="450";

            }

 ?>

     <script language="javascript" type="text/javascript">
       help();
       function help()
                {
                nw = open('<?=$pageurl?>&id=<?=$affid?>','new','height=<?=$h?>,width=<?=$w?>,scrollbars=no');
                nw.focus();
                }
    </script>
  <?

   }  ///// if close
   /***************************************************************************/


  if(empty($status)) $status= "all";


  /*************************search depending on status************************/
  switch ($status)   //joinpgm status
    {
    case 'all':
           $sql         =" SELECT  ( c.joinpgm_id ),a.affiliate_id, a.affiliate_firstname, a.affiliate_company,c.joinpgm_status,c.joinpgm_programid, p.program_url" ;
           $sql         =$sql." FROM partners_affiliate a, partners_joinpgm c, partners_program p";
           $sql         =$sql." WHERE c.joinpgm_merchantid=$MERCHANTID and c.joinpgm_affiliateid = a.affiliate_id and c.joinpgm_programid = p.program_id" ;
           //echo $sql;
           break;
    case 'waiting':
           $sql         =" SELECT   ( c.joinpgm_id ),a.affiliate_id, a.affiliate_firstname, a.affiliate_company,c.joinpgm_status,c.joinpgm_programid,  p.program_url" ;
           $sql         =$sql." FROM partners_affiliate a, partners_joinpgm c, partners_program p";
           $sql         =$sql." WHERE joinpgm_status='waiting' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id and c.joinpgm_programid = p.program_id" ;
           break;
    case 'approve':
           $sql        =" SELECT  ( c.joinpgm_id ),a.affiliate_id, a.affiliate_firstname, a.affiliate_company,c.joinpgm_status,c.joinpgm_programid, p.program_url " ;
           $sql        =$sql." FROM partners_affiliate a, partners_joinpgm c, partners_program p";
           $sql        =$sql." WHERE joinpgm_status='approved' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id and c.joinpgm_programid = p.program_id" ;
           break;
    case 'pending':
           $sql        =" SELECT  distinct( c.joinpgm_id) ,a.affiliate_id, a.affiliate_firstname, a.affiliate_company, c.joinpgm_status,c.joinpgm_programid ,  p.program_url" ;
           $sql        =$sql." FROM partners_affiliate a, partners_joinpgm c, partners_transaction e, partners_program p";
           $sql        =$sql." WHERE e.transaction_status =  'pending' and c.joinpgm_merchantid='$MERCHANTID' AND  e.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_affiliateid = a.affiliate_id  and c.joinpgm_programid = p.program_id" ;
           //echo "$sql";
           break;
    case 'suspend':
           $sql        =" SELECT  ( c.joinpgm_id ),a.affiliate_id,a.affiliate_company, a.affiliate_lastname,c.joinpgm_status,c.joinpgm_programid,  p.program_url" ;
           $sql        =$sql." FROM partners_affiliate a, partners_joinpgm c, partners_program p";
           $sql        =$sql." WHERE joinpgm_status='suspend' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id and c.joinpgm_programid = p.program_id" ;
           break;

    }
   /***************************************************************************/

   if(!empty($affiliatename)){
    			$affiliatename1	 = addslashes($affiliatename);
    			$sql            .= " and (affiliate_company) like('%$affiliatename1%') ";
            }

  $pgsql = $sql;
  $sql.=" LIMIT ".($page-1)*$lines.",".$lines;
  $ret =mysqli_query($con,$sql);
  if(mysqli_num_rows($ret)){

        ?>   <br/>
            <table border="0" cellpadding="1" cellspacing="1" width="95%" align="center"class="tablebdr">
                <tr>
                <td width="5%" class="tdhead" align="center" colspan="2" ><?=$laff_Status?></td>
                  <td width="25%" class="tdhead" align="center">
                <?if($SortBy=="affiliate"){?>
                          <a href="index.php?Act=affiliates&amp;SortBy=affiliate&amp;OrderBy=<?=$OrderByValue?>&amp;page=<?=$page?>&amp;status=<?=$status?>&amp;affiliate=<?=$affiliatename?>"><img src="<?=$image?>" height="10" width="10" border="0" alt=""/><?=$laff_Affiliate?></a>
                          <?}else{?>
                            <a href="index.php?Act=affiliates&amp;SortBy=affiliate&amp;OrderBy=<?=$OrderByValue?>&amp;page=<?=$page?>&amp;status=<?=$status?>&amp;affiliate=<?=$affiliatename?>"><img src="<?=$image1?>" height="10" width="10" border="0" alt=""/><?=$laff_Affiliate?></a>
                          <?}?>
               </td>
                <td width="5%" class="tdhead" align="center">
                 <?if($SortBy=="pgmid"){?>
                          <a href="index.php?Act=affiliates&amp;SortBy=pgmid&amp;OrderBy=<?=$OrderByValue?>&amp;page=<?=$page?>&amp;status=<?=$status?>&amp;affiliate=<?=$affiliatename?>"><img src="<?=$image?>" height="10" width="10" border="0" alt=""/><?=$laff_PGMID?></a>
                  <?}else{?>
                            <a href="index.php?Act=affiliates&amp;SortBy=pgmid&amp;OrderBy=<?=$OrderByValue?>&amp;page=<?=$page?>&amp;status=<?=$status?>&amp;affiliate=<?=$affiliatename?>"><img src="<?=$image1?>" height="10" width="10" border="0" alt=""/><?=$laff_PGMID?></a>
                          <?}?></td>
               <!-- <td width="15%" class="tdhead" align="middle"><?=$laff_Approved?></td>-->
                <td width="5%" class="tdhead" align="center">
                <?if($SortBy=="pending"){?>
                          <a href="index.php?Act=affiliates&amp;SortBy=pending&amp;OrderBy=<?=$OrderByValue?>&amp;page=<?=$page?>&amp;status=<?=$status?>&amp;affiliate=<?=$affiliatename?>"><img src="<?=$image?>" height="10" width="10" border="0" alt=""/><?=$laff_Pending?></a>
                 <?}else{?>
                            <a href="index.php?Act=affiliates&amp;SortBy=pending&amp;OrderBy=<?=$OrderByValue?>&amp;page=<?=$page?>&amp;status=<?=$status?>&amp;affiliate=<?=$affiliatename?>"><img src="<?=$image1?>" height="10" width="10" border="0" alt=""/><?=$laff_Pending?></a>
                          <?}?></td>
                 <td width="5%" class="tdhead" align="center">
                <?if($SortBy=="paid"){?>
                          <a href="index.php?Act=affiliates&amp;SortBy=paid&amp;OrderBy=<?=$OrderByValue?>&amp;page=<?=$page?>&amp;status=<?=$status?>&amp;affiliate=<?=$affiliatename?>"><img src="<?=$image?>" height="10" width="10" border="0" alt=""/><?=$laff_Paid?></a>
                 <?}else{?>
                            <a href="index.php?Act=affiliates&amp;SortBy=paid&amp;OrderBy=<?=$OrderByValue?>&amp;page=<?=$page?>&amp;status=<?=$status?>&amp;affiliate=<?=$affiliatename?>"><img src="<?=$image1?>" height="10" width="10" border="0" alt=""/><?=$laff_Paid?></a>
                          <?}?></td>

               <!-- <td width="10%" class="tdhead" align="middle"><?=$laff_Paid?></td>  -->
                <td width="15%" class="tdhead" align="center"><?=$laff_Action?></td>
                </tr>


        <?
                $gridcounter=0;
                while($row=mysqli_fetch_object($ret)){

                      $total        =GetPaymentStaus1($row->joinpgm_id,$currValue,$default_currency_caption);  //getting pending,approved,paid amnts from GetPayments.php
                      $total        =explode('~',$total);
                      $status1      =stripslashes(trim($row->joinpgm_status));             //setting picture
                      $gridcounter  =$gridcounter+1;
                      $affiliate	= stripslashes($row->affiliate_company) ;
                      $pgmid		= $row->joinpgm_programid ;
                      $pgm			= stripslashes($row->program_url) ;
                      $id	   		= $row->affiliate_id ;
                      $joinid	  	= $row->joinpgm_id ;
                      $pending      = $total[1];
                      $paid		    = $total[0];
                      $sortarray[$gridcounter] =  array("idkey" => "$id","joinidkey" => "$joinid","affiliatekey" => "$affiliate", "pgmidkey" => "$pgmid","pendingkey" => "$pending","paidkey" => "$paid","statuskey" => "$status1","pagekey" => "$page", "programkey"=>"$pgm");

       }

        foreach ($sortarray as $key => $row2) {
   							$idkey[$key] 		    	= $row2["idkey"];
   						    $joinidkey[$key] 			= $row2["joinidkey"];
                            $affiliatekey[$key] 		= $row2["affiliatekey"];
                            $pgmidkey[$key] 	  		= $row2["pgmidkey"];
                            $pendingkey[$key] 	 		= $row2["pendingkey"];
                            $statuskey[$key] 			= $row2["statuskey"];
                            $paidkey[$key] 		   		= $row2["paidkey"];
                            $pagekey[$key] 		   		= $row2["pagekey"];
                            $programkey[$key] 		   		= $row2["programkey"];
							}
 // $sortarray[$gridcounter] =  array("id" => "$id","joinid" => "$joinid","affiliate" => "$affiliate", "pgmid" => "$pgmid","pending" => "$pending","status" => "$status1");

            switch($SortBy)
            {
            case "affiliate" :
                    Switch($OrderByValue)
                    {
                         case 'SORT_ASC':
             				array_multisort($affiliatekey,SORT_ASC, $sortarray);
                    		break;
                         case 'SORT_DESC':
             				array_multisort($affiliatekey,SORT_DESC, $sortarray);
                    		break;
                    }
            break;

            case "pgmid" :
                    Switch($OrderByValue)
                    {
                         case 'SORT_ASC':
             				array_multisort($programkey,SORT_ASC, $sortarray);
                    		break;
                         case 'SORT_DESC':
             				array_multisort($programkey,SORT_DESC, $sortarray);
                    		break;
                    }
            break;
             case "pending" :
                    Switch($OrderByValue)
                    {
                         case 'SORT_ASC':
             				array_multisort($pendingkey,SORT_ASC, $sortarray);
                    		break;
                         case 'SORT_DESC':
             				array_multisort($pendingkey,SORT_DESC, $sortarray);
                    		break;
                    }
            break;

            case "paid" :
                    Switch($OrderByValue)
                    {
                         case 'SORT_ASC':
             				array_multisort($paidkey,SORT_ASC, $sortarray);
                    		break;
                         case 'SORT_DESC':
             				array_multisort($paidkey,SORT_DESC, $sortarray);
                    		break;
                    }
            break;
           }


      function test_print($sortarray, $key,$laff_SelectAction) {
		  $arr_val = explode("~*",$laff_SelectAction);
		  $laff_SelectAction = $arr_val[0];
		  $currSymbol  = $arr_val[1];
	  ?>

                 <tr  class="grid1">
                 <td width="2%" height="25" align="center" >
                 <?
                 if($sortarray["pendingkey"]>0) //checking for pending transactions
                    {
                    ?>
                    <img alt=" " border="0" height="16" src="../images/pending.gif" width="16" />
                   <?
                     }
                    ?>
                </td>
                <td width="2%" height="25" align="center"  >
				<img alt="" border="0" height="16" src="../images/<?=$sortarray["statuskey"]?>.gif" width="16" />

                 </td>
                <td width="25%" height="25" align="center"><a href="index.php?Act=affiliate_page&amp;aid=<?=$sortarray["idkey"]?>"><?=$sortarray["affiliatekey"]?></a></td>
                <td width="5%" height="25" align="center"><a href='index.php?Act=programs&mode=editprogram&programId=<?=$sortarray["pgmidkey"]?>'><?=$sortarray["programkey"]?></a></td>

                <td width="15%" height="25" align="center" ><?=$currSymbol?><?=number_format($sortarray["pendingkey"],2)?> </td>
                <td width="15%" height="25" align="center" ><?=$currSymbol?><?=number_format($sortarray["paidkey"],2)?> </td>

                <td width="15%" height="25" align="center" ><?


                  $Approve          =$sortarray["joinidkey"]."~Approve"."~".$sortarray["idkey"];
                  $Reject           =$sortarray["joinidkey"]."~Reject"."~".$sortarray["idkey"] ;
                  $ViewProfile      =$sortarray["joinidkey"]."~ViewProfile"."~".$sortarray["idkey"]  ;
                  $Suspend          =$sortarray["joinidkey"]."~Suspend"."~".$sortarray["idkey"];  ;

                ?>
                <form name="f<?=$sortarray["joinidkey"]?>" action="affiliate_actions.php?page=<?=$sortarray["pagekey"]?>" method="post">
                <select name="selaction" onchange="document.f<?=$sortarray["joinidkey"]?>.submit()">
                <option value="Select Action"><?=$laff_SelectAction?></option>
                <? if($sortarray["statuskey"]=='waiting' || $sortoption["statuskey"]=='suspend' )
                        {
                        ?>
                        <option value="<?=$Approve?>">Approve</option>
                    <?
                    }
                if($sortarray["statuskey"]=='waiting')
                        {
                        ?>
                        <option value="<?=$Reject?>">Reject</option>
                         <?
                        }
                       ?>
                <option value="<?=$ViewProfile?>">ViewProfile</option>
                <?
                 if($sortarray["statuskey"]=='approved' )
                        {
                          ?>
                        <option value="<?=$Suspend?>">Suspend</option>

                         <?
                         }
                         ?>
                </select>  </form></td>

                </tr>     <?
         }


			$lang_param =  $laff_SelectAction."~*".$currSymbol;
    		if(!empty($sortarray))  array_walk ($sortarray, 'test_print',$lang_param);

        ?>

              <tr>
              <td width="100%" colspan="7" align="center" class="grid1">
                <?
                $url    ="index.php?Act=affiliates&amp;status=$status&amp;affiliate=$affiliatename";    //adding page nos
                include '../includes/show_pagenos.php';
                //include 'user_log_file.php';      */
            ?>
            </td>
            </tr>
          </table>

                <?php
        }else
          {
          ?>
         <table width="100%" align="center">
         <tr>
            <td align="center" class="red">
			<?=($mode!="ViewProfile"?$norec:"") ?>  </td>
         <tr>
         </table>
          <?
            }
          ?><br />
<script language="javascript" type="text/javascript">

       function viewLink(affiliateid)
                {

                   url     ="viewprofile_affiliate.php?id="+affiliateid;
                   nw      = open(url,'new','height=400,width=450,scrollbars=no');
                   nw.focus();
                }

  </script>