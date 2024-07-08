<?php		ob_start();
	//include files
	include '../includes/session.php';
	include '../includes/constants.php';
	include '../includes/functions.php';
	include '../includes/allstripslashes.php';
	
	//database connection
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	//file name
	$filename = "ip_sql.sql";
	
	//remove existing file
	if(file_exists($filename)) unlink($filename);
	
	//upload sql file
	$file_name	= $_FILES['txt_file']['name'];
	if (!empty($file_name))
	{
		$filebody1 = $_FILES['txt_file']['size'];
		if ($filebody1!=0)
		{
		
			//get file name and check extension
			$tmp     = explode(".",$file_name);
			if(strtolower($tmp[1])!="sql")
			{
				//redirect back to the page
				$msg = urlencode("Please choose an sql file");
				header("location:index.php?Act=ip_country_update&msg=$msg");
				exit;			
			}
						
			//file body
			$filebody = $_FILES['txt_file']['tmp_name'];
			
			//destination for the image
			$dest    = "./".$filename;

			//copy file to the destination
			copy($filebody,$dest);
		}
		else
		{
			//redirect back to the page
			$msg = urlencode("Please choose an sql file");
			header("location:index.php?Act=ip_country_update&msg=$msg");
			exit;
		}
   }
   else
   {
		//redirect back to the page
		$msg = urlencode("Please choose an sql file");
		header("location:index.php?Act=ip_country_update&msg=$msg");
		exit;
   }	
   
   //open and read the file
   $fp = fopen($filename,"r");
   $content = fread($fp,filesize($filename));
   
   //separate lines
   $lines = explode("\n",$content);
   
   //read line by line
   for($i=0;$i<count($lines);$i++)
   {
   		//verify the data
		if(strtolower(substr($lines[$i],0,34))=="insert into `partners_countryflag`" or strtolower(substr($lines[$i],0,32))=="insert into partners_countryflag")		
		{
			//execute the sql
			mysql_query($lines[$i]);
			
			//if error
			if(mysql_error())
			{
				//redirect back to the page
				$msg = urlencode("Error while executing the sql");
				header("location:index.php?Act=ip_country_update&msg=$msg");
				exit;					
			}
		}
		else
		{
			//redirect back to the page
			$msg = urlencode("Please choose a valid sql file");
			header("location:index.php?Act=ip_country_update&msg=$msg");
			exit;		
		}
   }
   
   fclose($fp);
   
	//remove  file
	if(file_exists($filename)) unlink($filename);
	
	//redirect to page
	$msg = urlencode("Successfully Updated the Database");
	header("location:index.php?Act=ip_country_update&msg=$msg");
	exit;
	
?> 