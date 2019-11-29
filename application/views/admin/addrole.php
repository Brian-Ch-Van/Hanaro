<?php 
	$splitFileName = explode('\\', __FILE__);
	require 'application/views/_templates/authvalid.php';
?>
<script type="text/javascript">
	$(document).ready(function () {

	    var roleIdArr = $('#inputRoleId').val().split("_");
	    
		$('#isAdminChk').on('click', function(){
			if($('#isAdminChk').prop('checked') == true) {
				$('#selRegion').val('').attr('disabled', true);
				$('#selBrch').val('').attr('disabled', true);
				$('#selPosition').val('').attr('disabled', true);
				$('input[name=inputAuth]').attr('disabled', true);
				$('#inputRoleId').val('admin');
			} else {
				$('#selRegion').attr('disabled', false);
				$('#selBrch').attr('disabled', false);
				$('#selPosition').attr('disabled', false);
				$('input[name=inputAuth]').attr('disabled', false);
				$('#formRoleInfo')[0].reset();	// form reset
				roleIdArr = [];
			}
		});
		
		$('#selRegion').change(function() {
		    roleIdArr[0] = $(this).val();
		    $('#inputRoleId').val(roleIdArr.join('_'));
		});

		$('#selBrch').change(function() {
		    roleIdArr[1] = $(this).val();
		    $('#inputRoleId').val(roleIdArr.join('_'));
		});		

		$('#selPosition').change(function() {
		    roleIdArr[2] = $(this).val();
		    $('#inputRoleId').val(roleIdArr.join('_'));
		});	

		$('#btnSave').on('click', function (e) {
		    e.preventDefault();

		    if($('#isAdminChk').prop('checked') == false) {
		    	if(isEmpty($('#selRegion').val())) {
		    	    $("#dialog").data('item', '지역').data('bodyText', '을 선택해주세요.').data('id', 'selRegion').dialog("open");
			    	return;
		    	} else if(isEmpty($('#selBrch').val())) {
		    	    $("#dialog").data('item', '매장').data('bodyText', '을 선택해주세요.').data('id', 'selBrch').dialog("open");
			    	return;
		    	} else if(isEmpty($('#selPosition').val())) {
		    	    $("#dialog").data('item', '직급').data('bodyText', '을 선택해주세요.').data('id', 'selPosition').dialog("open");
			    	return;
		    	}
		    }

			var authArr = [];
	    	$('input:checkbox[name="inputAuth"]').each( function (i){
				if($(this).prop('checked') == true) {
					authArr.push($(this).val());
					$('#divAuth').val(authArr.join(','));
				}
		    });
	    	
	    	var formData = $('#formRoleInfo').serialize(true);
	    	formData = formData + "&inputAuthArr=" + authArr + "&rsrcArr=" + uniRsrcIdArr;
	    	console.log("Role input data : " + formData);

			$.ajax({
				url			: '<?php echo URL; ?>/admin/addRoleInfo/',
				type		: 'post', 
				data		: formData, 
				dataType	: 'json',
				success		: function (result) {
		    	    if(result.success == true) {
						$('.modal-title').text('CONFIRM');
						$('#modalHeader').removeClass('bg-danger');
						$('#modalMsg').html(result.data);
						
						$('#cnfModal').modal('show');

						$("#confirmModal").on("click", function() {
						    location.reload();
						});

		    	    } else {
						$('.modal-title').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').html(result.errMsg);
						
						$('#cnfModal').modal('show');
						return;
		    	    }
				},
				error		:function (jqXHR, textStatus, errorThrown) {	
					$('.modal-title').text('ERROR');
					$('#modalHeader').addClass('bg-danger');
					$('#modalMsg').html(jqXHR.responseText);
					
					$('#cnfModal').modal('show');
				} 
			})
		}); // end save
		
		var uniRsrcIdArr = [];
		$('#btnAddRsrc').on('click', function () {
			
			$.ajax({
				url			: '<?php echo URL; ?>/admin/openRsrcList/',
				type		: 'post', 
// 				data		: formData, 
				dataType	: 'json',
				success		: function (result) {
		    	    if(result.success == true) {
		    	        $('#rsrcListModal').css('height', '700');
			    	    
		    	        $('.modal-title').text('Resource List');
		    	        $('#modalList').html(result.data);
						$('#rsrcListModal').modal('show');

						$('#addItems').on('click', function () {
						    var rsrcIdArr = [];
						    
							$('input:checkbox[name="checkRsrc"]').each( function (i){
							    if($(this).prop('checked') == true) {
									var rowData = $(this).val().split('|');
									if("S" == rowData[2]) {
									    rowData[2] = "화면";
									} else if ("M" == rowData[2]) {
									    rowData[2] = "화면";
									}
									
									$('tr[name="trRsrc"]').each(function (){
									    rsrcIdArr.push($(this).find('td:first-child').text());
									});

									if($.inArray(rowData[0], uniRsrcIdArr) == -1) {
									    uniRsrcIdArr.push(rowData[0]);
									    $('.tbodyRsrc').append('<tr class="rsrcTr" name="trRsrc"><td style="display:none;">'+rowData[0]+'</td><td>'+rowData[1]+'</td><td>'+rowData[2]+'</td><td>'+rowData[3]+'</td><td><a class="btn-sm btn-success" style="cursor: pointer;" onclick="delRsrc(this);">Del</a></td></tr>');
									}
							    }
							});
							
							$('input:checkbox[name="checkRsrc"]').prop('checked', false);
						}) // end addItems

		    	    } else {
						$('.modal-title').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').html(result.errMsg);
						
						$('#cnfModal').modal('show');
						return;
		    	    }
				},
				error		:function (jqXHR, textStatus, errorThrown) {	
					$('.modal-title').text('ERROR');
					$('#modalHeader').addClass('bg-danger');
					$('#modalMsg').html(jqXHR.responseText);
					
					$('#cnfModal').modal('show');
				} 
			})
		});
		
	});

	function delRsrc(obj) {
		var tr = $(obj).parent().parent();
		tr.remove();
	}

