<?php

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{

	 function add($lflash_success)
	            {
                $con = $GLOBALS["con"];
	                   $pgmid=$_SESSION['PGMID'];

                   	   $url=$_POST['url'];
	                   $swf=$_POST['swf'];
	                   $width=$_POST['T1'];
	                   $height=$_POST['T2'];

				$sql="INSERT INTO `partners_flash` SET ".
				" flash_programid = '".addslashes($pgmid)."' , ".
				" flash_url = '".addslashes($url)."' , ".
				" flash_swf = '".addslashes($swf)."' , ".
				" flash_width = '".addslashes($width)."' , ".
				" flash_height = '".addslashes($height)."' ";
				mysqli_query($con,$sql);
	
			   echo mysqli_error($con);
			   echo "<p align='center' > <font color='red'> <strong>$lflash_success</strong></font></p>";

	            }

	                if ($_POST['swf']=="" || $_POST['url']=="" || $_POST['T1']=="" || $_POST['T1']=="" )
                     {

	                echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";

	                }
	                else {


	        $sql="select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
	        $result = mysqli_query($con,$sql);
	        //echo $sql;
	        echo mysqli_error($con);

	                    if(mysqli_num_rows($result)>0)
	                    {
	                           $sql1="select * from partners_flash where flash_programid ='$_SESSION[PGMID]'";
	                             $result = mysqli_query($con,$sql1);
	                             echo mysqli_error($con);
	                            // echo $sql1;
	                              if(mysqli_num_rows($result)>0)
	                            {
	                                //  echo "normal user with a flash cant add ";
	                                echo "<p align='center' > <font color='red'><strong>$lflash_normal</strong></font></p>";
	                            }
	                            else
	                            {

	                            add($lflash_success);
	                             //echo "norm user no flash ok adding";
	                            }


	                    }
	                    else
	                    {
	                    //echo "advance user ok adding";
	                    add($lflash_success);
	                    }
	            }   /// else closing of null check
	}/////////  submit check if closing


else if($_GET['mode']=="delete")
{
	$id=$_GET['id'];

   $sql="Delete from partners_flash where flash_id='$id'";

   mysqli_query($con,$sql);

   mysqli_error($con);

  //echo $_SESSION['PGMID'];
   echo "<p align='center' ><font color='red'><strong>$lflash_delete&nbsp;</strong></font></p>";
}

?>
<form method="post" action="" name="f1" id="f1">
<? include_once "add_link.php"; ?>
<? /*
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" align="center" width="719" id="AutoNumber3" class="tablebdr">
          <tr>
            <td width="5" class="tdhead">&nbsp;</td>
            <td width="137" class="tdhead"><b>
              <?=$laddban_Text?>
            </b></td>
            <td width="5">&nbsp;</td>
            <td width="142" class="tdhead"> <b>
              <?=$laddban_Banner?>
            </b></td>
            <td width="5">&nbsp;</td>
            <td width="138" class="tdhead"><b>
              <?=$laddban_Flash?>
            </b></td>
            <td width="5">&nbsp;</td>
            <td width="138" class="tdhead"><b>
              <?=$laddban_HTML?>
            </b></td>
            <td width="5">&nbsp;</td>
            <td width="145" class="tdhead"><b>
              <?=$laddban_Popupads?>
            </b></td>
            <td width="13" class="tdhead">&nbsp;</td>
          </tr>
          <tr>
            <td width="5" valign="top">&nbsp;</td>
            <td width="137" valign="top" style="text-align: left">&nbsp;
              <?=$laddban_Texttext?>
              <br/>
        &nbsp;</td>
            <td width="5" valign="top" style="text-align: left">&nbsp;</td>
            <td width="142" valign="top" style="text-align: left">&nbsp;
                <?=$laddban_Bannertext?>
                <br/>
          &nbsp;</td>
            <td width="5" valign="top" style="text-align: left">&nbsp;</td>
            <td width="138" valign="top" style="text-align: left"> &nbsp;
              <?=$laddban_Flashtext?>
&nbsp; </td>
            <td width="5" valign="top" style="text-align: left">&nbsp;</td>
            <td width="138" valign="top" style="text-align: left">&nbsp;
                <?=$laddban_Flashtext?></td>
            <td width="5" valign="top" style="text-align: left">&nbsp;</td>
            <td width="145" valign="top" style="text-align: left">&nbsp;
                <?=$laddban_Popupadstext?></td>
            <td width="13" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td width="5">&nbsp;</td>
            <td width="137"><a href="index.php?Act=add_text"> <img src='images/grapgicb.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="5">&nbsp;</td>
            <td width="142"><a href="index.php?Act=add_banner"> <img src='images/grapgicc.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="5">&nbsp;</td>
            <td width="138"> <a href="index.php?Act=add_flash"> <img src='images/grapgicd.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="5">&nbsp;</td>
            <td width="138">  <a href="index.php?Act=add_html"> <img src='images/grapgice.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="5">&nbsp;</td>
            <td width="145"> <a href="index.php?Act=add_popup"> <img src='images/grapgicf.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="13">&nbsp;</td>
          </tr>
          <tr>
            <td width="738" class="tdhead" colspan="11">&nbsp;</td>
          </tr>
        </table>
*/ ?>	

 <div class="row"> 
	<div class="col-md-6">
		<div class="card stacked-form">
			<div class="card-header"> 
				<h4 class="card-title"><?=$fflashadd_FlashAdd?></h4>
				<p><b><?=$fflashadd_TocreateaFlashaddyoumustfillthefollowingfields?></b></p>
			</div>
			<div class="card-body"> 
				<ul style="list-style-type:none;padding-left: 15px;">
					<li><b><?=$fflashadd_SWFURL?> -</b>&nbsp;<?=$fflashadd_infofortheSWFURLThisislinkthatyoumustembeddedinyourflashflashThisisrequiredbecausetrackingwillbecorrect?></li>
					<li><b><?=$fflashadd_URLLINK?> -</b>&nbsp;<?=$fflashadd_TheaddressoftheSWFflash?></li>
					<li><b><?=$fflashadd_Example?> -</b>&nbsp;<?=$fflashadd_yorsite?></li>
					<li><b><?=$fflashadd_Dimension?> -</b>&nbsp;<?=$fflashadd_Youmustgivewidthandheightofflash?></li>
					<li><b><?=$fflashadd_Example?> -</b>&nbsp;<?=$fflashadd_480X60?></li>					
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card stacked-form">
			<div class="card-header"> 
				<h4 class="card-title"><?=$fflashadd_Settings?></h4>
			</div>
			<div class="card-body"> 
				<div class="form-group">
					<label><?=$fflashadd_SWFURL?></label>
					<input type="text" name="swf" class="form-control" size="47" value="" />
					<span><?=$fflashadd_where?></span>
				</div>
				<div class="form-group">
					<label><?=$fflashadd_URL?></label>
					 <input type="text" name="url" class="form-control" size="47" />
					<span>(<?=$fflashadd_Example?> - <?=$fflashadd_yorsite?>)</span>
				</div>
				<div class="form-group">
					<label><?=$fflashadd_Dimension?></label>
					<input type="hidden" name="T1" size="5" />
					<input type="hidden" name="T2" size="5" />

					<select class="form-control" name="select1" onchange="explode()">
					  <option value="120X600" selected="selected">120 X 600</option>
					  <option value="160X60">160 X 60</option>
					  <option value="160X600">160X600</option>
					  <option value="180X150">180X150</option>
					  <option value="240X400">240X400</option>
					  <option value="250X250">250X250</option>
					  <option value="300X250">300X250</option>
					  <option value="468X60">468X60</option>
					</select>
					<span>(<?=$fflashadd_Example?> - 400 X 200)</span>
				</div>
				<div class="form-group" style="text-align: center;">
					<input type="submit" class="btn btn-info btn-wd" value="<?=$common_submit?>" name="B1" />&nbsp;&nbsp;<input class="btn btn-default btn-wd" type="reset" value="<?=$common_cancel?>" name="B2" />
				</div>
			</div>
		</div>
	</div>
