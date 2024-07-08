<?

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';


     if(empty($page))                               //getting page no
        $page        =$partners->getpage();

   /////////
 $sql   = "SELECT  joinpgm_programid, program_url FROM partners_joinpgm, partners_program
            WHERE joinpgm_affiliateid =  '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' AND program_id=joinpgm_programid "; //adding to drop down box

  $result=mysqli_query($con,$sql);

  if(mysqli_num_rows($result)<"1")
  {
   echo "	      <p>&nbsp;</p>
	        <table border='0' align='center' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='96%' id='AutoNumber1' class='tablebdr'>
	        <tr>
	        <td width='100%' class='tdhead'>
	        &nbsp;</td>
	        </tr>
	        <tr>
	        <td width='100%'>
	        <p align='center'><font size='4'>$lang_notjoined</font></td>
	        </tr>
	        <tr>
	        <td width='100%'>
	        &nbsp;</td>
	        </tr>
	        <tr>
	        <td width='100%'>
	        <h5 align='center'><a href='index.php?Act=Affiliates&amp;joinstatus=notjoined'> click here to Jion</td>
	        </tr>
	        <tr>
	        <td width='100%' class='tdhead'>
	        <p align='center'>&nbsp;</td>
	        </tr>
	        </table>
       ";

	        exit;
  } ///closing of if list populating ;


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
           $bsql="SELECT * FROM partners_html,partners_joinpgm 	where html_status ='active' and joinpgm_affiliateid= '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' AND joinpgm_programid=html_programid " ;
           $pgmid=0;
            $link=0;

           $allresult="--";
           $flag=0;

           break;
       default:    //selected pgm
           $bsql="SELECT * FROM partners_html where html_programid='$programs' and html_status ='active'";

        // $bresult=mysqli_query($con,$bsql);

      }

       $bsql1=$bsql;
       $bsql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no






  include 'getadd.php'


 ?>

	        <form name="f1" action="index.php?Act=gethtml" method="post">
	        <table border="0" cellpadding="0" cellspacing="0" align="center" width="80%" id="AutoNumber1" >
	        <tr>
	        <td width="1%" height="3"></td>
	        <td width="85%" height="3">
	        <p></p>
	         </td>
	        <td width="14%" height="3"></td>
	        </tr>
	        <tr>
	        <!--<td width="1%" height="19">&nbsp;</td>-->
	        <td width="100%" height="19" colspan="3">
	        <table border="0" align='center' cellpadding="0" cellspacing="0" style=" text-align: center" width="100%" id="AutoNumber4" class="tablebdr">
	        <tr>
	        <td width="100%" height="18" colspan="3" class="tdhead">
	        <?=$lang_Gethtml?>
	        <select name="programs" onchange="document.f1.submit()"><option value="All" ><?=$lang_home_all_pgms	?></option>
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


                    <?php    ///////////// display  htmls /////////////


                       $bres=mysqli_query($con,$bsql);
                       //echo $sql3;
                       echo mysql_error();

                       if(mysqli_num_rows($bres)<="0")
                       {

                       ?>

	        <tr>
	        <td width="2%" height="19">&nbsp;</td>
	        <td width="94%" height="19" class='textred'><b><?=$lang_html_norec?></b>
	        </td>
			<td></td>
			</tr>
			<tr>
	        <td width="3%" height="19" colspan="3"></td>
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
				<td width="3%" height="19" colspan="3"></td>
				</tr>
				<tr>
	            <td width="1%" height="18">&nbsp;&nbsp;
	            </td>
	            <td width="95%" height="18">
	            <table cellspacing="0" cellpadding="5" width='100%' border="1"  style="border-collapse: collapse" >
	            <tbody>
	            <tr>
	            <td height='1' width='593' class="grid1">

	              <a href='temp.php?rowid=<?=$row->html_id?>' target="new">
	            <img src='images/html.gif' border='0' width="300" height="60" alt="" /></a></td>
	            </tr>
                
                <!-- Added on 27th July 2009 to display the tracking URL -->
                    <?php
                    //if the affiliate has chosen a sub id then add that also to the url
                    $subidurl = "&amp;subid=1";
                    if(!empty($subid)) $subidurl = "&amp;subid=$subid";
                    
                    $targetUrl = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=H$row->html_id".$subidurl;
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


	            <textarea rows="4" name="S1" cols="75">

               <?
				//if the affiliate has chosen a sub id then add that also to the url
				$subidurl = "";
				if(!empty($subid)) $subidurl = "&amp;subid=$subid";
							   
               	//$track_site_url = urlencode($track_site_url);
                $track_site_url = str_replace(" ","%20",$track_site_url);
              	$code = "<!-- START $title CODE -->\n<script language='javascript'  type='text/javascript'>\nvar r=document.referrer;\n var counter = new Object();\ncounter.src = '$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=H$row->html_id&amp;r='+r;\n</script><script type='text/javascript' src='$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=H$row->html_id$subidurl'>\n</script>\n<!-- END $title CODE -->";
				echo $code;
               ?>
	            </textarea>
	            </td>


	            </tr>
	            </tbody>
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
                 $url    ="index.php?Act=gethtml&amp;programs=$programs";    //adding page nos
                 include '../includes/show_pagenos.php';
?></td>

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
	           <!-- <td width="14%" height="19"></td>-->
	             
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