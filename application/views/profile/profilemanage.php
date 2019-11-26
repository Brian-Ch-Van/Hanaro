
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function () {

		    // 조회된 사용자 정보 확인
			<?php foreach ($profileInfo as $key => $value) { ?>
			console.log('key: '+ '<?php echo $key?>' + ' value :  ' +'<?php echo $value?>');
			<?php }	?>
			
		    // profile info set
		    $('#inputUserId').val('<?php echo $profileInfo['userId'];?>');	// hidden
		    $('#inputKname').val('<?php echo $profileInfo['kName'];?>');
		    $('#inputEmail').val('<?php echo $profileInfo['email'];?>');
		    $('#inputFname').val('<?php echo $profileInfo['fName'];?>');
		    $('#inputLname').val('<?php echo $profileInfo['lName'];?>');
		    $('#inputCompany').val('<?php echo $profileInfo['company'];?>');
		    $('#inputEmpNo').val('<?php echo $profileInfo['empNo'];?>');
		    $('#inputPosition').val('<?php echo $profileInfo['position'];?>');
		    $('#inputResignYmd').val('<?php echo $profileInfo['resignYmd'];?>');
		    $('#inputPhoneNo').val('<?php echo $profileInfo['phoneNo'];?>');
		    $('#inputCellNo').val('<?php echo $profileInfo['cellNo'];?>');
	        $('#inputGender').val('<?php echo $profileInfo['gender'];?>').prop('selected', true);
		    $('#inputBirth').val('<?php echo $profileInfo['bthYmd'];?>');
		    $('#inputAddStreet').val('<?php echo $profileInfo['addStreet'];?>');
		    $('#inputAddCity').val('<?php echo $profileInfo['addCity'];?>');
		    $('#inputProvince').val('<?php echo $profileInfo['addProvince'];?>').prop('selected', true);
		    $('#inputPostal').val('<?php echo $profileInfo['postal'];?>');

		    var inputEl = $('input');
			for(var i = 0; i < inputEl.length; i++) {
				if(!isEmpty($(inputEl[i]).val())) {
				    $(inputEl[i]).parent().addClass("focus");
				}
			}
			
		 	$(".input").focus(function() {
		 		$(this).parent().addClass("focus");
		 	})
		 	
		 	$('form').attr('autocomplete','off');

			$('#inputKname').blur(function (){
		    	if(isEmpty($('#inputKname').val())) {
			    	$('#knameChkRequired').show();
		    	} else {
		    	    $('#knameChkRequired').hide();
		    	}
			});
		 	
            $("#inputResignYmd").datepicker({yearRange: "-10:+1"});
            $("#inputBirth").datepicker({yearRange: "-90:+1"});
		    
			$('#inputPhoneNo').on('keyup', phoneNoFormat);
			$('#inputCellNo').on('keyup', phoneNoFormat);	

			$('#inputPostal').on('keyup', function () {
				$(this).attr('maxlength', 6);
				var postal = $(this).val();
				$(this).val(replaceUpper(postal));
			});

		    // save
		    $('#btnSignUp').on('click', function (e) {
			    e.preventDefault();
			    e.stopPropagation();

		    	var formData = $('#formProfile').serialize(true);
		    	console.log("Form input data : " + formData);

		    	if(isEmpty($('#inputKname').val())) {
			    	var offset = $('#inputKname').offset();
			    	$('html').animate({scrollTop : offset.top-100}, 300);
			    	$('#inputKname').focus();

			    	$('#knameChkRequired').show();
			    	return;
		    	}

		    	$.ajax({
			    	url			: '<?php echo URL;?>/profile/modifyProfInfo/', 
			    	type		: 'post',
			    	data		: formData, 
			    	dataType	: 'json',
			    	success		: function (result) {
			    	    if(result.success == true) {
			    	        //$('#modalCenterTitle').text('CONFIRM');
							$('.modal-title').text('CONFIRM');	
							$('#modalHeader').removeClass('bg-danger');
							$('#modalMsg').text(result.data);
							
							$('#cnfModal').modal('show');
							
							$("#confirmModal").on("click", function() {
							    location.reload();
							    $('html').scrollTop(0);
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
						$('.modal-title').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').html(jqXHR.responseText);
						
						$('#cnfModal').modal('show');
					}					
			    }); // end ajax
			}); // end 저장

			$("#btnCancel").on('click', function() {
				history.go(-1);
			});

		});
	</script>

	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">Profile</h2>
			
			<form method="post" id="formProfile" class="pt-4 pl-3 pr-3" >
				<div class="row">
					<div class="col-sm-12">
						<div class="inputBox" title="수정할 수 없는 항목입니다">
							<div class="inputText">Email *</div>
							<input type="text" id="inputEmail" name="inputEmail" class="input disabled" >
						</div>
					</div>
				</div>
							
				<div class="row">
					<div class="col-sm-6">
						<div class="inputBox">
							<div class="inputText">Korean Name *</div>
							<input type="text" id="inputKname" name="inputKname" class="input">
							<small id="knameChkRequired" class="text-danger" style="display:none">이 입력란은 필수입니다!</small>
							<input type="hidden" class="input" id="inputUserId" name="inputUserId">
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="inputBox" data-toggle="tooltip" title="수정할 수 없는 항목입니다">
							<div class="inputText">Employee No.</div>
							<input type="text" id="inputEmpNo" name="inputEmpNo" class="input disabled">
						</div>
					</div>					
				</div>
								
				<div class="row">
					<div class="col-sm-6">
						<div class="inputBox ">
							<div class="inputText">First Name</div>
							<input type="text" id="inputFname" name="inputFname" class="input" >
						</div>
					</div>

					<div class="col-sm-6">
						<div class="inputBox">
							<div class="inputText">Last Name</div>
							<input type="text" id="inputLname" name="inputLname" class="input">
						</div>
					</div>
				</div>				
				
				<div class="row">
					<div class="col-sm-6">
						<div class="inputBox">
							<div class="inputText">Company</div>
							<input type="text" id="inputCompany" name="inputCompany" class="input">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="inputBox ">
							<div class="inputText">Position</div>
							<input type="text" id="inputPosition" name="inputPosition" class="input">
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-6">
						<div class="inputBox ">
							<div class="inputText">Phone No.</div>
							<input type="text" id="inputPhoneNo" name="inputPhoneNo" class="input">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="inputBox">
							<div class="inputText">Cell No.</div>
							<input type="text" id="inputCellNo" name="inputCellNo" class="input" >
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-6">
						<div class="float-label-control">
							<div class="inputText">Gender</div>
							<select id="inputGender" name="inputGender" >
								<option value="" selected >Choose</option>
								<option value="1">Male</option>
								<option value="2">Female</option>
							</select>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="inputBox">
							<div class="inputText">Brith</div>
							<input type="text" id="inputBirth" name="inputBirth" class="input">
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="inputBox">
							<div class="inputText">Address</div>
							<input type="text" id="inputAddStreet" name="inputAddStreet" class="input" >
						</div>
					</div>
				</div>				
				
				<div class="row">
					<div class="col-sm-6">
						<div class="inputBox ">
							<div class="inputText">City</div>
							<input type="text" id="inputAddCity" name="inputAddCity" class="input">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="float-label-control">
							<div class="inputText">Province</div>
							<select id="inputProvince" name="inputProvince" >
								<option value="" selected>Choose</option>
								<option value="BC">British Columbia</option>	<!-- 브리티시 컬럼비아  -->
								<option value="AM">Alberta</option>				<!-- 앨버타 -->
								<option value="SK">Saskatchewan</option>		<!-- 서스캐처원 -->
								<option value="MB">Manitoba</option>			<!-- 매니토바 -->
								<option value="ON">Ontario</option>				<!-- 온타리오 -->
								<option value="QC">Quebec</option>				<!-- 퀘백 -->
								<option value="NB">New Brunswick</option>		<!-- 뉴브런즈윅 -->
								<option value="NS">Nova Scotia</option>			<!-- 노바스코샤 -->
								<option value="PE">Prince Edward Island</option><!-- 프린스 에드워드 아일랜드 -->
								<option value="NL">Newfoundland and Labrador</option><!-- 뉴펀들랜드 래브라도 -->
								<option value="NU">Nunavut</option>				<!-- 누나부트 -->
								<option value="NT">Northwest</option>			<!-- 노스웨스트 -->
								<option value="YT">Yukon</option>				<!-- 유콘 -->
							</select>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="inputBox ">
							<div class="inputText">Postal</div>
							<input type="text" id="inputPostal" name="inputPostal" class="input">
						</div>
					</div>					
				</div>				
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary" id="btnSignUp" style="width: 100px;">저장</button>
					<input type="button" class="btn btn-outline-info" value="취소" id="btnCancel">
				</div>
			</form>
			
		</div>
	</main>

	<?php require 'application/views/_templates/util.php';?>
	<?php require 'application/views/_templates/confirmmodal.php'; ?>