</script>

	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">Add Role</h2>
			
			<div class="my-3 p-3 rounded shadow-sm" style="background-color: #454d55; color: #fff;">
				<form method="post" id="formRoleInfo">
				
					<div class="custom-control custom-switch mb-3 ml-3">
						<input type="checkbox" class="custom-control-input" id="isAdminChk" name="isAdminChk">
						<label class="custom-control-label" for="isAdminChk">Admin</label>
					</div>
	
					<div class="form-row ml-2 mr-2">
						<div class="form-group col-md-6">
							<label for="inputRoleId">ID *</label>
							<input type="text" class="form-control" id="inputRoleId" name="inputRoleId" placeholder="아이디" value="" readonly>
						</div>	
						
						<div class="form-group col-md-6">
							<label for="inputRoleName">Name</label>
							<input type="text" class="form-control" id="inputRoleName" name="inputRoleName" placeholder="이름" value="" >
						</div>
					</div>			
					
					<div class="form-row ml-2 mr-2">
						<div class="form-group col-md-4">
							<label for="selRegion">Region *</label>
							<select id="selRegion" name="selRegion" class="form-control">
								<option value="" selected>지역</option>
								<?php foreach ($rgnList as $row) { ?>
								<option value="<?= $row['cd_key']?>"><?= $row['cd_value']?></option>
								<?php }?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="selBrch">Branch *</label>
							<select id="selBrch" name="selBrch" class="form-control">
								<option value="" selected>매장</option>
								<option value="all">ALL</option>
								<?php foreach ($brchList as $row) { ?>
								<option value="<?= $row['cd_key']?>"><?= $row['cd_value']?></option>
								<?php }?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="selPosition">Position *</label>
							<select id="selPosition" name="selPosition" class="form-control">
								<option value="" selected>직급</option>
								<?php foreach ($pstnList as $row) { ?>
								<option value="<?= $row['cd_key']?>"><?= $row['cd_value']?></option>
								<?php }?>
							</select>
						</div>
					</div>
								
					<div class="form-group col-md-12">
						<label for="inputAuth">Authority</label>
						<div class="form-row ml-1" id="divAuth" name="divAuth">
							<div class="custom-control custom-checkbox mr-3">
								<input class="custom-control-input" type="checkbox" id="inputAuthV" name="inputAuth" value="V">
								<label class="custom-control-label" for="inputAuthV">View</label>
							</div>
							<div class="custom-control custom-checkbox mr-3">
								<input class="custom-control-input" type="checkbox" id="inputAuthC" name="inputAuth" value="C">
								<label class="custom-control-label" for="inputAuthC">Create</label>
							</div>
							<div class="custom-control custom-checkbox mr-3">
								<input class="custom-control-input" type="checkbox" id="inputAuthU" name="inputAuth" value="U">
								<label class="custom-control-label" for="inputAuthU">Update</label>
							</div>
							<div class="custom-control custom-checkbox mr-3">
								<input class="custom-control-input" type="checkbox" id="inputAuthD" name="inputAuth" value="D">
								<label class="custom-control-label" for="inputAuthD">Delete</label>
							</div>
							<div class="custom-control custom-checkbox mr-3">
								<input class="custom-control-input" type="checkbox" id="inputAuthS" name="inputAuth" value="S">
								<label class="custom-control-label" for="inputAuthS">Save</label>
							</div>
							<div class="custom-control custom-checkbox mr-3">
								<input class="custom-control-input" type="checkbox" id="inputAuthE" name="inputAuth" value="E">
								<label class="custom-control-label" for="inputAuthE">Export</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label for="inputRoleDesc">Description</label>
						<textarea class="form-control" id="inputRoleDesc" name="inputRoleDesc" placeholder="설명" rows="3"></textarea>
					</div>				
					<div class="form-group col-md-12">
						<label for="tableRoleRsrcList">Resource</label><input type="button" class="btn btn-outline-info btn-sm ml-2" id="btnAddRsrc" value="Add">
						<table class="table table-hover table-sm table-dark table-responsive-md" id="tableRoleRsrcList">
							<colgroup>
								<col width="30%" />
								<col width="20%" />
								<col width="30%" />
								<col width="20%" />
							</colgroup>
							<thead class="thead-light">
								<tr>
									<th scope="col">Name</th>
									<th scope="col">Type</th>
									<th scope="col">Desc.</th>
									<th scope="col">Delete</th>
								</tr>
							</thead>
							<tbody class="tbodyRsrc">
								
							</tbody>
						</table>
					</div>
					<div class="form-group col-md-12">
						<label for="">User</label><input type="button" class="btn btn-outline-info btn-sm ml-2" id="btnAddUser" value="Add">
						<table class="table table-hover table-sm table-dark table-responsive-md" id="tableRoleUserList">
							<thead class="thead-light">
								<tr>
									<th scope="col">Name</th>
									<th scope="col">Emp No.</th>
									<th scope="col">Email</th>
									<th scope="col">Company</th>
									<th scope="col">Delete</th>
								</tr>
							</thead>
							<tbody>
<!-- 								<tr> -->
<!-- 									<td scope="row" title=""></td> -->
<!-- 									<td scope="row" title=""></td> -->
<!-- 									<td scope="row" title=""></td> -->
<!-- 									<td scope="row" title=""></td> -->
<!-- 								</tr> -->
							</tbody>
						</table>
					</div>
					
					<div class="form-group col-md">
						<input type="button" class="btn btn-primary mt-2" id="btnSave" value="Save">
					</div>
				</form>
			</div>
			
		</div>
	</main>
	
	<div id="dialog"></div>
	<?php require 'application/views/_templates/util.php';?>
	<?php require 'application/views/_templates/confirmmodal.php'; ?>
	<?php require 'application/views/system/resourcelist.php'; ?>
	
