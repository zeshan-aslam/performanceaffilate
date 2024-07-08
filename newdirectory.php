<?php

    $SortBy  	= $_GET['SortBy'];
    $cat	 	= $_GET['cat'];
    $pgm     	= trim(intval($_GET['pgm'])); 
    $newpgm	 	= $pgm;
    $OrderBy 	= trim(stripslashes($_GET['OrderBy']));
    if(empty($OrderBy))   
		$OrderByValue = "desc";
	if($OrderBy=="desc"){
		$image	= "images/up.gif";
		$OrderByValue = "asc"  ;
	}
	else{
		$OrderByValue = "desc"  ;
		$image	= "images/dawn.gif";
	}
	
     $sql		="select * from partners_program where program_status like 'active'  order by program_date desc";
     $rt1		=mysqli_query($con, $sql);
     $count1	=mysqli_num_rows($rt1);
     $i=0;

     while($row=mysqli_fetch_object($rt1))
     {
     $link[$i]=stripslashes(($row->program_url));   //part of url to display
     $pgm[$i]=$row->program_id;                                //stroring in array
	 $pgmId[$i]=$row->program_id;                                //stroring in array
     $i=$i+1;
     }
     /*************************************************************************/


     /******************listing category**************************************/
     $sql="select * from partners_category";
     $ret=mysqli_query($con, $sql);
     $i=0;
     $j=0;
     $k=0;
     $count=mysqli_num_rows($ret);
     while($row=mysqli_fetch_object($ret))
		{
			$cat[$i]=$row->cat_name;
			$sql	= " SELECT * from partners_merchant, partners_program WHERE program_status='active' 
						AND merchant_category='".addslashes($cat[$i])."' and merchant_id=program_merchantid"   ;
			
			$result=mysqli_query($con, $sql);
			$no[$i]="(".mysqli_num_rows($result).")";          //finding pgm of specified category
			$i=$i+1;
		}

    /**************************************************************************/



 $Err		=$_GET['Err'];
 $Action	=$_GET['Action'];

 if ($Action=="affiliate")
    $aff="selected = 'selected' ";
 else
     $mer="selected = 'selected' ";
?>



