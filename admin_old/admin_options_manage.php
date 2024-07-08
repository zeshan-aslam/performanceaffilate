<?php	

  include_once '../includes/db-connect.php';
  include '../includes/session.php';
  include '../includes/constants.php';
  include '../includes/functions.php';
  include '../includes/allstripslashes.php';
  include '../includes/function1.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);

	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];

  $url        ="index.php?Act=options";
 switch($action)
 {
 	case 'Modify Mail':
			$mail=$_POST['mail'];
			if(!$partners->is_email($mail))
			{
				  $msg        ="adopt2000";
			}
			else
			{
				//checks if email already exists
				if(!$userobj->IsEmailexists($mail,$adminUserId))
				{
					$msg = "adopt2014";
					break;
				}

				if($_SESSION['ADMINUSERID'] == '1')
				{
					$sql        ="UPDATE partners_admin SET admin_email='$mail'";
					$ret        =mysqli_query($con,$sql);
				}
				$sql	= "UPDATE partners_adminusers SET adminusers_email='$mail' WHERE adminusers_id='".$_SESSION['ADMINUSERID']."'";
				$ret	= mysqli_query($con,$sql);
				
				if($ret)
				{
						$msg           ="adopt2001";
						$_SESSION['MAIL']          =$mail;
				}
				else  $msg             ="adopt2002";
			}
	  		break;
	
	  case 'Modify Login':
	 		$login        =stripslashes(trim($_POST['login']));
			if(empty($login) or strlen($login)>15)
			{
				 $msg        ="adopt2003";
			}
			else
			{
				//UserName Validation
				if(!$userobj->IsUserNameExists($login,$adminUserId))
				{
					$msg = "adopt2015";
					break;
				}			
				$login1      =addslashes($login);
				if($_SESSION['ADMINUSERID'] == '1')
				{
					$sql        ="UPDATE partners_admin SET admin_login='$login1'";
					$ret        =mysqli_query($con,$sql);
				}
				$sql	= "UPDATE partners_adminusers SET adminusers_login='$login1' WHERE adminusers_id='".$_SESSION['ADMINUSERID']."'";
				$ret	= mysqli_query($con,$sql);
				
				if($ret)
				{
					$msg    ="adopt2004";
					$_SESSION['ADMIN']  =stripslashes($login);
				}
				else  $msg      ="adopt2002";
			}
		  	break;
	
	  case 'Modify Password':
			$pass1        =(trim($_POST['pass1']));
			$pass2        =(trim($_POST['pass2']));
			$pass3        =(trim($_POST['pass3']));
			if(empty($pass1) or strlen($pass1)>15 or empty($pass2) or strlen($pass2)>15 or empty($pass3) or strlen($pass3)>15 )
			{
				 $msg        ="adopt2005";
			}
			elseif($pass2!=$pass3){
			 $msg        ="adopt2006";
			}
			else
			{ 
				$pass1        =(addslashes(trim($_POST['pass1'])));
				//$sql        ="SELECT admin_password FROM partners_admin WHERE admin_password='$pass1'";
				$sql        ="SELECT adminusers_password FROM partners_adminusers WHERE adminusers_password='$pass1' AND adminusers_id='".$_SESSION['ADMINUSERID']."'";
				$ret        =mysqli_query($con,$sql);
				
				if(!mysqli_num_rows($ret)){
					 $msg        ="adopt2007";
				}
				else
				{
					$pass4=addslashes($pass2);
					
					if($_SESSION['ADMINUSERID'] == '1')
					{
						$sql        ="UPDATE partners_admin SET admin_password='$pass4'";
						$ret        =mysqli_query($con,$sql);
					}
					$sql	= "UPDATE partners_adminusers SET adminusers_password='$pass4' WHERE adminusers_id='".$_SESSION['ADMINUSERID']."'";
					$ret	= mysqli_query($con,$sql);
					
					if($ret)
					{
							$msg         ="adopt2008";
					}
					else  $msg           ="adopt2002";
				}
			}
	  		break;
	
	  case 'Change Title':
			$new_title=stripslashes(trim($_POST['new_title']));
			if(!empty($new_title))
			{
				$filename  ="../includes/constants.php";
				$fd = fopen ($filename, "r");
				$contents = fread ($fd, filesize ($filename));
				fclose($fd);
	
				$conts        =explode("\n",$contents);
				$n        =count($conts);
				for ($i=0; $i<$n; $i++) 
				{
				   $tmp        =explode("=",$conts[$i]);
				   $tmp1        =trim($tmp[0]);
				   //echo $tmp1."<br/>";
				   if($tmp1=="$"."title"){
						$conts[$i]        =str_replace($title,$new_title,$conts[$i]);
						continue;
				   }
				}
	
				$fd = fopen ($filename, "w");
				$cont1  =implode("\n",$conts);
				fwrite($fd,$cont1);
				fclose($fd);
				$msg ="adopt2009";
			} 
			else 
				 $msg ="adopt2010";
		  	break;
	
	  case 'Change Lines/Page':
			$number=trim($_POST['number']);
			$number        =$number;
			if($number)
			{
				 if(is_numeric($number))
				 {
					$filename  ="../includes/constants.php";
					$fd = fopen ($filename, "r");
					$contents = fread ($fd, filesize ($filename));
					fclose($fd);
	
					$conts        =explode("\n",$contents);
					$n        =count($conts);
					for ($i=0; $i<$n; $i++) 
					{
					   $tmp        =explode("=",$conts[$i]);
					   $tmp1        =trim($tmp[0]);
					   if($tmp1=="$"."lines"){
										$conts[$i]        =str_replace($lines,$number,$conts[$i]);
							 continue;
					   }
					}
	
					$fd = fopen ($filename, "w");
					$cont1  =implode("\n",$conts);
					fwrite($fd,$cont1);
					fclose($fd);
					$msg ="adopt2011";
				}
				else  $msg ="adopt2012";
			} 
			else  $msg ="adopt2010";
	  		break;
	
	  case 'Error Page Setting' :
			$content=stripslashes($_POST['error']);
			if($content)
			{
				$filename="error.htm";
				$fp = fopen($filename,'w');
			   //Added by DPT on 25/May/2005 to remove php source code
			   $content = str_replace("<?php","",$content);
			   $content = str_replace("<?","",$content);
			   $content = str_replace("?>","",$content);
		
			   fwrite($fp,$content);
			   fclose($fp);
				$msg ="adopt2013";
			}
			else  
				$msg ="adopt2010";
		   	break;
	
 }
  header("Location:$url&msg=$msg");
  exit;
?>