<?php 
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  adminusers_manage.php                          */
/*     CREATED ON     :  10/JULY/2006                                   */

/*		Validation, Creation, Deleting and  Editing of Admin Users  	*/
/************************************************************************/
	
    include_once '../includes/db-connect.php';                            
    include_once '../includes/session.php';
    include '../includes/constants.php';
    include '../includes/functions.php';
	include_once '../includes/function1.php';
    include_once '../includes/allstripslashes.php';
	
    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);
	
	$commonobj = new common();
	$adminobj 	= new adminuser();


	//getting Values
	$id			= 	intval(stripslashes(trim($_REQUEST['id'])));
	$username	=	stripslashes(trim($_REQUEST['txt_username']));
	$password	= 	stripslashes(trim($_REQUEST['txt_password']));
	$email		= 	stripslashes(trim($_REQUEST['txt_email']));
	$chk_mail	= 	trim($_REQUEST['chk_mail']);
	$mode		=   trim($_REQUEST['mode']);
	
	//Delete selected Admin User
	if($mode == 'delete')
	{
		if(!$adminobj->DeleteAdminUser($id))
		{
			$msg = urlencode("Unknown error!.  Deletion Failed");
		}
		else {
			$msg = urlencode("Admin User Deleted Successfully");
			//Deleting Admin Privileges
				$adminobj->GetAllAdminLinks();
				for($i=0; $i<count($adminobj->linkid); $i++)
				{	
					$key =	$users = $newusers = "";
					$linkid	= $adminobj->linkid[$i];   
					$users	= $adminobj->linkusers[$i];
					$userlist = explode(",",$users);
					$key 	= array_search($id,$userlist);  
					if($key >= 0)
					{
						if($userlist[$key] == $id)
						{
							$userlist[$key] = "";
							unset($userlist[$key]);
							$userlist	= array_values($userlist);
						}
					}
					if(count($userlist) > 0)
					{
						$newusers = implode(",",$userlist);
					} else {
						$newusers = "";
					}
					$adminobj->UpdateAdminUserLinks($linkid,$newusers);
				}
			//End deletion of Admin privileges
		}
		header("location: index.php?Act=adminusers&msg=$msg");
		exit;
	}
	
	//Validation Settings
	$validatestring		= $username."~*".$email."~*".$password;
	$returnstring   	= "txt_username=$username&txt_email=$email&txt_password=$password";
	if($id) 
	{
		$returnstring .= "&id=$id";
		$returnUrl	= "index.php?Act=adminuser_edit&$returnstring";
	} else
	{
		$returnUrl	= "index.php?Act=adminusers&$returnstring";
	}

	//check all mandatory fields
	if($commonobj->nullvalidation($validatestring))
	{
		//redirect the user to entry page along with message
		$msg        = urlencode("Don't leave fields blank");
		header("location: $returnUrl&msg=$msg");
		exit;
	}

	//Randomly generates password for the user
	//Removed as per Client Request
/*	$rand       = rand(0,10000);
	$password	= $username.$rand;
************************************/

	//UserName Validation
	if(!$adminobj->IsUserNameExists($username,$id))
	{
		$msg = urlencode("User Name already exists");
		header("location: $returnUrl&msg=$msg");
		exit;
	}
	
	//Email Validation
	if($partners->is_email($email)==0)
	{	
		$msg = urlencode("Enter a valid Email Address");
		header("location: $returnUrl&msg=$msg");
		exit;
	}
	
	//checks if email already exists
	if(!$adminobj->IsEmailexists($email,$id))
	{
		$msg = urlencode("Email Address already exists");
		header("location: $returnUrl&msg=$msg");
		exit;
	}

	// If id exists Edit the User
	if($id)
	{
		if($mode == 'edit')
		{			
			if(!$adminobj->UpdateAdminUser($id, $username, $email,$password))
			{
				$msg = urlencode("Unknown error!.  Updation Failed");
				header("location: $returnUrl&msg=$msg");
				exit;
			}
			else
			{
				$msg = urlencode("Admin User Details Updated Successfully");
				if($chk_mail) 
				{
					//Get Mail Details of the Super Admin
					if($adminobj->GetSuperAdmin())
					{
						$to     	=    $email;
						$subject	= "Admin User Details Updated";
						$from		= $adminobj->admin_email;
						$adminheader= $adminobj->admin_header;
						$adminfooter= $adminobj->admin_footer;
						
						$adminobj->SendMailtoAdminUser($to,$subject,$from,$adminheader,$username,$password,$adminfooter);
					}
				}
			}
		}
	}
	else //Insert new user
	{
		if(!$adminobj->AddAdminUser($username,$email,$password))
		{
			$msg = urlencode("Unknown error!.  Insertion Failed");
			header("location: $returnUrl&msg=$msg");
			exit;
		}
		else
		{
			$msg = urlencode("Admin User Added Successfully");
			if($chk_mail) 
			{
				//Get Mail Details of the Super Admin
				if($adminobj->GetSuperAdmin())
				{
					$to     	=    $email;
					$subject	= "Registered as Admin User";
					$from		= $adminobj->admin_email;
					$adminheader= $adminobj->admin_header;
					$adminfooter= $adminobj->admin_footer;
					
					$adminobj->SendMailtoAdminUser($to,$subject,$from,$adminheader,$username,$password,$adminfooter);
				}
			}
		}
	}
		

	header("location:index.php?Act=adminusers&msg=$msg");
	exit;

?>