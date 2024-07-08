<?php	ob_start();
  //Last Modified by DPT on June/1/05 to add provision for updating maximum amount limits for merchants/affiliates/admin
  //Last Modified by DPT pn August/1/05 to add provision for setting flatrate/percentage for click/lead/sale rate
  
  include '../includes/session.php';
  include '../includes/constants.php';
  include '../includes/functions.php';
  include_once '../includes/allstripslashes.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);

  $url        ="index.php?Act=setpayments";
  switch($action){

  // Modified on 16-JUNE-06
   case 'Modify Impression':
    $imprate        =trim($_POST['imprate']);

    $imprate        =$imprate;

    if(is_numeric($imprate)){
            $filename		= "../includes/constants.php";
            $fd             = fopen ($filename, "r");
            $contents       = fread ($fd, filesize ($filename));
            fclose($fd);
            $conts                =explode("\n",$contents);
            $n                        =count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp                =explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."const_imp_rate"){
                       $conts[$i]        =str_replace($const_imp_rate,$imprate,$conts[$i]);
                       continue;
                   }
            }
        $fd = fopen ($filename, "w");
       $cont1  =implode("\n",$conts);
        fwrite($fd,$cont1);
            fclose($fd);
            $msg ="Impression Rate Changed";
    } else  $msg ="Error: Invalid entry";
  break;
//End Modify


  case 'Modify Normal Amount':
    $normal        =trim($_POST['normal']);
    $normal        =$normal;
    if(is_numeric($normal)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	=explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."normal_user"){
                       $conts[$i]        =str_replace($normal_user,$normal,$conts[$i]);
                       continue;
                   }
            }
        $fd = fopen ($filename, "w");
       $cont1  =implode("\n",$conts);
        fwrite($fd,$cont1);
            fclose($fd);
            $msg ="Normal Users Subscription Rate Changed";
    } else  $msg ="Error: Invalid entry";
  break;

   case 'Modify Advanced Amount':
    $advanced        =trim($_POST['advanced']);
    $advanced        =$advanced;
    if(is_numeric($advanced)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	=explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."advanced_user"){
                       $conts[$i]        =str_replace($advanced_user,$advanced,$conts[$i]);		   		   
                       continue;
                   }
				 
            }

        $fd = fopen ($filename, "w");
            $cont1  =implode("\n",$conts);
        fwrite($fd,$cont1);
            fclose($fd);
            $msg ="Advanced Users Subscription Rate Changed";
    } else  $msg ="Error: Invalid entry";
  break;  


   case 'Modify Minimum Amount':
    $minimum_amount1        =trim($_POST['minimumamount']);
    $minimum_amount1        =$minimum_amount1;
    if(is_numeric($minimum_amount1)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	=explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."minimum_amount"){
						$conts[$i]        =str_replace($minimum_amount,$minimum_amount1,$conts[$i]);  
						continue;
                   }				   
            }
        $fd = fopen ($filename, "w");
        $cont1  =implode("\n",$conts);
        fwrite($fd,$cont1);
		fclose($fd);
		$msg ="Minimum Merchant Amount  Changed";
    } else  $msg ="Error: Invalid entry";
  break;

   case 'Modify Click Amount':
    $click        =trim($_POST['click']);
    $click        =$click;
	//click rate type
	$click_type	= $_POST['rad_click_type'];
    if(is_numeric($click)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	=explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."admin_clickrate"){
                       $conts[$i]        =str_replace($admin_clickrate,$click,$conts[$i]);
                       continue;
                   }
				   //click rate type
                   if($tmp1=="$"."admin_clickrate_type"){
                       $conts[$i]        =str_replace($admin_clickrate_type,$click_type,$conts[$i]);
                       continue;
                   }
            }

        $fd = fopen ($filename, "w");
            $cont1  =implode("\n",$conts);
        fwrite($fd,$cont1);
            fclose($fd);
            $msg ="Click Rate Changed";
    } else  $msg ="Error: Invalid entry";
  break;

