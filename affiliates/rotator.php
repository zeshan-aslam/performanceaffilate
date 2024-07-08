<?php
   	$partners         	=new partners;
   	$partners->connection($host,$user,$pass,$db);
   	$joinstatus        	= trim($_GET['status']);
   	$msg				= trim($_GET['msg']);
    $approved_count 	= 0;
	$waiting_count		= 0;
 	$notjoined_count	= 0;

    if(empty($joinstatus))
    {
        $joinstatus="All";
    }

    switch ($joinstatus) {

       case 'All':
           $sql="SELECT * FROM `partners_category` ";
           $curent="all";	/// used for no record found
           break;

       case 'notjoined':

              $sql1="SELECT DISTINCT (
					cat_id)FROM partners_category AS c, partners_rotator AS r
					WHERE r.rotator_catid = c.cat_id ";

              $curent="notjoined";	/// used for no record found

     		  $res=mysqli_query($con,$sql1);
    		  $sql="select * from partners_category";
			  if(mysqli_num_rows($res)>0)
    		  {
        	  	$first=" where cat_id not in (";
        		$last=" )";

	         	while ( $row=mysqli_fetch_object($res)){
	            	$str .=$row->cat_id.",";
	           }

          	   $str=trim($str,",");
          	   $str=$first.$str.$last;
               $sql.=$str;
			}

      ///////////////////////////////////////////////////////

           break;

     case 'waiting':

     $curent="waiting"; ////////// using for norecord found

           $sql="SELECT  DISTINCT ( cat_id ), cat_name
				FROM  `partners_rotatorsta` , partners_rotator, partners_category
				WHERE rotator_affilid =  '1' AND rotatorsta_status =  'waiting'
                AND cat_id = rotator_catid AND rotatorsta_roid = rotator_id";
           break;

       case 'approved':

            $curent="approved"; ////////// using for norecord found

      	 	$sql="SELECT  DISTINCT ( cat_id ), cat_name
				FROM  `partners_rotatorsta` , partners_rotator, partners_category
				WHERE rotator_affilid =  '1' AND rotatorsta_status =  'approved'
                AND cat_id = rotator_catid AND rotatorsta_roid = rotator_id";

         break;
	}

	//********** taking count of approved,waiting ,not joined

 	$ret=mysqli_query($con,$sql);

 	$sqla="SELECT  DISTINCT ( cat_id ), cat_name
				FROM  `partners_rotatorsta` , partners_rotator, partners_category
				WHERE rotator_affilid =  '1' AND rotatorsta_status =  'approved'
                AND cat_id = rotator_catid AND rotatorsta_roid = rotator_id";

 	$sqlw="SELECT  DISTINCT ( cat_id ), cat_name
				FROM  `partners_rotatorsta` , partners_rotator, partners_category
				WHERE rotator_affilid =  '1' AND rotatorsta_status =  'waiting'
                AND cat_id = rotator_catid AND rotatorsta_roid = rotator_id";

                // *********** count of not joined*************//

    $sql10="SELECT DISTINCT (cat_id) FROM partners_category AS c, partners_rotator AS r
				WHERE r.rotator_catid = c.cat_id ";

    $res=mysqli_query($con,$sql10);
    	 $sqln="select * from partners_category";
	if(mysqli_num_rows($res)>0){
		$first=" where cat_id not in (";
		$last=" )";

	    while ($row=mysqli_fetch_object($res))
	    {
        	$st .=$row->cat_id.",";
        }

        $st=trim($st,",");
        $st=$first.$st.$last;
        $sqln.=$st;
	}

	//****************** count of notjoined eding***********//

	$resa=mysqli_query($con,$sqla);
	$approved_count=mysqli_num_rows($resa);
	//echo $approved_count;
	//echo $sqla;

	$resw=mysqli_query($con,$sqlw);
	$waiting_count=mysqli_num_rows($resw);
	// echo $waiting_count;

	// echo $sqln;

	$resn=mysqli_query($con,$sqln);
	$notjoined_count=mysqli_num_rows($resn);
	// echo $notjoined_count;

	$totalcategory= $approved_count+$waiting_count+$notjoined_count;

	// echo $totalcategory;
	//$approved_count=0;
	// $waiting_count=0;
	//$notjoined_count=0;

	//******************************** counting stop**********************//

	//************** for no record found***********//

	switch ($curent) {

	    case  "waiting";
	        if($waiting_count<1){
	        	$display="false";
	        }else{
	        	$display="true";
	        }
	    break;

	    case "notjoined":

	        if($notjoined_count<1){
	        	$display="false";
	        }else{
	        	$display="true";
	        }

	        break;

	        case "approved":

	        if($approved_count<1){
	        	$display="false";
	        }else{
	        	$display="true";
	        }
	    break;

	    case "all":
		    $display="true";
	    break;
	    }
