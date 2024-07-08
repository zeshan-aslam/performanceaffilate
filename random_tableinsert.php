<?php


//inserting values to table //



     function RandomPassword( $passwordLength ) {
    		$password = "";
    		for ($index = 1; $index <= $passwordLength; $index++) {
         	// Pick random number between 1 and 10
         	$rand = rand(1, 10);
         	$password .= $rand;
    	}
    	return $password;
	}





 //geting records from table
 $password	=RandomPassword(10);
 $sql 		="INSERT INTO `random_gen` ( `rand_genid` , `rand_genpwd` )VALUES ( '', '$password')";
 $ret 		=mysqli_query($con, $sql);

 $secid		=mysqli_insert_id($con);
 $secpass   =$password;


?>