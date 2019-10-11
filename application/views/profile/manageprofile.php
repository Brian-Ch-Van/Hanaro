
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
		    $('#inputKname').val('<?php echo $profileInfo['kName'];?>');
		    $('#inputEmail').val('<?php echo $profileInfo['email'];?>');
		    $('#inputFname').val('<?php echo $profileInfo['fName'];?>');
		    $('#inputLname').val('<?php echo $profileInfo['lName'];?>');
		    $('#inputCompany').val('<?php echo $profileInfo['company'];?>');
		    $('#inputEmpNo').val('<?php echo $profileInfo['empNo'];?>');
		    $('#inputPosition').val('<?php echo $profileInfo['position'];?>');
		    $('#inputPhoneNo').val('<?php echo $profileInfo['phoneNo'];?>');
		    $('#inputCellNo').val('<?php echo $profileInfo['cellNo'];?>');
	        $('#inputGender').val('<?php echo $profileInfo['gender'];?>').prop('selected', true);
		    $('#inputBirth').val('<?php echo $profileInfo['bthYmd'];?>');
		    $('#inputAddStreet').val('<?php echo $profileInfo['addStreet'];?>');
		    $('#inputAddCity').val('<?php echo $profileInfo['addCity'];?>');
		    $('#inputProvince').val('<?php echo $profileInfo['addProvince'];?>').prop('selected', true);
		    $('#inputPostal').val('<?php echo $profileInfo['postal'];?>');
		    
		    // 목록 
			$("#btnCancel").on('click', function(){
				//history.back();
				location.href="<?php echo URL;?>/admin";
			
			});

		    // 저장
			// 활성화 여부 value
		    //var actYn = $('input[name="inputActYn"]:checked').val();
			
		});
	</script>
	
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">사용자 정보</h2>
			
			<!-- <form method="post" id="formProfile" style="background-color:#343a40; padding:10px 10px 10px 10px; color: white;"> -->
			<form method="post" id="formProfile" style="background-color: #f4f1f1; padding:10px 10px 10px 10px; " >
				
				<div class="form-group row">
					<div class="col-sm-2">
						Activation
					</div>
					<div class="form-check">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="inputActYes" name="inputActYn" class="custom-control-input" value="Y">
							<label class="custom-control-label" for="inputActYes">활성</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="inputActNo" name="inputActYn" class="custom-control-input" value="N">
							<label class="custom-control-label" for="inputActNo">비활성</label>
						</div>
					</div>
				</div>
				
				<!-- 
				<div class="form-group row">
					<label for="inputUserId" class="col-sm-2 col-form-label">User ID *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="inputUserId" id="inputUserId" placeholder="사용자 아이디" required>
					</div>
				</div>
				 -->	

				
				<div class="form-row">
					<div class="form-group col-md-6" id="divKname">
						<label for="inputKname">Korean Name *</label>
						<input type="text" class="form-control" id="inputKname" name="inputKname" placeholder="한글 이름" required>
					</div>
					<div class="form-group col-md-6" id="divEmail">
						<label for="inputEmail">Email *</label>
						<input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="이메일" required>
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
						<label for="inputEmpNo">Employee No.</label>
						<input type="text" class="form-control" id="inputEmpNo" name="inputEmpNo" placeholder="직원 번호">
					</div>
				</div>	
				
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputPosition">Position</label>
						<input type="text" class="form-control" id="inputPosition" name="inputPosition" placeholder="직급">
					</div>
					<div class="form-group col-md-6">
						<label for="inputResignYmd">Resign</label>
						<input type="text" class="form-control" id="inputResignYmd" name="inputResignYmd" placeholder="YYYYMMDD">
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
						<input type="text" class="form-control" id="inputBirth" name="inputBirth" maxlength="8" placeholder="YYYYMMDD">
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