</div>

  <div class="row"> 
	<div class="col-md-6">
		<div class="card regular-table-with-color">
			<div class="card-header"> 
				<h4 class="card-title"><?=$fflashadd_Existingflashs?></h4>
			</div>
			<div class="card-body">
				 <?php    ///////////// display  banners /////////////
				 
				    $sql3="select * from partners_flash where flash_programid = '$_SESSION[PGMID]' ORDER BY flash_id DESC";
                       $res=mysqli_query($con,$sql3);
                       //echo $sql3;
                       echo mysqli_error($con);

						//Added by DPT on June/16/05
						//if no flashs exist
						if(mysqli_num_rows($res)<=0)
						{
				?>
				<p><?=$fflashadd_no_msg?></p>
				<?php
				}
				?>
			</div>	
			
			<div class="table-full-width table-responsive">
				<table class="table table-hover">						
				<?php							
					//End of Addition
					 while($row=mysqli_fetch_object($res))
					{
				?>
					<tbody>
						<tr>
							<td><span class='text'><b><?=$fflashadd_Type?>: <?=$fflashadd_Flash?><br/><?=$fflashadd_URL?>: <a href='<?=$row->flash_swf?>'><?=$row->flash_swf?></a></b></span></td>
							<td>
								<a href="#" onclick="window.open('edit_flash.php?id=<?=$row->flash_id?>','new',100,400)"><?=$fflashadd_Edit?></a>&nbsp;&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="2">
							<?php
							$i=$row->flash_width."_".$row->flash_height;

							$main="images/flash/".$i.".swf";
							$src = $main."?inner=".$row->flash_url."&url=".$row->flash_swf;
						   // echo "ttes==".$row->flash_swf;
							?>

						   <!--	<embed src="" quality="4" width="<?=$row->flash_width?>" height="<?=$row->flash_height ?>"  type="application/x-shockwave-flash PLUGINSPAGE=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed>-->
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="<?=$row->flash_width?>" height="<?=$row->flash_height ?>">
								<param name="movie" value="<?=$row->flash_swf?>" />
								<param name="quality" value="high" />
								<embed src="<?=$row->flash_swf?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$row->flash_width?>" height="<?=$row->flash_height ?>"></embed>
							</object>
							</td>
						 </tr>
					</tbody>
					 <?php
						} /// while closing
					 ?> 
				</table>
			</div>			
		</div>		
	</div>
</div>   

</form>

<script language="javascript" type="text/javascript">

<!--
function del_onclick() {
if(confirm("<?=$lang_del?>"))
	{
			return true;
	}
	else
	{
	return false;
	}
}

//-->
</script>

<script language="javascript" type="text/javascript">
document.f1.select1.selectedIndex=0;
explode();

function explode()
{
	 var delimiter = "X";
     var last_pzindex=document.f1.select1.selectedIndex;
	 var item=document.f1.select1.options[last_pzindex].value;

	tempArray=new Array(1);
	var Count=0;
	var tempString=new String(item);
	while (tempString.indexOf(delimiter)>0) {
	tempArray[Count]=tempString.substr(0,tempString.indexOf(delimiter));
	tempString=tempString.substr(tempString.indexOf(delimiter)+1,tempString.length-tempString.indexOf(delimiter)+1);
	Count=Count+1
	}
	tempArray[Count]=tempString;
      document.f1.T1.value=tempArray[0];
      document.f1.T2.value=tempArray[1];

}



</script>