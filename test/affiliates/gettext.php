<?

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';

   if(empty($page))                               //getting page no
        $page =$partners->getpage();

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
	<div class="row"> 
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label><?=$lang_Gettext?></label>
						<select name="programs" onchange="document.f1.submit()" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue"><option value="All" ><?=$lang_home_all_pgms?></option>
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
						</select>
					</div>	
				  <!--Choose Sub-ID-->
				  <?php include("subid_choose.php"); ?>
				  <!--Choose Sub-ID-->
				 </div>	
			</div>	 
		</div>	
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">	 

                    <?php    ///////////// display  texts /////////////
					
                        $bsql1=$bsql;
                       $bsql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
                       $bres=mysqli_query($con,$bsql);
                       //echo $sql3;
                       //echo mysql_error();

                       if(mysqli_num_rows($bres)<="0")
                       {
                       ?>
					   <p class="textred"><b><?=$lang_text_norec?></b></p>

                        <? }
                       else 
                       {
                        while($row=mysqli_fetch_object($bres))
						{ 
					?>
					<div class="cus_affili_txt">
						<h4><?=$lang_home_text?>:<?=$row->text_text?></h4>
						<span><strong><?=$lang_URL?>: <a href='<?=$row->text_url?>' target="new"> 
						<?=$row->text_url?></a></strong></span>
                              
                    <!-- Added on 27th July 2009 to display the tracking URL -->
                        <?php
                        //if the affiliate has chosen a sub id then add that also to the url
                        $subidurl = "&amp;subid=1";
                        if(!empty($subid)) $subidurl = "&amp;subid=$subid";
                        
                        $targetUrl = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=N$row->text_id".$subidurl;
                        ?>
                        <!--  Display URL -->
                       <span><strong><?=$lang_TrackURL?>: <a href='<?=$targetUrl?>' target="new"><?php echo $targetUrl?></a></strong></span>
                            
                    <!-- END display the tracking URL -->
						<p><?=$lang_Gettext_help?></p>
					</div>	
	                  
						<!--<div class="form-group">
							<label><strong>Text Ad</strong></label>
							<textarea class="form-control textarea_contrl" rows="10" name="textarea">							
								<?
								//$track_site_url = urlencode($track_site_url);

								//if the affiliate has chosen a sub id then add that also to the url
								
								/*$subidurl = "";
								if(!empty($subid)) $subidurl = "&amp;subid=$subid";

								 $track_site_url = str_replace(" ","%20",$track_site_url);
								 $code = "<!-- START $title CODE -->\n<script language='javascript'  type='text/javascript'>\nvar r=document.referrer;\n var counter = new Object();\ncounter.src = '$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=N$row->text_id&amp;r='+r;\n</script><script src=$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=N$row->text_id$subidurl>\n</script>\n<!-- END $title CODE -->";
								 echo $code;*/
							 ?>
						    </textarea>
				        </div>-->
						<div class="form-group">
							<label><strong>Text Link</strong></label>
							<textarea rows="10" class="form-control textarea_contrl" name="S1"><? 
								//if the affiliate has chosen a sub id then add that also to the url
								$subidurl = "";
								if(!empty($subid)) $subidurl = "&amp;subid=$subid";
								//$track_site_url = urlencode($track_site_url);
								 $track_site_url = str_replace(" ","%20",$track_site_url);
								 $url = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=N$row->text_id".$subidurl;
								 $code = "<!-- START $title CODE -->\n<a href='$url'>$row->text_text</a>\n<!-- END $title CODE -->";
								 echo $code;
							 ?>							 
							</textarea>							
						</div>
					 <?php
						 } // while closing
					}	 
					?>
					
					<?
					 $pgsql=$bsql1;
					 $url    ="index.php?Act=gettext&amp;programs=$programs";    //adding page nos
					include '../includes/show_pagenos.php';
					?>
				 </div>
			</div>
		</div>			
	</div>			
</form>  