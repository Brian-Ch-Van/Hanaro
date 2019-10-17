
	<link href="<?php echo CSS_URL; ?>/bootstrap.min.css" rel="stylesheet" >
	
	<!-- favicon -->
    <link rel="shortcut icon" href="<?php echo ICON_URL; ?>/h_favicon.png" />

	<!-- jQuery -->
	<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
	
	<!-- jQuery loading 후 올라가야 modal에서 error 안 남 -->
	<script src="<?php echo JS_URL; ?>/bootstrap.bundle.min.js"></script>
		
	<script type="text/javascript">
		$(document).ready(function () {
			
			$('.modal-title').text('WARNING');
			$('#modalHeader').addClass('bg-danger');
			$('#modalMsg').text('Only your profile can be viewed. Click the OK button to go to the Home.');
	
			$('#cnfModal').modal({
				backdrop : 'static',
				keyboard : false
			});
	// 		$('#cnfModal').modal('show');

			$('#cnfModal').on('hidden.bs.modal', function (e) {
			    location.href = "<?php echo URL;?>";
			});
			
		});
	
	</script>

	<div class="modal fade madal-lg" id="cnfModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				
				<div class="modal-header text-white" id="modalHeader">
					<h5 class="modal-title" id="modalCenterTitle"></h5>
					<!-- 
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					-->
				</div>
				
				<div class="modal-body bg-light text-body" id="modalMsg">
					<!-- message -->
				</div>
				
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="confirmModal" style="width: 100px; cursor: pointer;">OK</button>
				</div>
				
			</div>
		</div>
	</div>