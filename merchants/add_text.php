<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{

 function add($lText_success)
          {
            $con = $GLOBALS["con"];
            
                   $pgmid = $_SESSION['PGMID'];
                   $url	  = $_POST['url'];
                   $text  = $_POST['text'];
                   $description=$_POST['description'];

                   $sql="INSERT INTO `partners_text_old` ( `text_id` , `text_programid` , `text_text` , `text_url` , `text_description` )
						VALUES ('', '$pgmid', '".addslashes($text)."', '".addslashes($url)."', '".addslashes($description)."')";


            		//$sql="insert into partners_banner (banner_id ,banner_programid ,banner_url ,banner_name) values('','$pgmid','$url','$banner')";
                    mysqli_query($con,$sql);

                    echo mysqli_error($con);
                   echo "<p align='center'><font color='red'><strong>$lText_success</strong></font></p>";

            }

                if ($_POST['url']=="" || $_POST['text']=="" || $_POST['description']=="") {

                echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";

                }
                else {


	    $sql="select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
	    $result = mysqli_query($con,$sql);
	    //echo $sql;
	    echo mysqli_error($con);

	                if(mysqli_num_rows($result)>0)
	                {
	                       $sql1="select * from partners_text_old where text_programid ='$_SESSION[PGMID]'";
	                         $result = mysqli_query($con,$sql1);
	                         echo mysqli_error($con);
	                        // echo $sql1;
	                          if(mysqli_num_rows($result)>0)
	                        {
								//  echo "normal user with a banner cant add ";
                                echo "<p align='center'><font color='red'><strong>$lText_normal</strong></font></p>";
	                        }
	                        else
	                        {

	                        add($lText_success);
	                         //echo "norm user no banner ok adding";
	                        }


	                }
	                else
	                {
	                //echo "advance user ok adding";
	                add($lText_success);
	                }



            }   /// else closing of null check


}/////////  submit check if closing

else if($_GET['mode']=="delete")
{
	$id = intval($_GET['id']);

   $sql="Delete from partners_text_old where text_id ='$id'";

   mysqli_query($con,$sql);

   mysqli_error($con);


   echo "<P align='center'><font color='red'><strong>$lText_delete &nbsp;</strong></font></p>";
}


?>

<form method="post" action="" >
<style>
	.pagination{
		float: right;
	}
	table {
			table-layout: fixed;
		}

		.action {
			width: 80px !important;
		}

		.check {
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		.check {
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		.check:hover {
			overflow: visible;
			white-space: normal;
			-ms-word-break: break-all;
		}

		.check:hover {
			overflow: visible;
			white-space: normal;
		}
</style>
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
						<input type="text" name="url" class="form-control" />
					</div>
					<div class="form-group">
						<label><?=$ltextadd_Text?></label>
						<input type="text" name="text" class="form-control" />
					</div>
					<div class="form-group">
						<label><?=$ltextadd_Description?></label>
						<textarea rows="3" name="description" class="form-control"></textarea>
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
	<div class="col-md-8">
		<div class="card regular-table-with-color">
			<div class="card-header"> 
				<h4 class="card-title"><?="Existing Text Ads"?></h4>
			</div>
			<div class="card-body">
				 <?php    ///////////// display  banners /////////////
				 
				   $sql3="select * from partners_text_old where text_programid = '$_SESSION[PGMID]' ORDER BY text_id DESC";
				   $res=mysqli_query($con,$sql3);
				   //echo $sql3;
				   echo mysqli_error($con);

					//Added by DPT on June/16/05
					//if no texts exist
					if(mysqli_num_rows($res)<=0)
					{
				?>
				<p><?=$ltextadd_no_msg;?></p>
				<?php
				}
				?>
			</div>	
			
			<div class="table-full-width table-responsive">
			<table id="table_id" class="table">
					<thead>
						<th><b><?= $laddban_Type; ?></th>
						<th class="text-center"><b><?= $laddban_URL; ?></b></th>
						<th><b>Description</b></th>
						<th class="text-center"><b>Action</b></th>
					</thead>
					<tbody>
						<?php
						//End of Addition
						while ($row = mysqli_fetch_object($res)) {
						?>
							<tr>
								<td><span class='text'>Text</span></td>
								<td class="action check"><a href='<?= $row->text_url ?>' target="new"><?= $row->text_url ?></a></td>
								<td class="text-center" ><?=stripslashes($row->text_description)?></td>
								<td style="display: inline-flex;">
									<a href="#" class="btn btn-primary" onclick="window.open('edit_text1.php?id=<?=$row->text_id?>','new',100,400)"><?= $laddban_Edit ?></a>&nbsp;&nbsp;
									<a href='index.php?Act=add_text&amp;mode=delete&amp;id=<?=$row->text_id?>' class="btn btn-danger" onclick="return del_onclick()"><?= $laddban_Delete ?>&nbsp;</a>
								</td>

							</tr>
						<?php
						} /// while closing
						?>
					</tbody>

				</table>
				
			</div>			
		</div>		
	</div>
</div>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
	$(document).ready(function() {
		$('#table_id').DataTable();
	});
</script>
 <script  language="javascript" type="text/javascript">

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