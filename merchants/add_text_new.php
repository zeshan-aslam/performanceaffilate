<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{

		function add($lText_success)
		{
      $con = $GLOBALS["con"];
			   $pgmid=$_SESSION['PGMID'];
			   $url=$_POST['url'];
			   
				# if the 1st part of the URL not contain http:/
				$url_test = substr($url, 0, 7);
				if($url_test!="http://")
				{
						$url   =    "http://".$url;
				}

			   $text=$_POST['text'];
			   $description=$_POST['description'];
			   $image        = $_REQUEST['image'];

				$sql="INSERT INTO `partners_text` SET ".
				" text_programid = '".addslashes($pgmid)."' , ".
				" text_text = '".addslashes($text)."' , ".
				" text_url = '".addslashes($url)."' , ".
				" text_description = '".addslashes($description)."' , ".
				" text_image = '".addslashes($image)."' ";
				mysqli_query($con,$sql);
				echo mysqli_error($con);
				echo "<p align='center' > <font color='red'><strong>$lText_success</strong></font></p>";
		} //END FUNCTION
	
	
		if ($_POST['url']=="" || $_POST['text']=="" || $_POST['description']=="")
		{
				echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";
		}
		else
		{
				$sql="select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
				$result = mysqli_query($con,$sql);
				echo mysqli_error($con);

				if(mysqli_num_rows($result)>0)
				{
						$sql1="select * from partners_text where text_programid ='$_SESSION[PGMID]'";
						$result = mysqli_query($con,$sql1);
						echo mysqli_error($con);
						if(mysqli_num_rows($result)>0)
						{
								echo "<p align='center'><font color='red'><strong>$lText_normal</strong></font></p>";
						}
						else
						{
								//Calls function to Insert Values
								add($lText_success);
						}
				}
				else
				{
						add($lText_success);
				}
		 }   /// else closing of null check
}/////////  submit check if closing

else if($_GET['mode']=="delete")
{
                $id=$_GET['id'];

           $sql="Delete from partners_text where text_id ='$id'";

           mysqli_query($con,$sql);

           mysqli_error($con);
           echo "<P align='center' ><font color='red'><strong>$lText_delete &nbsp;</strong></font></p>";
}


?>

<form method="post" action="" >

  <? include_once "add_link.php"; ?>

	<div class="row"> 
		<div class="col-md-6">
			<div class="card stacked-form">
				<div class="card-header"> 
					<h4 class="card-title"><?=$ltextadd_TextAdd?></h4>
					<p><b><?=$ltextadd_TocreateaTextaddyoumustfillthefollowingfields?></b></p>
				</div>
				<div class="card-body"> 
					<ul style="list-style-type:none;padding-left: 15px;">
						<li><b><?=$ltextadd_URL?> -</b>&nbsp;<?=$ltextadd_ThisistheDestinationURLtowhichthetextaddwilllead?></li>
						<li><b><?=$ltextadd_Example?> -</b>&nbsp;<?=$ltextadd_yoursite?></li>
						<li><b><?=$ltextadd_Text?> -</b>&nbsp;<?=$ltextadd_Thistextwillbethelink?></li>
						<li><b><?=$ltextadd_Example?> -</b>&nbsp;<?=$ltextadd_BuyTheLatestNokia8080?></li>
						<li><b><?=$ltextadd_Description?> -</b>&nbsp;<?=$ltextadd_ThisisthelongDescriptionabouttheLink?></li>
						<li><b><?=$ltextadd_Example?> -</b>&nbsp;<?=$ltextadd_ThisisthelinktoHomePageofNokia?></li>
						<li><b><?=$text_image?> -</b>&nbsp;<?=$text_image_whatis?></li>
						<li><b><?=$ltextadd_Example?> -</b>&nbsp;<?=$text_image_example?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card stacked-form">
				<div class="card-header"> 
					<h4 class="card-title"><?=$ltextadd_Settings?></h4>
				</div>
				<div class="card-body"> 
					<div class="form-group">
						<label><?=$ltextadd_URL?></label>
						<input type="text" name="url" class="form-control" size="47" />
					</div>
					<div class="form-group">
						<label><?=$ltextadd_Text?></label>
						<input type="text" name="text" class="form-control" size="47" />
					</div>
					<div class="form-group">
						<label><?=$ltextadd_Description?></label>
						<textarea name="description" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label><?=$text_image?></label>
						<input type="text" name="image" class="form-control" size="47"/>
					</div>
					<div class="form-group" style="text-align: center;">
						<input type="submit" class="btn btn-info btn-wd" value="<?=$common_submit?>" name="B1" />&nbsp;&nbsp;<input class="btn btn-default btn-wd" type="reset" value="<?=$common_cancel?>" name="B2" />
					</div>
				</div>
			</div>
		</div>
	</div>
  
</form>
   
	<div class="row"> 
		<div class="col-md-6">
			<div class="card regular-table-with-color">
				<div class="card-header"> 
					<h4 class="card-title"><?=$ltextadd_ExistingTexts?></h4>
				</div>
				<div class="card-body">
					 <?php    ///////////// display  banners /////////////
					 
						$sql3="select * from partners_text where text_programid ='$_SESSION[PGMID]' ORDER BY text_id DESC";
					   $res=mysqli_query($con,$sql3);

						if(mysqli_num_rows($res)<=0)
						{
					?>
					<p><?=$ltextadd_no_msg?></p>
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
						 $text_url = $row->text_url;
							$text_text = $row->text_text;
							$text_image = $row->text_image;
							# if the 1st part of the URL not contain http:/
							$url_test = substr($text_url, 0, 7);
							if($url_test!="http://")
							{
									$text_url   =    "http://".$text_url;
							}
					?>
						<tbody>
							<tr>							
								<td>
									<a href="#" onclick="window.open('edit_text.php?id=<?=$row->text_id?>','new','100,400,scrollbars=1,resizable=1')"><?=$laddban_Edit?></a>&nbsp;&nbsp;
									<a href='index.php?Act=add_textnew&amp;mode=delete&amp;id=<?=$row->text_id?>' id="del"  onclick="return del_onclick()"><?=$laddban_Delete?></a>
								</td>
							</tr>						
							<tr>
								<td <? if(!empty($text_image)){ ?> colspan="2" <? } ?>><b>SPONSORED LISTINGS</b></td>
							 </tr>
							 <tr>
								<td><a href="<?=$text_url?>" target="_blank"><?=$text_text?></a></td>
								<?  if(!empty($text_image)) { ?>
								 <td rowspan="3"><img src="../thumbnail.php?image=<?=$text_image?>&height=50" alt="0" border="0"/></td>
								 <? } ?>
							 </tr>
							 <tr>
								 <td align="left"><?=stripslashes($row->text_description)?></td>
							 </tr>
							 <tr>
								<td align="left"><?=$text_url?></td>
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

<script  language="javascript" type="text/javascript">
function del_onclick()
	{
	if(confirm("<?=$lang_del?>"))
	{
					return true;
	}
	else
	{
			return false;
	}
}

</script>