case 'Modify Lead Amount':
    $lead        =trim($_POST['lead']);
    $lead        =$lead;
	//lead rate type
	$lead_type	= $_POST['rad_lead_type'];
    if(is_numeric($lead)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	=explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."admin_leadrate"){
                       $conts[$i]        =str_replace($admin_leadrate,$lead,$conts[$i]);
                       continue;
                   }
				   //lead rate type
                   if($tmp1=="$"."admin_leadrate_type"){
                       $conts[$i]        =str_replace($admin_leadrate_type,$lead_type,$conts[$i]);
                       continue;
                   }				   
            }

        $fd = fopen ($filename, "w");
            $cont1  =implode("\n",$conts);
        fwrite($fd,$cont1);
            fclose($fd);
            $msg ="Lead Rate Changed";
    } else  $msg ="Error: Invalid entry";
  break;

    case 'Minimum Withdraw Amount':
    $lead        =trim($_POST['withdraw']);

   // echo $lead."ddasas";

    $lead        =$lead;
    if(is_numeric($lead)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	=explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."minimum_withdraw"){
                       $conts[$i]        =str_replace($minimum_withdraw,$lead,$conts[$i]);
                       continue;
                   }
            }

        $fd = fopen ($filename, "w");
            $cont1  =implode("\n",$conts);
        fwrite($fd,$cont1);
            fclose($fd);
            $msg ="Minimum Withdraw Amount Changed";
    } else  $msg ="Error: Invalid entry";
  break;

   case 'Modify Sale Amount':
    $sale        =trim($_POST['sale']);
    $sale        =$sale;
	//sale rate type
	$sale_type	= $_POST['rad_sale_type'];
    if(is_numeric($sale)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	= explode("\n",$contents);
            $n        		= count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	= explode("=",$conts[$i]);
                   $tmp1        = trim($tmp[0]);
                   if($tmp1=="$"."admin_salerate"){
                       $conts[$i]        =str_replace($admin_salerate,$sale,$conts[$i]);
                       continue;
                   }
				   //sale rate type
                   if($tmp1=="$"."admin_salerate_type"){
                       $conts[$i]        =str_replace($admin_salerate_type,$sale_type,$conts[$i]);
                       continue;
                   }				   
            }

        $fd = fopen ($filename, "w");
            $cont1  =implode("\n",$conts);
        fwrite($fd,$cont1);
            fclose($fd);
            $msg ="Sale Rate Changed";
    } else  $msg ="Error: Invalid entry";
  break;

  case 'Program Type':
        $sale        =trim($_POST['programtype']);

           if(is_numeric($sale)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	= explode("=",$conts[$i]);
                   $tmp1        = trim($tmp[0]);
                   if($tmp1=="$"."program_type"){
                       $conts[$i]        =str_replace($program_type,$sale,$conts[$i]);

                       continue;
                   }
            }


           $fd     =  fopen ($filename, "w");
           $cont1  = implode("\n",$conts);

           fwrite($fd,$cont1);
           fclose($fd);

           if($sale==2){
                           $recur_value     = intval(trim($_POST['recur_value']));
                           $recur_period    = trim($_POST['recur_period']);
                           $value  			= $recur_value." ".$recur_period;
                           $filename  		= "../includes/constants.php";
            			   $fd              = fopen ($filename, "r");
                           $contents        = fread ($fd, filesize ($filename));
                           fclose($fd);
                           $conts          =explode("\n",$contents);
                           $n              =count($conts);
                           for ($i=0; $i<$n; $i++) {
                                  $tmp         = explode("=",$conts[$i]);
                                  $tmp1        = trim($tmp[0]);
                                  if($tmp1=="$"."program_value"){
                                      $conts[$i]        =str_replace($program_value,$value,$conts[$i]);

                                      continue;
                                  }
                           }


                          $fd     =  fopen ($filename, "w");
                          $cont1  = implode("\n",$conts);

                          fwrite($fd,$cont1);
                          fclose($fd);
            }

           $msg ="Program Type Changed";
    } else $msg ="Error: Invalid entry";
    break;
    case 'Membership Type':
        	$sale        =trim($_POST['membershiptype']);

           if(is_numeric($sale)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	= explode("=",$conts[$i]);
                   $tmp1        = trim($tmp[0]);
                   if($tmp1=="$"."membership_type"){
                       $conts[$i]        =str_replace($membership_type,$sale,$conts[$i]);

                       continue;
                   }
            }


           $fd     =  fopen ($filename, "w");
           $cont1  = implode("\n",$conts);

           fwrite($fd,$cont1);
           fclose($fd);

           if($sale==2){
                           $recur_value     = intval(trim($_POST['recurMem_value']));
                           $recur_period    = trim($_POST['recurMem_period']);
                           $value  			= $recur_value." ".$recur_period;
                           $filename  		= "../includes/constants.php";
            			   $fd              = fopen ($filename, "r");
                           $contents        = fread ($fd, filesize ($filename));
                           fclose($fd);
                           $conts          =explode("\n",$contents);
                           $n              =count($conts);
                           for ($i=0; $i<$n; $i++) {
                                  $tmp         = explode("=",$conts[$i]);
                                  $tmp1        = trim($tmp[0]);
                                  if($tmp1=="$"."membership_value"){
                                      $conts[$i]        =str_replace($membership_value,$value,$conts[$i]);

                                      continue;
                                  }
                           }


                          $fd     =  fopen ($filename, "w");
                          $cont1  = implode("\n",$conts);

                          fwrite($fd,$cont1);
                          fclose($fd);
            }

           $msg ="Membership Type Changed";
    } else $msg ="Error: Invalid entry";
    break;
    case 'Program Fee':
    $sale        =trim($_POST['program']);
    $sale        =$sale;
           if(is_numeric($sale)){
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	= explode("=",$conts[$i]);
                   $tmp1        = trim($tmp[0]);
                   if($tmp1=="$"."program_fee"){
                       $conts[$i]        =str_replace($program_fee,$sale,$conts[$i]);
                       continue;
                   }
            }

           $fd = fopen ($filename, "w");
           $cont1  =implode("\n",$conts);
           fwrite($fd,$cont1);
           fclose($fd);
           $msg ="Program Fee Changed";
    } else $msg ="Error: Invalid entry";
  break;
  
  	//---------Added By DPT on June/1/05--------------
	//Update maximum amount limit for merchants
    case 'Modify For Merchants':
			//get amount
			$amount        =trim($_POST['maximum_merchant']);
			
			//if numeric value
			if(is_numeric($amount))
			{
				//get the content from constants file
				$filename  		= "../includes/constants.php";
				$fd 			= fopen ($filename, "r");
				$contents 		= fread ($fd, filesize ($filename));
				fclose($fd);
				$conts        	= explode("\n",$contents);
				$n        		= count($conts);
				//get line by line
				for ($i=0; $i<$n; $i++) 
				{
					$tmp         = explode("=",$conts[$i]);
					$tmp1        = trim($tmp[0]);
					//if this is the variable to be replaced
					if($tmp1=="$"."merchant_maximum_amount")
					{
						//replace with new value
						$conts[$i]        = str_replace($merchant_maximum_amount,$amount,$conts[$i]);
						continue;
					}
				}
				
				//write the new content into the file
				$fd 			= fopen ($filename, "w");
				$cont1  		= implode("\n",$conts);
				fwrite($fd,$cont1);
				fclose($fd);

				/*write the message to an htm file				
				$filename		= "merchant_maximum_balance_msg.htm";
				$fp 			= fopen($filename,'w');*/
				$content		= stripslashes($_POST['txta_merchant_message']);
				
				//remove php source code
				$content = str_replace("<?php","",$content);
				$content = str_replace("<?","",$content);
				$content = str_replace("?>","",$content);
				
				/*fwrite($fp,$content);
				fclose($fp);				*/
				
				$msg 			= "Maximum amount limit for merchant is updated";
			} 
			else $msg 			= "Error: Invalid Entry";
			break;  
			
	//Update maximum amount limit for affiliates			
    case 'Modify For Affiliates':
			//get amount
			$amount        =trim($_POST['maximum_affiliate']);
			
			//if numeric value
			if(is_numeric($amount))
			{
				//get the content from constants file
				$filename  		= "../includes/constants.php";
				$fd 			= fopen ($filename, "r");
				$contents 		= fread ($fd, filesize ($filename));
				fclose($fd);
				$conts        	= explode("\n",$contents);
				$n        		= count($conts);
				//get line by line
				for ($i=0; $i<$n; $i++) 
				{
					$tmp         = explode("=",$conts[$i]);
					$tmp1        = trim($tmp[0]);
					//if this is the variable to be replaced
					if($tmp1=="$"."affiliate_maximum_amount")
					{
						//replace with new value
						$conts[$i]        = str_replace($affiliate_maximum_amount,$amount,$conts[$i]);
						continue;
					}
				}
				
				//write the new content into the file
				$fd 			= fopen ($filename, "w");
				$cont1  		= implode("\n",$conts);
				fwrite($fd,$cont1);
				fclose($fd);
				
				/*write the message to an htm file				
				$filename		= "affiliate_maximum_balance_msg.htm";
				$fp 			= fopen($filename,'w');*/
				$content		= stripslashes($_POST['txta_affiliate_message']);
				
				//remove php source code
				$content = str_replace("<?php","",$content);
				$content = str_replace("<?","",$content);
				$content = str_replace("?>","",$content);
				
				/*fwrite($fp,$content);
				fclose($fp);					*/
				$msg 			= "Maximum amount limit for affiliate is updated";
			} 
			else $msg 			= "Error: Invalid Entry";
			break;  
			
	//Update maximum amount limit for admin			
    case 'Modify For Admin':
			//get amount
			$amount        =trim($_POST['maximum_admin']);
			
			//if numeric value
			if(is_numeric($amount))
			{
				//get the content from constants file
				$filename  		= "../includes/constants.php";
				$fd 			= fopen ($filename, "r");
				$contents 		= fread ($fd, filesize ($filename));
				fclose($fd);
				$conts        	= explode("\n",$contents);
				$n        		= count($conts);
				//get line by line
				for ($i=0; $i<$n; $i++) 
				{
					$tmp         = explode("=",$conts[$i]);
					$tmp1        = trim($tmp[0]);
					//if this is the variable to be replaced
					if($tmp1=="$"."admin_maximum_amount")
					{
						//replace with new value
						$conts[$i]        = str_replace($admin_maximum_amount,$amount,$conts[$i]);
						continue;
					}
				}
				
				//write the new content into the file
				$fd 			= fopen ($filename, "w");
				$cont1  		= implode("\n",$conts);
				fwrite($fd,$cont1);
				fclose($fd);
				
				/*write the message to an htm file				
				$filename		= "admin_maximum_balance_msg.htm";
				$fp 			= fopen($filename,'w');*/
				$content		= stripslashes($_POST['txta_admin_message']);
				
				//remove php source code
				$content = str_replace("<?php","",$content);
				$content = str_replace("<?","",$content);
				$content = str_replace("?>","",$content);
				
				/*fwrite($fp,$content);
				fclose($fp);					*/
				$msg 			= "Maximum amount limit for admin is updated";
			} 
			else $msg 			= "Error: Invalid Entry";
			break;  									
		//---------End of Addition by DPT--------------

  }

  header("Location:$url&msg=$msg");
  exit;

?>