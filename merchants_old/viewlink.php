<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  viewlink.php  		   		            	    */
/*     CREATED ON     :  25/JULY/2006                                   */

/*		View the header or the footer of the merchants link				*/
/************************************************************************/

	include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
    include_once '../includes/function1.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

	$merid	= intval($_REQUEST['merid']);
	$disp	=	$_REQUEST['disp'];
	
	$linkobj	= new merchantLink();

	$linkobj->merchantSignUpLink($merid);
	if($disp == 'header')
	{
		$code = stripslashes(trim($linkobj->mer_header));
	}
	else {
		$code = stripslashes(trim($linkobj->mer_footer));
	}
	$code = $code;
?>	
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr>
			<td><? echo html_entity_decode($code); ?></td>
		</tr>
	</table>
	
