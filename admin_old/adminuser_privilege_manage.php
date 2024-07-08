<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  adminuser_edit.php                             */
/*     CREATED ON     :  10/JULY/2006                                   */

/*	Page to set privileges to admin user. 								*/
/************************************************************************/


    include_once '../includes/session.php';
    include '../includes/constants.php';
    include '../includes/functions.php';
	include_once '../includes/function1.php';
    include_once '../includes/allstripslashes.php';
	
    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);
	
	$adminobj 	= new adminuser();

	$id = $_REQUEST['id'];
	$adminobj->GetAllAdminLinks();
	 
	for($i=0; $i<count($adminobj->linkid); $i++)
	{	$key =	$users = $userLink = $newusers = "";
		$linkid	= $adminobj->linkid[$i];   
		$users	= $adminobj->linkusers[$i];  
		$userLink	= $_REQUEST['chk_'.$linkid];  
		if($userLink)
		{
			if($users != '')
			{
				$userlist = explode(",",$users);
				if(!in_array($id,$userlist))
				{
					$newusers = $users.",".$id;
				}
				else {
					$newusers = $users;
				}
			}
			else
			{
				$newusers = $id;
			}
		}
		else
		{
			if($users != '')
			{
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
			}
			else
			{
				 $newusers = "";
			}
		} 
		$adminobj->UpdateAdminUserLinks($linkid,$newusers);
	}
 
	$msg = "Link Privilege Updated";
	header("Location: index.php?Act=adminuser_privilege&id=$id&msg=$msg");
	exit;

?>