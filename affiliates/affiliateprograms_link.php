<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="card">
	<div class="card-body">
		<a class="btn btn-fill btn-info" href="index.php?Act=cat&amp;joinstatus=All"><img src="../images/close.gif" border="0" alt="" />&nbsp;
			<b><?= $lang_affiliate_pgms_category ?></b></a>
		<a class="btn btn-fill btn-info" href="index.php?Act=Affiliates&amp;joinstatus=All"><img src="../images/close.gif" border="0" alt="" />&nbsp;
			<b><?= $lang_affiliate_pgms_all ?></b></a>
		<a class="btn btn-fill btn-info" href="index.php?Act=MyAffiliates&amp;joinstatus=myprograms"><img src="../images/close.gif" border="0" alt="" />&nbsp;
			<b><?= $lang_affiliate_pgms_my ?></b></a>
		<button type="button" class="btn btn-fill btn-warning" onclick=" return validatejoinAll()">Join All Programs</button>

	</div>
</div>



<script>
	//============Validation using Sweet Alert for joining All Programes by Affiliate =============//

	function validatejoinAll()
	{
			const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				// padding: 2,
				confirmButton: 'btn btn-success',
				cancelButton: 'btn btn-danger'
			},
			buttonsStyling: false
		})
		swalWithBootstrapButtons.fire({
			title: 'Are you sure?',
			text: "You want to join All programs?",
			icon: 'warning',
			showCancelButton: true,
			cancelButtonText: 'No, cancel!',
			confirmButtonText: 'Yes, Join All!',
			reverseButtons: false
		}).then((result) => {

			if (result.isConfirmed) {
				swalWithBootstrapButtons.fire({
					text: "All Programs joined successfully",
							icon: 'success',
							//showCancelButton: true,
							cancelButtonText: 'OK',

						});
				
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire(
					'Cancelled',
					'Programes joining Cancelled...!',
					'error'
				)
			}
		})
		$.ajax({
					type: "GET",
					url: "joinall_programs.php",
					success: function(text) {
						console.log(text);
						//alert(text);
						// swalWithBootstrapButtons.fire({
						// 	text: text,
						// 	icon: 'success',
						// 	//showCancelButton: true,
						// 	cancelButtonText: 'OK',

						// });
					}
				});
	}




	// function validatejoinAll() {

	// 	const swalWithBootstrapButtons = Swal.mixin({
	// 		customClass: {
	// 			// padding: 2,
	// 			confirmButton: 'btn btn-success',
	// 			cancelButton: 'btn btn-danger'
	// 		},
	// 		buttonsStyling: false
	// 	})

	// 	swalWithBootstrapButtons.fire({
	// 		title: 'Are you sure?',
	// 		text: "You want to join All programs?",
	// 		icon: 'warning',
	// 		showCancelButton: true,
	// 		cancelButtonText: 'No, cancel!',
	// 		confirmButtonText: 'Yes, Join All!',
	// 		reverseButtons: false
	// 	}).then((result) => {

	// 		if (result.isConfirmed) {

	// 			$.ajax({
	// 				type: "GET",
	// 				url: "joinall_programs.php",
	// 				async: false,
	// 				success: function(text) {
	// 					console.log(text);
	// 					//alert(text);
	// 					swalWithBootstrapButtons.fire({
	// 						text: text,
	// 						icon: 'success',
	// 						confirmButtonText: 'OK',
	// 						//showCancelButton: true,

	// 					}).then(result => {
	// 						//=================To reload the page after click on OK Button===============//
	// 						if (result.isConfirmed) {
	// 							window.location.reload();
	// 						}
	// 					});
	// 				}
	// 			});
	// 		} else if (
	// 			/* Read more about handling dismissals below */
	// 			result.dismiss === Swal.DismissReason.cancel
	// 		) {
	// 			swalWithBootstrapButtons.fire(
	// 				'Cancelled',
	// 				'Programs joining Cancelled...!',
	// 				'error'
	// 			)
	// 		}
	// 	})

	// }
</script>