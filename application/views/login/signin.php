<?php 
	// session에 user_name 있으면 로그인 한 상태
	if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
		header('location: ' . URL . '/home' );
	}
?>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hana Solutions - Sign In</title>
        
        <link href="public/css/bootstrap.min.css" rel="stylesheet" >
        <link href="public/css/signin.css" rel="stylesheet" >
        
        <!-- favicon -->
        <link rel="shortcut icon" href="public/icon/h_favicon.png" />

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
		
		<script type="text/javascript">
			function checkInfo(msg) {
				$("#info").html(msg).css('color', 'red');
			}
		</script>

	</head>
	<body class="text-center">
		<form class="form-signin" method="post">
			<img class="mb-3" src="public/icon/text_logo.png" alt="" width="300">
			<h1 class="h3 mb-4 font-weight-normal">Please sign in</h1>
			<div class="mb-3" id="info"></div>
			
			<!-- floading label 적용 -->
			<div class="form-label-group">
				<input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email" required autofocus>
				<label for="inputEmail" class="text-left">Email</label>
			</div>
			<div class="form-label-group">
				<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
				<label for="inputPassword" class="text-left">Password</label>
			</div>
			
			<small id="passwordHelpInline" class="text-muted">Your password must be 6-13 case sensitive characters long.</small>

			<div class="mb-4" ></div>
			<button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
			<p class="mt-3"><a href="login/openSignUp" class="text-success font-weight-bold">Sign up Now ></a></p>
			<p class="mt-5 mb-3 text-muted">&copy; 2019. Hana Solutions. All rights reserved.</p>
		</form>
	</body>
</html>

<?php 
	$loginValid = false;

	if (($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['login']))
	{
		$email = $_POST['inputEmail'];
		$userpassword = $_POST['inputPassword'];
		
		try {
			// Controller에 있는 db connection
			$query = $this->db->prepare('select user_id, kname, user_pw, act_yn from TB_USMNF where upper(email) = upper(:email)');
			$query->bindParam(':email', $email);
			$query->execute();
			
		} catch (PDOException $e) {
			die("Database error : " . $e->getMessage());
		}
		
		$cnt = $query->rowcount();
		$row = $query->fetch();
		
		$infoMsg = "";
		
		if($cnt != 0) {
			$actYn = $row['act_yn']; 
			if($actYn == 'N') {
				$infoMsg = "사용자 아이디의 계정이 승인되지 않았습니다.<br> 관리자에게 문의해주세요.";
				
			} else {
				$password = $row['user_pw'];
				// 비밀번호 복호화 로직 적용. table에 암호화 된 비빌번호가 저장되어 있고, 로그인 할 때 복호화해서 비교
				$encryptObj = new Encryption();
				$plainedPw = $encryptObj->decryptAes($password);
				
				if($userpassword == $plainedPw) {
					$loginValid = true;
				} else {
					$infoMsg = '비밀번호를 확인해 주세요.';
				}
			}
			
		} else {
			$infoMsg = '등록된 사용자가 아닙니다.';
		}
		
		// 로그인 성공 시
		if ($loginValid) {
			// session에 user_name 저장			
			session_regenerate_id();		// Update the current session id with a newly generated one
			// session 값 set
			$_SESSION['user_name'] = $row['kname'];
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['user_pw'] = $userpassword;
			session_write_close();			// Write session data and end session
			
			// homemain.php 화면 이동
			header('location: '. URL. '/home');
			
		} else {
			echo "<script>checkInfo('$infoMsg');</script>";
		}
		
	}
?>


