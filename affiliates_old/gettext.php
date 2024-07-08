<?

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';

   if(empty($page))                               //getting page no
        $page        =$partners->getpage();


   $sql   = "SELECT  joinpgm_programid, program_url FROM partners_joinpgm, partners_program
            WHERE joinpgm_affiliateid =  '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved'  AND program_id=joinpgm_programid "; //adding to drop down box

  $result = mysqli_query($con,$sql);
  
  if(mysqli_num_rows($result)<"1")
  {

   echo "<p>&nbsp;</p>
                                                     <table border='0' align='center' cellpadding='0' cellspacing='0' style='border-collapse: collapse'  width='96%' id='AutoNumber1' class='tablebdr'>
                                                             <tr>
                                                               <td width='100%' class='tdhead'>
                                                               &nbsp;</td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%' align='center'>
                                                               <font size='4'>$lang_notjoined</font></td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%'>
                                                               &nbsp;</td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%'>
                                                               <h5 align='center'><a href='index.php?Act=Affiliates&joinstatus=notjoined'> click here to Join</a></td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%' class='tdhead'>
                                                               &nbsp;</td>
                                                             </tr>
                                                           </table> ";

                                                           exit;
  } ///closing of if list populating ;

  /////////////////////////////




  $programs = intval(trim($_POST['programs']));
   if(empty($programs))
        $programs = intval(trim($_GET['programs']));



     if (empty($programs))
           {

              $programs="All";
               $link=0;

            }



  //$sql="SELECT * from partners_program where program_merchantid=$MERCHANTID"; //adding to drop down box
  //$result=mysqli_query($con,$sql);

  switch ($programs)//checking program
      {
       case 'All';    //all pgm
           $bsql="SELECT * FROM partners_text_old,partners_joinpgm  where	text_status ='active' and joinpgm_affiliateid = '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' AND joinpgm_programid=text_programid " ;
           $pgmid=0;
            $link=0;

           $allresult="--";
           $flag=0;

           break;
       default:    //selected pgm
           $bsql="SELECT * FROM partners_text_old where text_programid ='$programs' and text_status ='active'	";

        // $bresult=mysqli_query($con,$bsql);

      }








  include 'getadd.php'


 ?>
<form name="f1" action="index.php?Act=gettext" method="post">
 <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  align="center" width="78%"  >
    <tr>
      <td width="1%" height="3"></td>
      <td width="85%" height="3">
  	 </td>
      <td width="14%" height="3"></td>
    </tr>
    <tr>
      <!--<td width="1%" height="19">&nbsp;</td>-->
      <td width="100%" height="19" colspan="3">
 <table border="0" align='center' cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center"  width="100%" class="tablebdr">
    <tr>
      <td width="100%" height="18" colspan="3" class="tdhead">
      <?=$lang_Gettext?>
    <select name="programs" onchange="document.f1.submit()"><option value="All" ><?=$lang_home_all_pgms?></option>
                               <?  while($row=mysqli_fetch_object($result))

                               {
                               if($programs=="$row->joinpgm_programid")
                                      $programName="selected = 'selected'";
                               else
                                $programName="";

                               ?>
                                 <option <?=$programName?> value="<?=$row->joinpgm_programid?>"><?=$common_id?>:<?=$row->joinpgm_programid?>...<?=stripslashes($row->program_url)?> </option>
                               <?
                               }
                               ?>
    </select></td>
      </tr>

	  <!--Choose Sub-ID-->