<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" rowspan="2" align="left" valign="top">
	<table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top">

		<?php
		if($count>0){
		?>
		<table width="661" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
		<td class="affiliates-reg-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;<?=$lang_cat?></div></td>
		</tr>
		<tr>
		<td class="affiliate-reg-content-bg">
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
					
					<tr align="left">
					  <td height="2" colspan="4">
					  <table width="100%"  border="0" cellspacing="5" cellpadding="5">
						  <tr>
							<td align="center">
							<table border="0"  width="100%" id="autonumber1"  cellspacing="3" >
						   <?
						   while($j<$count ){
						   ?>
						   <tr>
						 	<td width="50%" align="center" class="grid1" height="10"><a href="index.php?Act=directory&amp;joinstatus=catwise&amp;category=<?=$cat[$j]?>"><?=$cat[$j]?><?=$no[$j]?></a></td>
							<td>
							</td>
						 <td width="50%" align="center" class="grid1" height="10"><a href="index.php?Act=directory&amp;joinstatus=catwise&amp;category=<?=$cat[$j+1]?>"><?=$cat[$j+1]?><?=$no[$j+1]?></a></td>
					   </tr>
					   <?
					   $j=$j+2;
					   }
						?>
					 </table></td>
							</tr>
					  </table></td>
					</tr>
				  </table>
		
		</td>
		</tr>
		<tr>
		<td><img src="images/affiliate-reg-bottom.jpg" width="661" height="13" /></td>
		</tr>
		</table>
		<br/>
		<?php
		}
		$maxCount = 10;
		if($count1<$maxCount) 
			$maxCount = $count1;
		if($maxCount>0){
		?>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <?php /*?><td width="24" height="26"> <img src="images/innerbox1_01.gif" width="24" height="26" alt="" /></td>
                <td width="100%" height="26" bgcolor="#2676d1"><div align="center" class="style4"><?=$lang_newpgm?></div></td>
                <td height="26" width="131" colspan="2" align="right" class="rtborder">
                  <div align="right"><img src="images/innerbox1_03.gif" width="131" height="26" alt="" /></div></td><?php */?>
                <td colspan="4" class="affiliates-reg-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;<?=$lang_newpgm?></div></td>  
              </tr>
              <tr align="left">
                <td height="2" colspan="4" class="affiliate-reg-content-bg" ><table width="100%"  border="0" cellspacing="5" cellpadding="5">
                    <tr>
                      <td align="center"><table border="0" cellspacing="3" width="100%" id="AutoNumber2" class="tablewbdr" >
                        <?

               				while($k<$maxCount)
               				{
               				?>
                        		<tr>
                          			<td width="100%" align="center" class="grid1"><a href="index.php?Act=directory&amp;joinstatus=pgmwise&amp;pgm=<?=$pgmId[$k]?>">
                            		<?=$link[$k]?> 
                         		 </a></td>
                        		</tr>
                       		 <?
               		   			$k=$k+1;
               			}

               ?>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
              <?php /*?><tr>
                <td height="27" colspan="3" class="lftborder"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="410" height="26" align="left" valign="bottom"><table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="21">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="5" bgcolor="#d2d2d2"></td>
                          </tr>
                      </table></td>
                      <td width="21" height="26"><img src="images/innerbox1_06.gif" width="21" height="26" alt="" /></td>
                    </tr>
                </table></td>
                <td height="26" align="left" valign="top">
                  <div align="center">
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="106" height="26" bgcolor="#d2d2d2">&nbsp;</td>
                        <td width="24" height="26"><img src="images/innerbox1_08.gif" width="24" height="26" alt=""/></td>
                      </tr>
                    </table>
                </div></td>
              </tr><?php */?>
                    <tr>
                   	 	<td colspan="4"><img src="images/affiliate-reg-bottom.jpg" width="661" height="13" /></td>
                    </tr>
            </table>
            <br/> 
		<?php
		}
		?>
		<table width="661" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	  <td><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
		  <tr>
			<!--<td><img src="images/merchants-top.jpg" width="348" height="26" /></td>-->
			<td class="merchants-reg-top"><div class="box-heading"> 
			<table width="100%" border="0" align="center" height="24" >
                    <?php /*?><tr align="left" valign="middle">
                      <td width="16%" align="center" >
                          <? if($SortBy=="program_url"){?>
                          <a href="index.php?Act=directory&amp;pgm=<?=$pgm?>&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=program_url&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_pgm?></a>
                          <? }else{?>
                          <a href="index.php?Act=directory&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=program_url&amp;OrderBy=<?=$OrderByValue?>&amp;pgm=<?=$newpgm?>"><?=$lang_pgm?></a>
                          <? } ?>                      </td>
                      <td width="20%" align="center">
                     
                          <?if($SortBy=="merchant_firstname"){?>
                          <a href="index.php?Act=directory&amp;pgm=<?=$newpgm?>&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=merchant_firstname&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_merchant?></a>
                          <?}else{?>
                          <a href="index.php?Act=directory&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=merchant_firstname&amp;pgm=<?=$newpgm?>&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_merchant?></a>
                          <?}?>                   </td>
                      <td width="15%" align="center">
                       
                          <? if($SortBy=="firstlevel_clickrate"){?>
                          <a href="index.php?Act=directory&amp;pgm=<?=$newpgm?>&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=firstlevel_clickrate&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_click?> </a>
                          <? }else{?>
                          <a href="index.php?Act=directory&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=firstlevel_clickrate&amp;pgm=<?=$newpgm?>&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_click?> </a>
                          <?}?>                      </td>
                      <td width="14%" align="center">
                       
                          <?if($SortBy=="firstlevel_leadrate"){?>
                          <a href="index.php?Act=directory&amp;pgm=<?=$newpgm?>&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=firstlevel_leadrate&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_lead?></a>
                          <? }else{?>
                          <a href="index.php?Act=directory&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=firstlevel_leadrate&amp;pgm=<?=$newpgm?>&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_lead?></a>
                          <?}?>                     </td>
                      <td width="12%" align="center">
                       
                          <?if($SortBy=="firstlevel_salerate"){?>
                          <a href="index.php?Act=directory&amp;pgm=<?=$newpgm?>&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=firstlevel_salerate&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_sale?></a>
                          <?}else{?>
                          <a href="index.php?Act=directory&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=firstlevel_salerate&amp;pgm=<?=$newpgm?>&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_sale?></a>
                          <?}?>                     </td>
<!--  Added for Impression  -->
                      <td width="12%" align="center">
                       
                          <?if($SortBy=="firstlevel_impressionrate"){?>
                          <a href="index.php?Act=directory&amp;pgm=<?=$newpgm?>&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=firstlevel_impressionrate&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_impression?></a>
                          <?}else{?>
                          <a href="index.php?Act=directory&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=firstlevel_impressionrate&amp;pgm=<?=$newpgm?>&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_impression?></a>
                          <?}?>                      </td>
<!--  End Impression -->					  
                      <td width="11%" align="center" >
                     <font color="#F2F2F2"><?=$lang_action?></font></td>
                    </tr><?php */?>
                    
                    <tr>
                    
                        <td width="40%"  align="left"  height="20">
                            <a href="index.php?Act=directory&amp;pgm=<?=$pgm?>&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=program_url&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_pgm?></a>
                        </td>
                        <td width="30%"   align="left"  height="20">
                            <a href="index.php?Act=directory&amp;pgm=<?=$newpgm?>&amp;category=<?=$category?>&amp;joinstatus=<?=$joinstatus?>&amp;SortBy=merchant_firstname&amp;OrderBy=<?=$OrderByValue?>"><?=$lang_merchant?></a>
                        </td>
                        <td width="20%"  align="center"  height="20">&nbsp;</td>
                        <td width="10%"   align="center"  height="20"><font color="#F2F2F2"><?=$lang_action?></font></td>
                    
                    </tr>
                    
                </table></div></td>
		  </tr>
		  <tr>
			<td class="merchants-reg-content-bg">
			  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
              
              <tr>
			  	
                <td height="2" colspan="2" >
				<? 	#include "directory_help.php"; 
					include "programDetails.php";	?>
                </td>
              </tr>
            </table>
			</td>
		  </tr>
		  <tr>
			<td><img src="images/merchant-reg-bottom.jpg" width="661" height="12" /></td>
		  </tr>
	  </table></td>
	</tr>
</table>
          
		</td>
      </tr>
    </table>
    </td>
  </tr>
</table>



	<script language="javascript" type="text/javascript">
	function viewLink(){
		url		= "forgotpass.php";
		nw 		= open(url,'new','height=200,width=450,scrollbars=yes');
		nw.focus();
	}
	</script>