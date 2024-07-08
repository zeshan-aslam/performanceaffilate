	<form name="langform" action="" method="post">
	<?
		$sqllang 	= "SELECT * FROM partners_languages WHERE languages_status = 'active'";
		$reslang 	= mysqli_query($con, $sqllang);
		if(mysqli_num_rows($reslang)>0){
			echo $lang_language?> : 
			<select name="languageid" onchange="javascript:langform.submit();" class="selectLogin">
			<?
			while($rowlang = mysqli_fetch_object($reslang)){
				$langsel = "";
				if($language==$rowlang->languages_id) 
					$langsel = "selected = 'selected'";
			?>
	
				<option value="<?=$rowlang->languages_id?>" <?=$langsel?>>
				<?=stripslashes($rowlang->languages_name)?>
				</option>
			<?
			}
			?>
			</select>
		<?
		}
		?>
	</form>