?>
	    <table border="0" cellpadding="0" cellspacing="0" width="90%" id="AutoNumber1" class="tablewbdr" align="center">
	    	<tr>
	    		<td width="101%" colspan="3" align="center">
			    <table border="0" cellpadding="0" cellspacing="0" width="700" class="tablewbdr">
	    			<tr>
	    				<td align="center" height="9" colspan="3" class='textred'><b><? echo($msg); ?></b>&nbsp;</td>
	    			</tr>
                </table>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td width="1%" height="139">&nbsp;</td>
	    		<td width="98%" height="139">
	    			<table border="0" cellspacing="1" width="70%" align="center">
	    				<tr>
	    					<td width="25%">
	    						<table width="100%" border="0" cellspacing="1" class="tablebdr">
	    							<tr>
	    								<td width="100%" colspan="3" align="center" height="19"  class="tdhead"><b><?=$lang_CategoryStatus?></b></td>
	    							</tr>
	    							<tr>
	    								<td width="4%" height="28">&nbsp;</td>
	    								<td width="86%" height="28" align="left">
	    								<a href="index.php?Act=rotator&amp;status=approved">
	    						<img alt="" border="0" height="24" width="24" src="../images/approved.gif"
	    								/>&nbsp;<?=$lang_home_approved?></a></td>
	    								<td width="14%" height="28"><b><?=$approved_count?></b></td>
	    							</tr>
	    							<tr>
	    								<td width="4%" height="28">&nbsp;</td>
	    								<td width="86%" height="28" align="left">
										<a href="index.php?Act=rotator&amp;status=waiting">
									    <img border="0"  alt="" height="24" width="<24" src="../images/waiting.gif"
									    /> &nbsp;<?=$lang_home_waiting?></a></td>
	    								<td width="14%" height="28"><b><?=$waiting_count?></b></td>
	    							</tr>
	    							<tr>
	    								<td width="4%" height="28">&nbsp;</td>
	    								<td width="86%" height="28" align="left">
	    								<a href="index.php?Act=rotator&amp;status=notjoined">
	    								<img alt="" border="0" src="../images/notjoined.gif" height="<?=$icon_height?>" width="<?=$icon_width?>"/>
	    								&nbsp;<?=$lang_aff_notjoined?></a> </td>
									    <td width="14%" height="28"><b><?=$notjoined_count?></b></td>
	    							</tr>
							  </table>
            				</td>
	            		<td width="75%">
	                		<table border="0" cellspacing="1" width="100%" class="tablebdr">
	                            <tr>
	                                <td colspan="2" height="19" class="tdhead"><b>
	                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$lang_Help?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                                &nbsp;&nbsp;<a href="index.php?Act=rotator"><?=$lang_view?></a></b>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td width="10%" height="28">&nbsp;</td>
	                                <td width="90%" height="28" align="left"><img
	                                alt="" border="0" height="24" width="24" src="../images/approved.gif"/> - <?=$lang_aff_approved_help?></td>
	                            </tr>
	                            <tr>
	                                <td width="10%" height="28">&nbsp;</td>
	                                <td width="90%" height="28" align="left">
	                                <img alt="" border="0" height="24" width="24" src="../images/waiting.gif"/> - <?=$lang_aff_waiting_help?> </td>
	                            </tr>
	                            <tr>
	                                <td width="10%" height="28">&nbsp;</td>
	                                <td width="90%" height="28" align="left">
	                                <img alt="" border="0" src="../images/notjoined.gif" height="<?=$icon_height?>" width="<?=$icon_width?>"/> -
	                                <?=$lang_notjoined_help?></td>
	                            </tr>
	                        </table>
		        		</td>
	        		</tr>
	                <tr>
	                    <td colspan="3" height="8"><span style="font-size: 0.5pt">&nbsp;&nbsp;&nbsp;
	                    </span></td>
	                </tr>
	                <tr>
	        		<td colspan="3" height="16" align="center">
                    <form name="f1" method="post" action="rotator_validate.php?status=<?=$joinstatus?>">
			        <table border="0" cellspacing="3" class="tablebdr" width="517">
				        <tr>
					        <td align="left" class="tdhead" colspan="4" height="19" width="517">
                            	&nbsp;<b><a href="index.php?Act=rotator"><?=$lang_rotator?>&nbsp;&nbsp;</a> </b> </td>
                        </tr>

                            <?php
                            if($display=="true"){
                            ?>
                        <tr>
	        				<td align="center" class="tab_in4" height="22" valign="middle" width="20"></td>
	        				<td align="center" class="tab_in4" height="22" valign="middle" width="282"><b><?=$lang_Category?>&nbsp;
				            </b></td>
	        				<td align="center" class="tab_in4" height="22" valign="middle" width="111"><b><?=$lang_Status?> </b> </td>
	        				<td align="center" class="tab_in4" height="22" valign="middle" width="100"><b><?=$lang_Action?> </b> </td>
	        			</tr>

	                    <?
	                    	} // closing of if display

	                    while($row=mysqli_fetch_object($ret))
                        {
	                        $category=stripslashes($row->cat_name);
	                        $catid    =stripslashes($row->cat_id);

	                        $sql1="select * from partners_rotator where rotator_affilid ='$AFFILIATEID' and rotator_catid ='$catid'";

	                        $res= mysqli_query($con,$sql1);

	                        if (mysqli_num_rows($res)>0){

				                $sql="SELECT  * FROM partners_rotator AS r, partners_rotatorsta AS s WHERE r.rotator_id = s.rotatorsta_roid AND r.rotator_catid = $catid and rotatorsta_status ='approved' and r.rotator_affilid = '$AFFILIATEID'";

	                            $res= mysqli_query($con,$sql);

                                if(mysqli_num_rows($res)>0){

                                   	$image="<img alt=\"\" src='../images/approved.gif' border='0' height='$icon_height' width='$icon_width'/>";
									$link="<a href=\"index.php?Act=getrotator&amp;catid=$catid\">$lang_affiliate_getlinks</a>";
	                                // echo "aproved";
	                                $status="aproved";
                                    $approved_count++;
                                }else{
	                                //echo "waiting";

	                                $image="<img alt=\"\" src='../images/waiting.gif' border='0' height='$icon_height' width='$icon_width'/>";
	                                $link="<a href='#'>$lang_affiliate_waiting</a>";

	                                $waiting_count++;
                            	}
	                        }else{
                                    $image="<img alt=\"\" src='../images/notjoined.gif' border='0' height='$icon_height' width='$icon_width'/>";
									$link="<a href='rotator_validate.php?sub=action&amp;element=$category&amp;catid=$catid'>$lang_affiliate_joinpgm</a>";

                                    $status="notjoined";
                                    $notjoined_count++;
							}

               				$check=$category."~".$catid;
                         ?>
            			<tr>
            				<td width="20"  align="center" height="1" > <input type="checkbox" name="elements[]" value="<?= $check?>"/></td>
            				<td width="282"  align="center" height="1" ><?=$category?></td>
            				<td width="111"  align="center" height="1" ><?=$image?></td>
							<td width="100"  align="center" height="1" ><?=$link?></td>
            			</tr>

                          <?php
                          }
                          if($display=="true"){
						  ?>
						<tr>
	        				<td align="center" class="tab_in2" height="26" valign="middle" width="509" colspan="4">
	        					<p align="left">
	        					<img border="0" src="../images/arrow_ltr.gif" width="38" height="22" alt=""/>
	        					<a href="#" onclick="flagall()"  > <?= $lang_affiliate_head_check?> /</a>
	        					<a href="#" onclick="unflagall()"> <?= $lang_affiliate_head_uncheck?>&nbsp;&nbsp;&nbsp;</a></p>
	        				</td>
	                    </tr>
	                    <tr>
	        				<td align="center" class="tab_in2" height="27"
	        				valign="middle" width="509" colspan="4">
                            <input type="hidden" value="" name="action_val" />
                            <input  type="submit"  name="sub" value="<?=$rotators_join?>" title="<?=$lang_join_selected?>" onclick="choice_val()"/>
                            &nbsp;&nbsp; <input  type="submit" name="sub" value="<?=$rotators_unjoin?>" title="<?=$lang_unjoin_selected?>" onclick="choiceun_val()"/></td>
	        			</tr>

                            <?php
                            }else{

                            ?>
            			<tr>
            				<td align="center" class="textred" height="27" valign="middle" width="509" colspan="4"><big><?=$lang_norec?></big></td>
            			</tr>

                            <?php
                            }
							?>

            			<tr>
            				<td height="19" width="513" colspan="4" align="center">
            				<?=$lang_total?> &nbsp;<?=$totalcategory?> <?=$lang_catfound?></td>
            			</tr>
                    </table></form>
            		</td>
            	</tr>
            	<tr>
            		<td height="10" colspan="3"><span style="font-size: 0.5pt">&nbsp;&nbsp;
            		</span></td>
            	</tr>
        	</table>
            </td>
        </tr>
	</table>
        <script language="javascript"  type="text/javascript">

	    //check all
	    function flagall()
	    {
	    	for (i=0;i<(document.f1.elements.length);i++)
	    		{document.f1.elements[i].checked = true;
	    	}
	    }

	    //uncheck all
	    function unflagall()
	    {
	    	for (i=0;i<(document.f1.elements.length);i++)
	    		{document.f1.elements[i].checked = false;
	    	}
	    }

        function choice_val()
        {
           document.f1.action_val.value="Join selected programs";
        }
        function choiceun_val()
        {
           document.f1.action_val.value="Un join selected programs";
        }
	    </script>