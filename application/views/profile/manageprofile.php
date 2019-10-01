
	<main role="main" class="flex-shrink-0">
		<div class="container">
			<h2 class="mt-4" style="font-weight: bold;">사용자 정보</h2>
			
			<!-- <form method="post" id="formProfile" style="background-color:#343a40; padding:10px 10px 10px 10px; color: white;"> -->
			<form method="post" id="formProfile" style="padding:10px 10px 10px 10px; " >
				
				<div class="form-group row">
					<label for="inputUserId" class="col-sm-2 col-form-label">User ID *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="inputUserId" id="inputUserId" placeholder="사용자 아이디" required>
					</div>
				</div>	
				
				<div class="form-group row">
					<div class="col-sm-2">
						Activation
					</div>
					<div class="form-check">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="inputActYes" name="inputActYn" class="custom-control-input">
							<label class="custom-control-label" for="inputActYes">활성</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="inputActNo" name="inputActYn" class="custom-control-input">
							<label class="custom-control-label" for="inputActNo">비활성</label>
						</div>
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-6" id="divKname">
						<label for="inputKname">Korean Name *</label>
						<input type="text" class="form-control" id="inputKname" name="inputKname" placeholder="한글 이름" required>
					</div>
					<div class="form-group col-md-6" id="divEmail">
						<label for="inputEmail">Email *</label>
						<input type="password" class="form-control" id="inputEmail" name="inputEmail" placeholder="이메일" required>
					</div>
				</div>		
				 
				<div class="form-row">
					<div class="form-group col-md-6" id="divPw">
						<label for="inputPw">Password *</label>
						<input type="password" class="form-control" id="inputPw" name="inputPw" placeholder="비밀번호" required>
						<small id="passwordHelpInline" class="">6-13 characters long including letters and numbers.</small>
					</div>
					<div class="form-group col-md-6" id="divCnfPw">
						<label for="inputCnfPw">Confirm Password *</label>
						<input type="password" class="form-control" id="inputCnfPw" name="inputCnfPw" placeholder="비밀번호 확인" required>
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
						<label for="inputBirth">생년월일</label>
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
					<button type="submit" class="btn btn-primary" id="btnSignUp" >저장</button>
				</div>
				
			</form>
						
		</div>
	</main>