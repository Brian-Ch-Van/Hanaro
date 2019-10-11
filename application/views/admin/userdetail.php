
	<!-- for calender -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function () {

		    // 조회된 사용자 정보 확인
			<?php foreach ($profileInfo as $key => $value) { ?>
			console.log('key: '+ '<?php echo $key?>' + ' value :  ' +'<?php echo $value?>');
			<?php }	?>
			
		    // 사용자 정보 set
		    if ( '<?php echo $profileInfo['actYn'];?>' == 'Y') {
		        $('#inputActYes').prop('checked', true);
	        } else {
	            $('#inputActNo').prop('checked', true);
	        }
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

		    // 달력 default set
            $.datepicker.setDefaults({
                dateFormat: 'yymmdd' 		// input format - yyyyMMdd
                ,showOtherMonths: true 		
                ,showMonthAfterYear:true 	
                ,changeYear: true 			
                ,changeMonth: true 			               
                //,showOn: "both" 			// 달력 아이콘 표시, button:아이콘 표시하고,눌러야만 달력 표시, both:아이콘 표시하고, 누르거나 input을 클릭하면 달력 표시  
                //,buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif" // 달력 버튼 이미지 경로
                //,buttonImageOnly: true 	
                //,buttonText: "날짜선택" 		             
                ,yearSuffix: "년" 		
                ,monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'] 
                ,monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] 
                ,dayNamesMin: ['일','월','화','수','목','금','토'] 
                ,dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'] 
                //,minDate: "-20Y" //최소 선택일자(-1D:하루전, -1M:한달전, -1Y:일년전)
                //,maxDate: "+1Y" //최대 선택일자(+1D:하루후, -1M:한달후, -1Y:일년후)
            	//,yearRange: "-50:+1"		// 년도 range
            });	
            
            // 날짜 input을 datepicker로 선언
            $("#inputResignYmd").datepicker({yearRange: "-30:+1"});
            $("#inputBirth").datepicker({yearRange: "-90:+1"});
		    
		    // 목록가기 버튼
			$("#btnCancel").on('click', function() {
				location.href="<?php echo URL;?>/admin";
			});

			// 전화번호 format - 공통 format check 함수: phoneNoFormat
			$('#inputPhoneNo').on('keyup', phoneNoFormat);

			// 휴대전화 format - 공통 format check 함수
			$('#inputCellNo').on('keyup', phoneNoFormat);	

			// postal uppercase, trim
			$('#inputPostal').on('keyup', function () {
				$(this).attr('maxlength', 6);
				var postal = $(this).val();
				$(this).val(replaceUpper(postal));
			});
		    
		    // 저장
		    //var actYn = $('input[name="inputActYn"]:checked').val();
		    $('#btnSignUp').on('click', function (e) {
			    e.preventDefault();
			    e.stopPropagation();

		    	var formData = $('#formProfile').serialize();
		    	// form 입력 data 확인
		    	console.log("Form input data : " + formData);

		    	$.ajax({
			    	url			: '<?php echo URL;?>/admin/modifyUserInfo/', 
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
							    location.href = "<?php echo URL; ?>/admin/";
							});
							
			    	    } else {
							$('.modal-title').text('ERROR');
							$('#modalHeader').addClass('bg-danger');
							$('#modalMsg').text(result.errMsg);
							
							$('#cnfModal').modal('show');
							return;
			    	    }
			    	}
			    }); // end ajax
		    	
			}); // end 저장
			
		});
	</script>

	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">사용자 정보</h2>
			
			<!-- <form method="post" id="formProfile" style="background-color:#343a40; padding:15px 15px 15px 15px; color: white;"> -->
			<form method="post" id="formProfile" style="background-color: #f0eded; padding:15px 15px 15px 15px;" >
				
				<div class="form-group row">
					<div class="col-sm-2">
						Activation
					</div>
					<div class="form-check">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="inputActYes" name="inputActYn" class="custom-control-input" value="Y">
							<label class="custom-control-label" for="inputActYes">승인</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="inputActNo" name="inputActYn" class="custom-control-input" value="N">
							<label class="custom-control-label" for="inputActNo">미승인</label>
						</div>
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-6" id="divKname">
						<label for="inputKname">Korean Name</label>
						<input type="text" class="form-control" id="inputKname" name="inputKname" placeholder="한글 이름" disabled>
						<input type="text" class="form-control" id="inputUserId" name="inputUserId" hidden>
					</div>
					<div class="form-group col-md-6" id="divEmail">
						<label for="inputEmail">Email</label>
						<input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="이메일" disabled>
					</div>
				</div>
				 
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputFname">First Name</label>
						<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="영문 이름" disabled>
					</div>
					<div class="form-group col-md-6">
						<label for="inputLname">Last Name</label>
						<input type="text" class="form-control" id="inputLname" name="inputLname" placeholder="영문 성" disabled>
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputCompany">Company</label>
						<input type="text" class="form-control" id="inputCompany" name="inputCompany" placeholder="회사" disabled>
					</div>
					<div class="form-group col-md-6">
						<label for="inputEmpNo">Employee No.</label>
						<input type="text" class="form-control" id="inputEmpNo" name="inputEmpNo" placeholder="직원 번호" disabled>
					</div>
				</div>	
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputPosition">Position</label>
						<input type="text" class="form-control" id="inputPosition" name="inputPosition" placeholder="직급">
					</div>
					<div class="form-group col-md-6">
						<label for="inputResignYmd">Resign</label>
						<input type="text" class="form-control datepicker" id="inputResignYmd" name="inputResignYmd" placeholder="YYYYMMDD" autocomplete="off">
					</div>
				</div>				
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputPhoneNo">Phone No.</label>
						<input type="text" class="form-control" id="inputPhoneNo" name="inputPhoneNo" placeholder="전화번호">
					</div>
					<div class="form-group col-md-6">
						<label for="inputCellNo">Cell No.</label>
						<input type="text" class="form-control" id="inputCellNo" name="inputCellNo" placeholder="휴대전화">
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputGender">Gender</label>
						<select id="inputGender" name="inputGender" class="form-control">
							<option value="" selected>Choose</option>
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
					</div>
					<div class="form-group col-md-6" id="divBirth">
						<label for="inputBirth">Birth</label>
						<input type="text" class="form-control" id="inputBirth" name="inputBirth" maxlength="8" placeholder="YYYYMMDD" autocomplete="off">
					</div>
				</div>				
				
				<div class="form-group">
					<label for="inputAddStreet">Address</label>
					<input type="text" class="form-control" id="inputAddStreet" name="inputAddStreet" placeholder="Unit, Street">
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputAddCity">City</label>
						<input type="text" class="form-control" id="inputAddCity" name="inputAddCity" placeholder="City">
					</div>
					<div class="form-group col-md-4">
						<label for="inputProvince">Province</label>
						<select id="inputProvince" name="inputProvince" class="form-control">
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
					<div class="form-group col-md-2">
						<label for="inputPostal">Postal</label>
						<input type="text" class="form-control" id="inputPostal" name="inputPostal" placeholder="A1B2C3">
					</div>
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary" id="btnSignUp" style="width: 100px;">저장</button>
					<input type="button" class="btn btn-outline-info" value="목록" id="btnCancel">
				</div>
			</form>
			
		</div>
	</main>

	<!-- confirm modal -->
	<?php require 'application/views/_templates/confirmmodal.php'; ?>
