<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hana Solutions - Sign Up</title>
        
        <link href="<?php echo CSS_URL; ?>/bootstrap.min.css" rel="stylesheet" >
        <link href="<?php echo CSS_URL; ?>/signup.css" rel="stylesheet" >
        <script src="<?php echo JS_URL; ?>/common.js"></script>
        
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
		<!-- for calender -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>		

		<!-- jQuery loading 후 올라가야 modal에서 error 안 남 -->
		<script src="<?php echo JS_URL; ?>/bootstrap.bundle.min.js"></script>
		
		<!-- favicon -->
        <link rel="shortcut icon" href="<?php echo ICON_URL;?>/h_favicon.png" />		
		
		<style>
			.ui-datepicker-calendar tr { color: #000000; }	
		</style>
		
		<script type="text/javascript">
			$(document).ready(function () {

				// 직원 여부 선택
				$('#inputEmpYn').on('click', function (){
					if($('#divEmpNo').css('display') == 'none') {
						$('#divEmpNo').fadeIn();		// show()
					} else {
					    $('#divEmpNo').fadeOut('fast');	// hide()
					    $('#formSignUp')[0].reset();	// form reset
					    $('#inputEmpNo').prop('readonly', false);
					}
				});

				// form 내의 input 태그에서 엔터 시 button submit 방지
				// botton을 div로 바꿔도 되지만..
				$('input').keydown( function() {
					if (event.keyCode === 13) {
						event.preventDefault();
					};
				});

				var isValidEmp = false;		// 유효 직원 여부
				
				// 직원 확인
				$('#btnEmpCnf').on('click', function (e) {
				    e.preventDefault();		// 다른 이벤트 정지, 자동 form submit 방지

					var empNo = $.trim($('#inputEmpNo').val());

					// null/빈값 체크 - common js에 공통함수 적용 
					if(isEmpty(empNo)) {
					    $("#info").text('직원번호를 입력하세요.').css('color', 'red');
					} else {
					    $("#info").text('');
					    $('#inputEmpNo').val(empNo);

					    $.ajax({
							url		: '<?php echo URL;?>/login/getEmpInfo/',
							type	: 'post',
							dataType: 'json',
							data	: {
										empNoData : empNo
							},
							success	: function (result) {
							    if(result.success == true) {
							     	// object 값 확인
							        //alert(JSON.stringify(result));	// Object 전체
							        //alert(result.empInfo['empNo']);	// value of key
							        
							        //return 된 object 값 확인
							        for (var key in result.empInfo) {
								        console.log("Attribute : " + key + ", value : " + result.empInfo[key] );
							        }

									isValidEmp = true;
									$('#inputEmpNo').prop('readonly', true);	// 직원번호 수정 방지
							        
							        $('#inputEmpNo').val(result.empInfo['empNo']);
									$('#inputKname').val(result.empInfo['kName']);
									$('#inputFname').val(result.empInfo['fName']);
									$('#inputLname').val(result.empInfo['lName']);
									
									$('#inputPhoneNo').val(result.empInfo['telNo']);
									$('#inputPhoneNo').trigger('keyup');	// for PhoneNo format
									$('#inputCellNo').val(result.empInfo['cellNo']);
									$('#inputCellNo').trigger('keyup');	// for PhoneNo format
									
							        if ( result.empInfo['gender'] == '남') {
								        $('#inputGender').val('1').prop('selected', true);
							        } else {
							            $('#inputGender').val('2').prop('selected', true);
							        }
							        $('#inputBirth').val(result.empInfo['birth']);

							    } else {
// 								    alert(result.errMsg);
									$('#modalCenterTitle').text('ERROR');
									$('#modalHeader').addClass('bg-danger');
									$('#modalMsg').text(result.errMsg);
									
// 									$('#cnfModal').modal({
// 										backdrop: 'static', // modal 창 외부 클릭 방지
// 										keyboard: false		// esc로 창 닫힘 방지
// 									});
									$('#cnfModal').modal('show');

									return;
								}
							}
							/* 에러 공통 처리 
							error : function (jqXHR, textStatus, errorThrown) {	// 옵션은 3가지이지만 jqXHR에서 에러 내용 확인 가능
							    alert("Error Occur : \n code = "+ jqXHR.status + "\n status = " + jqXHR.statusText + "\n message = \n" + jqXHR.responseText);
							    
							}
							*/
						}); // end ajax					    
					}
					
				});	// end 직원 확인

				var pw = "";
				var cnfPw = "";
				var isPwOk = false;

				// email Check
				$('#inputEmail').blur(function (){
			    	if(!isValidEmail($(this).val())) {
			    	    $('#emailInline').addClass('text-danger').text('이메일 주소가 올바르지 않습니다!');
			    	} else {
				        $('#emailInline').text('');
			    	}
				});

				// email confirm check
				$('#inputCnfEmail').blur(function (){
			    	if(!isValidEmail($(this).val())) {
			    	    $('#emailCnfInline').addClass('text-danger').text('이메일 주소가 올바르지 않습니다!');
			    	} else {
				        $('#emailCnfInline').text('');
			    	}
				});				
				
				// 비밀번호 check
				$('#inputPw').on('keyup', function() {
				    pw = $(this).val();

				    // common js
				    if(validPassword(pw)) {
						$('#passwordHelpInline').removeClass('text-muted').addClass('text-success');
						$('#passwordHelpInline').text('Success!');
						$('#divPw').addClass('was-validated');

						isPwOk = true;
						
				    } else {
				        $('#passwordHelpInline').addClass('text-muted').text('6-13 characters long including case sensitive letters and numbers.');
				        $('#divPw').removeClass('was-validated');
					}

					$('#inputCnfPw').trigger('keyup');
				});

				// 비밀번호 확인
				$('#inputCnfPw').on('keyup', function() {
					cnfPw  = $(this).val();
					
					// New Pw 입력하고 Confirm PW도 입력 후에 New Pw와 Confirm Pw를 다 삭제할 경우에도 Match되지 않음으로 하기 위해 length 체크
					if(cnfPw.length > 0 && cnfPw === pw) {
						$('#passwordCnfInline').addClass('text-success').text('Password Matched!');
						$('#divCnfPw').addClass('was-validated');

				    } else {
				        $('#passwordCnfInline').text('');
				        $('#divCnfPw').removeClass('was-validated');
					}
				});

				// 전화번호 format
				$('#inputPhoneNo').on('keyup', phoneNoFormat);
				$('#inputCellNo').on('keyup', phoneNoFormat);	

				// postal uppercase, trim
				$('#inputPostal').on('keyup', function () {
					$(this).attr('maxlength', 6);
					var postal = $(this).val();
					$(this).val(replaceUpper(postal));
				});

			    // 달력 default set
	            $.datepicker.setDefaults({
	                dateFormat: 'yymmdd' 		// input format - yyyyMMdd
	                ,showOtherMonths: true 
	                ,showMonthAfterYear:true	
	                ,changeYear: true
	                ,changeMonth: true
	                //,showOn: "both" 			// 달력 아이콘 표시, button/both  
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
	            
	            // 생년월일 달력 적용
	            $("#inputBirth").datepicker({yearRange: "-90:+1"});
	            						
				/* --------------------------
				 * sign up 저장
				 * --------------------------
				*/ 
				$('#btnSignUp').on('click', function (e) {
				    e.preventDefault();		// 다른 이벤트 정지, 자동 form submit 방지
				    e.stopPropagation();	// 이벤트 상위로 전파 금지
				    
				    /* 
				    * ------------------------------------------
				    * 필수 항목, format check start
				    * ------------------------------------------
				    */
					// 직원번호
					var empYn = $('#inputEmpYn').prop('checked');	// 직원 선택 여부
					if(empYn && !isValidEmp) {
						$('#modalCenterTitle').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').text('직원번호를 확인해주세요.');
						
						$('#cnfModal').modal('show');
				    	return;
					}
				    
					// korean name, password, password confirm
					var arrVal = [
			    		{name:'knameChkRequired', value:$('#inputKname').val()},
			    		{name:'pwChkRequired', value:$('#inputPw').val()},
			    		{name:'pwCnfChkRequired', value:$('#inputCnfPw').val()}
					];

					for(var i in arrVal) {
						if(isEmpty(arrVal[i].value)) {
						    $('#'+arrVal[i].name).show();
						    return;
						} else {
						    $('#'+arrVal[i].name).hide();
						}
					}

			    	// email vefrity
					if($('#inputEmail').val() != $('#inputCnfEmail').val()) {
						$('#modalCenterTitle').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').text('이메일 주소가 동일하지 않습니다.');
						
						$('#cnfModal').modal('show');
				    	return;
					} 

			    	// password check
			    	if(!isPwOk) {
						$('#modalCenterTitle').text('ERROR');
						$('#modalHeader').addClass('bg-danger');
						$('#modalMsg').text('비밀번호는 6-13자리의 문자와 숫자로 구성해야 합니다.');
						
						$('#cnfModal').modal('show');
				    	return;
			    	}
				    /* 
				    * ------------------------------------------
				    * 필수 항목, format check end
				    * ------------------------------------------
				    */			    	

			    	var formData = $('#formSignUp').serialize();	//form 전체 태그 string serialize, input 태그 attribute에 name 속성
			    	// form 입력 data 확인
			    	console.log("Form input data => " + formData);

// 			    	var jsonStr = JSON.stringify(formData);		// JSON object -> string
// 			    	var jsonObj = JSON.parse(jsonStr);			// string -> JSON object로 parsing
// 			    	console.log(jsonStr);
// 			    	console.log(jsonObj);
			    	
			    	$.ajax({
				    	url			: '<?php echo URL;?>/login/signUpUserInfo/', 
				    	type		: 'post',
				    	data		: formData, 
				    	dataType	: 'json',
				    	async		: false,	// 동기식 처리
				    	success		: function (result) {
				    	    if(result.success == true) {
								$('#modalCenterTitle').text('CONFIRM');
								$('#modalHeader').removeClass('bg-danger');
								$('#modalMsg').html(result.data);	// html 태그 적용하기 위해 text 대신 html
								
								$('#cnfModal').modal('show');
								
								// 저장 후 sign in 화면으로 이동
								$("#confirmModal").on("click", function() {
								    location.href = "<?php echo URL; ?>/";
								});

								// confirm 메일 발송
								$.ajax({
									url			: '<?php echo URL;?>/login/sendCnfEmail/',
									type		: 'post',
									data		: formData,
									dataType 	: 'text',
									//async		: false,
									success		: function (ret) {
										// log 파일에 입력되도록 변경 필요
										console.log(ret);
									}
								});
								
				    	    } else {
								$('#modalCenterTitle').text('ERROR');
								$('#modalHeader').addClass('bg-danger');
								$('#modalMsg').text(result.errMsg);
								
								$('#cnfModal').modal('show');
								return;
				    	    }
				    	}
				    }); // end ajax
				}); // end sign up 저장

				// ajax error 공통 처리
				$.ajaxSetup({
			    	error: function(jqXHR, exception, errorThrown) {	// option 3가지이지만 jqXHR에서 에러 내용 확인 가능
			        	if (jqXHR.status === 0) {
			                alert('[Error Code : 0] Not connect.\n Verify Network.');
			            } else if (jqXHR.status == 400) {
			                alert('[Error Code : 400] Server understood the request, but request content was invalid.');
			            } else if (jqXHR.status == 401) {
			                alert('[Error Code : 401] Unauthorized access.');
			            } else if (jqXHR.status == 403) {
			                alert('[Error Code : 403] Forbidden resource can not be accessed.');
			            } else if (jqXHR.status == 404) {
			                alert('[Error Code : 404] Requested page not found.');
			            } else if (jqXHR.status == 500) {
			                alert('[Error Code : 500] Internal server error.');
			            } else if (jqXHR.status == 503) {
			                alert('[Error Code : 503] Service unavailable.');
			            } else if (exception === 'parsererror') {
			                alert('[Exception : Parser Error]  ' + errorThrown + ' || Code = ' + jqXHR.status);
			            } else if (exception === 'timeout') {
			                alert('[Exception : Timeout] Time out error.');
			            } else if (exception === 'abort') {
			                alert('[Exception : Abort] Ajax request aborted.');
			            } else {
			                alert('Uncaught Error.n' + jqXHR.responseText);
			            }
			        }
			    }); 
				
			});	// end document load

		</script>

	</head>
	<body >
		<div class="signup-form">
			<form method="post" id="formSignUp">
				<h2 class="mb-4 text-muted">Sign Up</h2>
				<h5 class="text-muted">Please fill with your info.</h5>
				<hr>
				
				<div class="custom-control custom-switch mb-4">
					<input type="checkbox" class="custom-control-input" id="inputEmpYn" name="inputEmpYn">
					<label class="custom-control-label" for="inputEmpYn">&nbsp;직원인 경우 On</label>
				</div>
				
				<div class="form-group row" style="display: none;" id="divEmpNo">
					<label for="inputEmpNo" class="col-sm-2 col-form-label">Employee No. *</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="inputEmpNo" name="inputEmpNo" placeholder="직원번호">
					</div>
					<div class="btn btn-primary" id="btnEmpCnf">Confirm</div>
					<small class="ml-3" id="info"></small>
				</div>
				
				<!-- 화면 오픈 시 채번 안함
				<div class="form-group row">
					<label for="inputUserId" class="col-sm-2 col-form-label">User Id *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputUserId" name="inputUserId" placeholder="아이디"  value="<?php echo $user['user_id']?>" readonly>
						<small class="text-muted">* 등록 후 사용할 사용자 아이디입니다</small>
					</div>
				</div>
				 -->
				
				<div class="form-group row">
					<label for="inputKname" class="col-sm-2 col-form-label">Korean Name *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="inputKname" id="inputKname" placeholder="한글 이름" required>
						<small id="knameChkRequired" class="text-danger" style="display:none">이 입력란은 필수입니다!</small>
					</div>
				</div>	
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputEmail" >E-mail *</label>
						<input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="이메일" required>
						<small id="emailInline"></small>
					</div>
					<div class="form-group col-md-6">
						<label for="inputCnfEmail">Confirm Email *</label>
						<input type="email" class="form-control" id="inputCnfEmail" name="inputCnfEmail" placeholder="이메일 확인" required>
						<small id="emailCnfInline"></small>
					</div>
				</div>
				
				<!-- 
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputKname">Korean Name *</label>
						<input type="text" class="form-control" id="inputKname" placeholder="한글 이름" required>
					</div>
					<div class="form-group col-md-6">
						<label for="inputEmail">E-mail</label>
						<input type="text" class="form-control" id="inputEmail" placeholder="이메일">
					</div>
				</div>
				 -->	
				 
				 <div class="form-row">
					<div class="form-group col-md-6" id="divPw">
						<label for="inputPw">Password *</label>
						<input type="password" class="form-control" id="inputPw" name="inputPw" placeholder="비밀번호" required>
						<p id="pwChkRequired" class="text-danger mb-0" style="display:none">이 입력란은 필수입니다!</p>
						<small id="passwordHelpInline" class="text-muted">6-13 characters long including case sensitive letters and numbers.</small>
					</div>
					<div class="form-group col-md-6" id="divCnfPw">
						<label for="inputCnfPw">Confirm Password *</label>
						<input type="password" class="form-control" id="inputCnfPw" name="inputCnfPw" placeholder="비밀번호 확인" required>
						<p id="pwCnfChkRequired" class="text-danger mb-0" style="display:none">이 입력란은 필수입니다!</p>
						<small id="passwordCnfInline"></small>
					</div>
				</div>	
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputFname">First Name</label>
						<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="영문 이름">
					</div>
					<div class="form-group col-md-6">
						<label for="inputLname">Last Name</label>
						<input type="text" class="form-control" id="inputLname" name="inputLname" placeholder="영문 성">
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputCompany">Company</label>
						<input type="text" class="form-control" id="inputCompany" name="inputCompany" placeholder="회사">
					</div>
					<div class="form-group col-md-6">
						<label for="inputPosition">Position</label>
						<input type="text" class="form-control" id="inputPosition" name="inputPosition" placeholder="직급">
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
					<button type="submit" class="btn btn-primary btn-lg" id="btnSignUp" style="min-width:100%;">Sign Up</button>
				</div>
				<p class="small text-center">Copyright 2019. Hana Solutions. All rights reserved.</p>
				
			</form>
		</div>
		
	</body>
</html>

<!-- confirm modal -->
<?php require 'application/views/_templates/confirmmodal.php'; ?>



