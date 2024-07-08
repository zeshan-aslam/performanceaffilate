
<!--
<div class="row"> 
	<div class="col-md-12">
		<div class="card"> 
			<div class="card-body">
				<div class="row">
					<div class="col-md-6 text-left">
						<p>Please select what link type you require ?</p>
					</div>
					<div class="col-md-6 text-right">
						<a href="index.php?Act=sub_id_list">&laquo;<?=$lang_home_manage_subid?>&raquo;</a>			
					</div>
				</div>
			</div>	
		</div>	 
	</div>	  
</div>   
	 
<div class="row"> 
	<div class="col-md-6"> 
		<div class="card regular-table-with-color">
			<div class="card-body table-full-width table-responsive">
				
				<table class="table table-hover">
					<thead> 
						<tr>
							<th><?=$lang_home_text?></th>
						</tr> 
					</thead>
					<tbody>
						<tr>  
							<td><?=$lang_text_help?></td>
						</tr> 
						<tr>
							<td><a class="btn btn-round btn-info" href="index.php?Act=gettext">Text Link</a></td>
						</tr>
					</tbody>	
				</table>
			</div>	
		</div>	 
	</div>	 
	<div class="col-md-6">
		<div class="card regular-table-with-color">
			<div class="card-body table-full-width table-responsive">
				<table class="table table-hover">
					<thead> 
						<tr>
							<th><?=$lang_home_banner?></th>
						</tr> 
					</thead>
					<tbody>
						<tr>
							<td><?=$lang_banner_help?></td>
						</tr>  
						<tr>
							<td><a class="btn btn-round btn-info" href="index.php?Act=getbanner">Banner Links</a></td>
						</tr>
					</tbody>	
				</table>
			</div>	
		</div>	 
	</div>	 
</div>   
-->
<?php

	$Act = $_GET['Act'];
?>

<ul class="nav nav-tabs">
  
  <li class="nav-item">
  	<a class='bannertextlinks nav-link <?php echo ($Act == "getbanner") ? "active" : "";  ?>' data-href="index.php?Act=getbanner" href="javascript:void(0)" >
  		Banner Links
  	</a>
  </li>

  <li class="nav-item">
    <a class="bannertextlinks nav-link <?php echo ($Act == 'gettext') ? 'active' : '';  ?>" data-href="index.php?Act=gettext" href="javascript:void(0)">
    	Text Links
    </a>
  </li>
  
</ul> 

<script>

	$(document).ready(function(){

		$(".bannertextlinks").on("click", function(){

			var actionurl = $(this).data("href");

			$("form[name=f1]").attr("action",actionurl);

			document.f1.submit();

		});

	});

</script>