<?php include("subid_choose.php"); ?>
	  <!--Choose Sub-ID-->




                    <?php    ///////////// display  texts /////////////

                        $bsql1=$bsql;
                       $bsql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
                       $bres=mysqli_query($con,$bsql);
                       //echo $sql3;
                       //echo mysql_error();

                       if(mysqli_num_rows($bres)<="0")
                       {

                       ?>

	                          <tr>
	                          <td width="2%" height="19">&nbsp;</td>
	                          <td width="94%" height="19" class='textred'><b><?=$lang_text_norec?></b>
							  </td>
							  <td></td>
	                          &nbsp;</tr>
							  <tr>
	                          <td width="3%" height="19"></td>
							  <td></td>
							  <td></td>
	                          </tr>



                        <? }
                       else
                       {

                        while($row=mysqli_fetch_object($bres))
                    {

	          ?>


              <tr>
      <td width="2%" height="19">&nbsp;</td>
      <td width="94%" height="19"></td>
		<td></td>

            	    </tr>
					<tr>
      <td width="3%" height="19"></td>
	  <td></td>
<td></td>
            	    </tr>



    <tr>
      <td width="1%" height="18">&nbsp;&nbsp;
      </td>




      <td width="95%" height="18">
               <table cellspacing="0" cellpadding="5" width='100%' border="1"  style="border-collapse: collapse" >
	                <tr>
	                    <td height='1' width='593' class="grid1">

                                <span><?=$lang_home_text?>:<?=$row->text_text?><br/>
	                    		<?=$lang_URL?>: <a href='<?=$row->text_url?>' target="new">
	                    		<?=$row->text_url?></a></span></td>
                      </tr>

                
                    <!-- Added on 27th July 2009 to display the tracking URL -->
                        <?php
                        //if the affiliate has chosen a sub id then add that also to the url
                        $subidurl = "&amp;subid=1";
                        if(!empty($subid)) $subidurl = "&amp;subid=$subid";
                        
                        $targetUrl = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=N$row->text_id".$subidurl;
                        ?>
                        <!--  Display URL -->
                        <tr>
                            <td height='1' width='100%' class="grid2">
                            <span><?=$lang_TrackURL?>: <a href='<?=$targetUrl?>' target="new"><?php echo $targetUrl?></a></span>
                            </td>
                        </tr>
                    <!-- END display the tracking URL -->

	                  <tr>
                          <td  height='44' width='599' class="grid1">
                          <?=$lang_Gettext_help?></td>
                      </tr>
                
	                  <tr>
                      <td  height='73' width='599' class="grid2">
                       Text Ad
                         <textarea rows="4" name="textarea" cols="75">
                      <?
               			//$track_site_url = urlencode($track_site_url);

						//if the affiliate has chosen a sub id then add that also to the url
						$subidurl = "";
						if(!empty($subid)) $subidurl = "&amp;subid=$subid";

               			 $track_site_url = str_replace(" ","%20",$track_site_url);
               			 $code = "<!-- START $title CODE -->\n<script language='javascript'  type='text/javascript'>\nvar r=document.referrer;\n var counter = new Object();\ncounter.src = '$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=N$row->text_id&amp;r='+r;\n</script><script src=$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=N$row->text_id$subidurl>\n</script>\n<!-- END $title CODE -->";
			   			 echo $code;
                     ?>


                         </textarea>
</td>


                      </tr>
                      <tr>
                      <td  height='73' width='599' class="grid2">
                       Text Link

                      <textarea rows="4" name="S1" cols="75">
                      <?
						//if the affiliate has chosen a sub id then add that also to the url
						$subidurl = "";
						if(!empty($subid)) $subidurl = "&amp;subid=$subid";

               			//$track_site_url = urlencode($track_site_url);
               			 $track_site_url = str_replace(" ","%20",$track_site_url);
                         $url = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=N$row->text_id".$subidurl;
               			 $code = "<!-- START $title CODE -->\n<a href='$url'>$row->text_text</a>\n\n<!-- END $title CODE -->";
			   			 echo $code;
                     ?>


                      </textarea>
                      </td>
                      </tr>
	      </table>

      	</td>
      	<td width="4%" height="18">
      	</td>
    	</tr>

         <?php

                    } /// while closing

	  ?>

    	<tr>
      <td width="1%" height="18">
      </td>
      <td width="95%" height="18">
            <?

                 $pgsql=$bsql1;
                 $url    ="index.php?Act=gettext&amp;programs=$programs";    //adding page nos
                include '../includes/show_pagenos.php';
?>
           </td>
	        <td width="4%" height="18">&nbsp;&nbsp;
	        </td>
    </tr>
<?php
                }
                ?>

    <tr>
      <td width="100%" height="19" colspan="3" class="tdhead">&nbsp;</td>
    </tr>
  </table>
      </td>
      <!--<td width="14%" height="19">
       </td>-->
    </tr>
    
    <tr>
      <td width="1%" height="19">&nbsp;</td>
      <td width="85%" height="19">&nbsp;</td>
      <td width="14%" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="1%" height="19">&nbsp;</td>
      <td width="85%" height="19">&nbsp;</td>
      <td width="14%" height="19">&nbsp;</td>
    </tr>
  </table>
 </form>