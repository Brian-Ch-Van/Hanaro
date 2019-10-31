<?php 
	echo '<br><br><br><br><br>';
	echo 'User role : ';
	print_r($userRoleList);
	echo '<br>';
	echo 'Role auth screen list : ';
	print_r(array_column($userScreenList, 'screen_name'));
	echo '<br>';
	echo 'Current screen name : ' . $curScreenName . '<br>';
	echo 'No authority!!';
?>
	<script type="text/javascript">
		$(document).ready(function () {
			
			$('.modal-title').text('WARNING');
			$('#modalHeader').addClass('bg-danger');
			$('#modalMsg').text('You can not access this page by your authority. Contact to the system manager');
	
			$('#noAccModal').modal({
				backdrop : 'static',
				keyboard : false
			});
	// 		$('#noAccModal').modal('show');

			$('#noAccModal').on('hidden.bs.modal', function (e) {
			    location.href = "<?php echo URL;?>";
			});
			
		});
	
	</script>

	<div class="modal fade madal-lg" id="noAccModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				
				<div class="modal-header text-white" id="modalHeader">
					<h5 class="modal-title" id="modalCenterTitle"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body bg-light text-body" id="modalMsg">
					<!-- message -->
				</div>
				
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="btnOkModal" style="width: 100px; cursor: pointer;">OK</button>
				</div>
				
			</div>
		</div>
	</div>