
<!-- 
 * Common Confirm Modal
 * used : 사용자 등록, 비밀번호 변경, 사용자 정보 수정, Profile 수정  <add>..

 -->
	
	<div class="modal fade" id="cnfModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				
				<div class="modal-header bg-success text-white" id="modalHeader">
					<h5 class="modal-title" id="modalCenterTitle"><!-- Confirm/Error --></h5>
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
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="confirmModal">OK</button>
				</div>
				
			</div>
		</div>
	</div>