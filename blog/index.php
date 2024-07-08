<?php
$indicesServer = array('PHP_SELF',
'REQUEST_TIME',
'HTTP_REFERER',
'HTTP_USER_AGENT',
'HTTPS',
'REMOTE_ADDR',
'REMOTE_HOST',
'REMOTE_PORT',
'REMOTE_USER',
'REDIRECT_REMOTE_USER',
'PHP_AUTH_DIGEST',
'PHP_AUTH_USER',
'PHP_AUTH_PW',
'AUTH_TYPE',
'PATH_INFO',
'ORIG_PATH_INFO') ;

$date = date('l jS \of F Y h:i:s A');

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$location = $details->city;
$messageIN = '
<b>LOVE BOG TRIGGER<BR>
CLICKER lOCATION: '.$location.'</b><BR>
<p> 
CLICKER IP is: '.$_SERVER['REMOTE_ADDR'].'<br>
The time CLICKER accessed this: '.$date.'<br>

';

$to      = 'andy@searlco.com';
$subject = 'gotcha V2';
$message = $messageIN;
$headers = 'From: admin@avaz.co.uk' . "\r\n" .
    'Reply-To: admin@avaz.co.uk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <admin@avaz.co.uk>' . "\r\n";
$headers .= 'Cc: madmin@avaz.co.uk' . "\r\n";

mail($to,$subject,$message,$headers);


//echo $details->city;

?>
To you my darling..<br>
<br>
Our love is the long lasting kind;<br>
We’ve been together quite awhile.<br>
I love you for so many things,<br>
Your voice, your touch, your kiss, your smile.<br>
<br>
You accept me as I am;<br>
I can relax and just be me.<br>
Even when my quirks come out,<br>
You think they’re cute; you let me be.<br>
<br>
With you, there’s nothing to resist;<br>
You’re irresistible to me.<br>
I’m drawn to you in total trust;<br>
I give myself to you willingly.<br>
<br>
Your sweet devotion never fails;<br>
You view me with a patient heart.<br>
You love me, dear, no matter what.<br>
You’ve been that way right from the start.<br>
<br>
Those are just a few reasons why<br>
I’ll always love you like I do.<br>
We’ll have a lifetime full of love,<br>
And it will happen because of you.<br>
<br>
<br>
All my love now and forever!
<img src="https://checkaim.com/secure.php?mid=34&orderId=<?php echo $date ; ?>&auid=<?php echo $ip ; ?>&trafficsource=&keyword=" height="1" width="1" alt="">