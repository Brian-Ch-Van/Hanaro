<?php 
	$splitFileName = explode('\\', __FILE__); 
	require 'application/views/_templates/authvalid.php';
?>
  
	<script type="text/javascript">
		$(document).ready(function () {

		    $('#tableRsrcList tr[name=trRsrcList]').click(function (){
				var tr = $(this);
				var td = tr.children();

// 				alert(tr.text() + "|| Id = " + rId);
// 				console.log(tr.html());
				console.log(tr.text());

				var rId = td.eq(0).text();
				var rName = td.eq(1).text();
				var rType = td.eq(2).text();
				var rDispName = td.eq(3).text();
				var rDesc = td.eq(4).text();
				var rUseYn = td.eq(5).text();
				var rDate = td.eq(6).text();
				var rPath = td.eq(7).text();
				var rParentId = td.eq(8).text();
				var rOrder = td.eq(9).text();
				
				$('#inputRsrcId').val(rId);
				$('#inputRsrcName').val(rName);
				if (rType == '화면') {
				    $('#inputRsrcType').val('S').prop('selected', true);
				} else if (rType == '메뉴') {
					$('#inputRsrcType').val('M').prop('selected', true);
				} else {
					$('#inputRsrcType option:eq(0)').prop('selected', true);
				}
				$('#inputRsrcDispName').val(rDispName);
				$('#inputRsrcDesc').val(rDesc);
				$('#inputRsrcPath').val(rPath);
				if(rUseYn == 'Y') {
					$('#inputUseYn').val('Y').prop('selected', true);
				} else if (rUseYn == 'N') {
				    $('#inputUseYn').val('N').prop('selected', true);
				} else {
					$('#inputUseYn option:eq(0)').prop('selected', true);
				}
				$('#inputParentRsrcId').val(rParentId);
				$('#inputSortOrder').val(rOrder);

// 				$('html').scrollTop(0);
// 		    	var offset = $('#inputRsrcId').offset();
		    	$('html').animate({scrollTop : 0}, 200);				
			});

			$('#btnReset').on('click', function () {
				$('#inputRsrcId').val('');
				$('#inputRsrcName').val('');
				$('#inputRsrcType option:eq(0)').prop('selected', true);
				$('#inputRsrcDispName').val('');
				$('#inputRsrcDesc').val('');
				$('#inputRsrcPath').val('');
				$('#inputParentRsrcId').val('');
				$('#inputSortOrder').val('');
			});

			$('#btnSave').on('click', function (e) {
			    e.preventDefault();
				
		    	var formData = $('#formRsrcInfo').serialize(true);
		    	// form 입력 data 확인
		    	console.log("Resource Info input data : " + formData);

		    	if(isEmpty($('#inputRsrcName').val())) {
		    	    $("#dialog").data('item', 'Name').data('bodyText', '을 입력해주세요.').data('id', 'inputRsrcName').dialog("open");
			    	return;
		    	} else if(isEmpty($('#inputRsrcType').val())) {
		    	    $("#dialog").data('item', 'Type').data('bodyText', '을 선택해주세요.').data('id', 'inputRsrcType').dialog("open");
			    	return;
		    	} else if(isEmpty($('#inputRsrcDispName').val())) {
		    	    $("#dialog").data('item', 'Display Name').data('bodyText', '을 입력해주세요.').data('id', 'inputRsrcDispName').dialog("open");
			    	return;
		    	} 

		    	$.ajax({
			    	url			: '<?php echo URL;?>/system/saveRsrcInfo/', 
			    	type		: 'post',
			    	data		: formData, 
			    	dataType	: 'json',
			    	success		: function (result) {
			    	    if(result.success == true) {
			    	        //$('#modalCenterTitle').text('CONFIRM');	// id로 set하는게 안 됨...
							$('.modal-title').text('CONFIRM');			// class명으로 찾아서 set
							$('#modalHeader').removeClass('bg-danger');
							$('#modalMsg').text(result.data);
							
							$('#cnfModal').modal('show');
							
							// 저장 후 사용자 목록 화면으로 이동
							$("#confirmModal").on("click", function() {
							    location.href = "<?php echo URL; ?>/system/";
							});
							
			    	    } else {
							$('.modal-title').text('ERROR');
							$('#modalHeader').addClass('bg-danger');
							$('#modalMsg').text(result.errMsg);
							
							$('#cnfModal').modal('show');
							return;
			    	    }
			    	},
			    	error : function (jqXHR, textStatus, errorThrown) {	
					    //alert("Error Occur : \n code = "+ jqXHR.status + "\n status = " + jqXHR.statusText + "\n message = \n" + jqXHR.responseText);
						$('.modal-title').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').html(jqXHR.responseText);
						
						$('#cnfModal').modal('show');
					}
			    }); // end ajax
			});	// end save

			// delete resource
			$('#btnDelete').click(function (){
				var $rsrcId = $('#inputRsrcId').val();
				if(isEmpty($rsrcId)) {
					alert('No resource selected.');
					return;
				}

				if(confirm('Are you sure to delete Resource id ' +$rsrcId + '?')) {
				    $.ajax({
				    	url			: '<?php echo URL;?>/system/delRsrcInfo/'+$rsrcId, 
				    	type		: 'post',
//	 			    	data		: formData, 
				    	dataType	: 'json',
				    	success		: function (result) {
				    	    if(result.success == true) {
								$('.modal-title').text('CONFIRM');			// class명으로 찾아서 set
								$('#modalHeader').removeClass('bg-danger');
								$('#modalMsg').text(result.data);

								$('#cnfModal').modal({
									backdrop: 'static', 
									keyboard: false		
								});
//	 							$('#cnfModal').modal('show');
								
								$("#confirmModal").on("click", function() {
								    location.href = "<?php echo URL; ?>/system/";
								});
								
				    	    } else {
								$('.modal-title').text('ERROR');
								$('#modalHeader').addClass('bg-danger');
								$('#modalMsg').text(result.errMsg);
								
								$('#cnfModal').modal('show');
								return;
				    	    }
				    	},
				    	error : function (jqXHR, textStatus, errorThrown) {	
						    //alert("Error Occur : \n code = "+ jqXHR.status + "\n status = " + jqXHR.statusText + "\n message = \n" + jqXHR.responseText);
							$('.modal-title').text('ERROR');
							$('#modalHeader').addClass('bg-danger');
							$('#modalMsg').html(jqXHR.responseText);
							
							$('#cnfModal').modal('show');
						}
				    }); // end ajax
				} 
			});	// end delete

			// dialog
		    $( "#dialog" ).dialog({
		        autoOpen : false,
		        title : 'Warning',
		        width : "500",  
		        height : "200",  
		        modal : true,   
		        resizeable : false,
		        open: function() {
			        var item = $(this).data('item');
		            var bodyText = $(this).data('bodyText');
		            $(this).html(item + bodyText);
		          },
		        buttons : {            // dialog 하단 버튼들
		            "confirm" : function() {
		                $(this).dialog("close");
		                $('#' + $(this).data('id')).focus();
		            }
		        },
		        show: {
		            effect: "fade",
		            duration: 100
		        },
		        hide: { 
		            effect: "fade",
		            duration: 100
		        }
		    });			

		});

		function moveTop() {
	    	$('html').animate({scrollTop : 0}, 200);
		};

	</script>
	
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">Resource Manage</h2>
			
			<!-- Resource Info -->
			<div class="my-3 p-3 rounded shadow-sm" style="background-color: #dfebf7;">
				<div class="media mb-3">
					<img src="<?php echo IMG_URL; ?>/placeholder_lightblue.png" style="width: 20px; border-radius: 30%" class="align-self-center mr-2" alt="placeholder" >
					<div class="media-body">
						<p class="mb-0" style="font-weight: bold; font-size: 1.2rem;">Resource Info</p>
					</div>
				</div>
				
				<form method="post" id="formRsrcInfo">
					<div class="form-row">
						<div class="form-group col-md-2">
							<label for="inputRsrcId">ID *</label>
							<input type="text" class="form-control" id="inputRsrcId" name="inputRsrcId" placeholder="아이디" value="" readonly>
						</div>
						<div class="form-group col-md-4">
							<label for="inputRsrcName">Name *</label>
							<input type="text" class="form-control" id="inputRsrcName" name="inputRsrcName" placeholder="이름" value="">
						</div>
						<div class="form-group col-md-2">
							<label for="inputRsrcType">Type *</label>
							<select id="inputRsrcType" name="inputRsrcType" class="form-control">
								<option value="" selected>Choose</option>
								<option value="S">화면</option>
								<option value="M">메뉴</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="inputRsrcDispName">Display Name *</label>
							<input type="text" class="form-control" id="inputRsrcDispName" name="inputRsrcDispName" placeholder="표시 이름" value="">
						</div>						
						
					</div>
					
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="inputRsrcDesc">Description</label>
							<input type="text" class="form-control" id="inputRsrcDesc" name="inputRsrcDesc" placeholder="설명" value="">
						</div>
						<div class="form-group col-md-5">
							<label for="inputRsrcPath">Path</label>
							<input type="text" class="form-control" id="inputRsrcPath" name="inputRsrcPath" placeholder="경로" value="" >
						</div>
						<div class="form-group col-md-2">
							<label for="inputParentRsrcId">Parent Id</label>
							<input type="text" class="form-control" id="inputParentRsrcId" name="inputParentRsrcId" placeholder="상위 리소스" value="">
						</div>
						<div class="form-group col-md-1">
							<label for="inputUseYn">Use</label>
							<select id="inputUseYn" name="inputUseYn" class="form-control">
								<option value="" selected>Y/N</option>
								<option value="Y">Y</option>
								<option value="N">N</option>
							</select>
						</div>							
						<div class="form-group col-md-1">
							<label for="inputSortOrder">Sort Order</label>
							<input type="text" class="form-control" id="inputSortOrder" name="inputSortOrder" placeholder="순서" value="">
						</div>
					</div>
					
					<div class="d-flex justify-content-end">
						<input type="button" class="btn btn-info btn-sm" id="btnSave" style="width: 100px;" value="Save">
						<input type="button" class="btn btn-outline-danger btn-sm ml-1" value="Delete" id="btnDelete">
						<input type="button" class="btn btn-primary btn-sm ml-1" value="Reset" id="btnReset">
					</div>
				</form>
			</div>
		
			<!-- Resource List -->
			<div class="my-3 p-3 bg-white rounded shadow-sm">
				<div class="media mb-3">
					<img src="<?php echo IMG_URL; ?>/placeholder_lightblue.png" style="width: 20px; border-radius: 30%" class="align-self-center mr-2" alt="" >
					<div class="media-body">
						<p class="mb-0" style="font-weight: bold; font-size: 1.2rem;">Resource List</p>
					</div>
				</div>
				
				<table class="table table-hover table-sm table-responsive-md" id="tableRsrcList">
					<thead class="thead-light">
						<tr>
							<th scope="col" onclick="sortTable(0, 'tableRsrcList')">ID</th>
							<th scope="col" onclick="sortTable(1, 'tableRsrcList')">Name</th>
							<th scope="col" onclick="sortTable(2, 'tableRsrcList')">Type</th>
							<th scope="col" onclick="sortTable(3, 'tableRsrcList')">Display Name</th>
							<th scope="col" onclick="sortTable(4, 'tableRsrcList')">Desc.</th>
							<th scope="col" onclick="sortTable(5, 'tableRsrcList')">Use</th>
							<th scope="col" onclick="sortTable(6, 'tableRsrcList')">Register Date</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($rsrcList as $row) {?>
						<tr name="trRsrcList">
							<td scope="row" title=""><?= $row['rsrc_id']?></td>
							<td title=""><?= htmlspecialchars($row['rsrc_name'], ENT_QUOTES, 'UTF-8'); ?></td>
							<td title=""><?php if($row['rsrc_type'] == 'S'){ echo '화면'; } else if($row['rsrc_type'] == 'M') { echo '메뉴'; } ?></td>
							<td title=""><?= htmlspecialchars($row['rsrc_disp_name'], ENT_QUOTES, 'UTF-8'); ?></td>
							<td title=""><?= htmlspecialchars($row['rsrc_desc'], ENT_QUOTES, 'UTF-8'); ?></td>
							<td title=""><?= htmlspecialchars($row['use_yn'], ENT_QUOTES, 'UTF-8'); ?></td>
							<td title=""><?= date("Y-m-d", strtotime($row['rst_date']))?></td>
							<td style="display:none;" title=""><?= $row['rsrc_path']; ?></td>
							<td style="display:none;" title=""><?= $row['parent_rsrc_id']; ?></td>
							<td style="display:none;" title=""><?= $row['sort_order']; ?></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
							
				<small class="d-block text-right mt-3">
					<a href="javascript:void(0);" onclick="moveTop();">Top</a>
				</small>
			</div>

		</div>
	</main>
	
	<div id="dialog"></div>		
	<?php require 'application/views/_templates/confirmmodal.php'; ?>