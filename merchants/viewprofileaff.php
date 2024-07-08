 <?php	
  
  include_once '../includes/db-connect.php';
	include '../includes/session.php';
	include '../includes/constants.php';
	include '../includes/functions.php';
	
	if(!empty($_POST['languageid'])) $_SESSION['LANGUAGE'] = $_POST['languageid'];
	$language=$_SESSION['LANGUAGE'];
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	include 'language_include.php';    
	
	$affid		= intval($_GET['id']);
	$sql        = "select * from partners_affiliate where affiliate_id='$affid'";
	$res        = mysqli_query($con,$sql);
	while($row=mysqli_fetch_object($res)){
		$affiliate_id                                =$row->affiliate_id;
		$affiliate_firstname              			  =stripslashes($row->affiliate_firstname);
		$affiliate_lastname               			  =stripslashes($row->affiliate_lastname);
		$affiliate_company                           =stripslashes($row->affiliate_company);
		$affiliate_address                           =stripslashes($row->affiliate_address);
		$affiliate_city                              =stripslashes($row->affiliate_city);
		$affiliate_country                           =stripslashes($row->affiliate_country);
		$affiliate_phone                             =stripslashes($row->affiliate_phone);
		$affiliate_url                               =stripslashes(trim($row->affiliate_url));
		$affiliate_category                		  =stripslashes($row->affiliate_category);
		$affiliate_status                        	  =stripslashes($row->affiliate_status);
		$affiliate_date                              =stripslashes($row->affiliate_date);
		$affiliate_fax                               =stripslashes($row->affiliate_fax);
	}

	include '../lang/english.php';

?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AVAZ Affiliate Network</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
<!-- CSS Files -->
<link href="../public/assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="../public/assets/css/light-bootstrap-dashboard.css.css" rel="stylesheet" />
<link href="../public/assets/css/demo.css" rel="stylesheet" />
<!--<link rel="stylesheet" type="text/css" href="style.css"/>-->
<script>var is_show_welcome = '<?php echo $welcomeflag; ?>'; </script>
</head>
<body>
<div class="modal fade modal-primary show" id="myModal0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<div class="">
					<?=$vproaff_prof?>
				</div>
			</div>
			 <div class="modal-body text-center">
				<div class="card strpied-tabled-with-hover">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$common_id?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_id?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_company?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_company?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_fname?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_company?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_lname?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_lastname?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_addr?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_address?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_city?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_city?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_contry?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_country?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_phone?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_phone?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_url?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_url?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_category?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_category?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_status?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_status?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_jdate?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_date?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$vproaff_fax?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<span><?=$affiliate_fax?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-link btn-simple" data-dismiss="modal">Close</button>
					</div>
				</div>
			 </div>
		</div>	
	</div>
 </div>
 </body>
 </html>