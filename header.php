<?

$activeClassMerchants = $activeClassAffiliates = $activeClassDirectory = $activeClassLogin = $activeClassAboutus = $activeClassContactus = $activeClassHome = 'top-links';
if($Act == 'Merchants'){
	$activeClassMerchants = 'topLinksMerchant';
}
else if($Act == 'Affiliates'){
	$activeClassAffiliates = 'topLinksAffiliates';
}
else if($Act == 'directory'){
	$activeClassDirectory = 'topLinksDirectory';
}
else if($Act == 'login'){
	$activeClassLogin = 'topLinksLogin';
}
else if($Act == 'aboutus'){
	$activeClassAboutus = 'topLinksAboutus';
}
else if($Act == 'contactus'){
	$activeClassContactus = 'topLinksContactus';
}
else if($Act == ''){
	$activeClassHome = 'topLinksHome';
}
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/header.jpg" width="960" height="105" /></td>
	</tr>
	<tr>
		<td>
		<table width="950" border="0" align="center" cellpadding="0" cellspacing="0" class="top-nav">
			<tr>
				<td width="116" height="35" align="center"class="<? echo $activeClassHome;?>"><a href="index.php" class="top-links"><?=$lang_Home?></a></td>
				<td width="150" align="center" class="<? echo $activeClassMerchants;?>"><a href="index.php?Act=Merchants" class="top-links" ><?=$lang_Merchants?></a></td>
				<td width="141" align="center" class="<? echo $activeClassAffiliates;?>"><a href="index.php?Act=Affiliates" class="top-links"><?=$lang_Affiliates?></a></td>
				<td width="142" align="center" class="<? echo $activeClassDirectory;?>"><a href="index.php?Act=directory" class="top-links"><?=$lang_Directory?></a></td>
				<td width="121" align="center" class="<? echo $activeClassLogin;?>"><a href="index.php?Act=login" class="top-links"><?=$lang_Login?></a></td>
				<td width="143" align="center" class="<? echo $activeClassAboutus;?>"><a href="index.php?Act=aboutus" class="top-links"><?=$lang_About?></a></td>
				<td width="137" align="center" class="<? echo $activeClassContactus;?>"><a href="index.php?Act=contactus" class="top-links"><?=$lang_Contact?></a></td>
			</tr>
		</table>
		</td>
	</tr>
</table>