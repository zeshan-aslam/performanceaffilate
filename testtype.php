<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>AVAZ Tracking System Test Kit Part 2</title>
</head>

<body>
AVAZ Tracking System Test Kit Part 2
<p></p>
<p></p>

<p></p>
<?php

		$tidVal = "";

		if(isset($_REQUEST["tid"]))
		{
				$tidVal = "&tid=".$_REQUEST["tid"];
		}

?>

<p>Program ID: Image Lead <a href="https://avaz.co.uk/track_test.php?testtype=1<?php echo $tidVal; ?>">[GO]</a></p>
<p>Program ID: Java Lead <a href="https://avaz.co.uk/track_test.php?testtype=2<?php echo $tidVal; ?>">[GO]</a></p>
<p>Program ID: Image Sale <a href="https://avaz.co.uk/track_test.php?testtype=3<?php echo $tidVal; ?>">[GO]</a></p>
<p>Program ID: Java Sale <a href="https://avaz.co.uk/track_test.php?testtype=4<?php echo $tidVal; ?>">[GO]</a></p>


</body>

</html>
