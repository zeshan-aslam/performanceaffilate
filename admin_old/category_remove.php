<?php	

	include_once '../includes/db-connect.php';
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/allstripslashes.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$name=trim($nametxt);
	$$status=trim($status);
	///////////// remove an evemt

	$categorycompo=trim($categorycompo); 
	
	if ($categorycompo=="Choose a Category")
	{
		$msg = "select a Category to Delete!!";
		header("Location:index.php?Act=category&msg=$msg");
	}
	else {
		$test1	= "SELECT affiliate_category  FROM  partners_affiliate ".
				" WHERE affiliate_category ='".addslashes($categorycompo)."'"; 
				$test2="SELECT  merchant_category FROM partners_merchant ".
				" WHERE merchant_category ='".addslashes($categorycompo)."' ";
			
		$res1= mysqli_query($con,$test1) or die("cant exe 1");
		echo mysqli_error($con);
		
		$res2=mysqli_query($con,$test2) or die("cant exe 2");
		echo mysqli_error($con);  


		if(mysqli_num_rows($res1)==0 and mysqli_num_rows($res2)==0){
		
			$sql1	= "Delete from partners_category where cat_name='".addslashes($categorycompo)."'";
			$res1	= mysqli_query($con,$sql1) or die ("cant delete this category");
			
			$msg 	= "Category ".$categorycompo." Deleted !!";
			header("Location:index.php?Act=category&msg1=$msg");
			
			exit;
		}
		else{
			$msg =  "Can't Remove ... Members Exists on  ".$categorycompo;
			header("Location:index.php?Act=category&msg1=$msg");
		}
	}
?>