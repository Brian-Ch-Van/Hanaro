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
				$("#info").text(msg).css('color', 'red');
			}
		</script>

	</head>
	<body class="text-center">
		<form class="form-signin" method="post">
			<img class="mb-3" src="public/icon/text_logo.png" alt="" width="300">
			
			<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
			
			<div class="mb-3" id="info"></div>
			
			<label for="inputId" class="sr-only">ID</label>
			<input type="text" id="inputName" name="username" class="form-control" placeholder="Name" required autofocus>
			
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" name="userpassword" class="form-control" placeholder="Password" required>
			
			<small id="passwordHelpInline" class="text-muted">Your password must be 6-20 characters long.</small>
			<!-- 
			<div class="checkbox mb-3">
				<label>
					<input type="checkbox" value="remember-me"> Remember me
				</label>
			</div>
			 -->
			 <div class="mb-4" ></div>
			<button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
			<p class="mt-5 mb-3 text-muted">&copy; Hana Solution Inc.</p>
		</form>
	</body>
</html>

<?php 
	$login_ok = false;

	if (($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['login']))
	{
		$username = $_POST['username'];
		$userpassword = $_POST['userpassword'];
		
		try {
			// Controller에 있는 db connection
			$query = $this->db->prepare('select sf_no, sf_name, sf_passwd from tb_staff where lower(sf_name)=lower(:username)');
			$query->bindParam(':username', $username);
			$query->execute();
			
		} catch (PDOException $e) {
			die("Database error : " . $e->getMessage());
		}
		
		$cnt = $query->rowcount();
		$row = $query->fetch();
		$password = $row['sf_passwd'];
		
		$infoMsg = "";
		if ($cnt == 0) {
			$infoMsg = '등록된 사용자가 아닙니다.';
			
		} else {
			// 비밀번호 복호화 로직 적용. table에 암호화 된 비빌번호가 저장되어 있고, 로그인 할 때 복호화해서 비교
			$encryptObj = new Encryption();
			$plainedPw = $encryptObj->decryptAes($password);
			
			if($userpassword == $plainedPw) {
				$login_ok = true;
			} else {
				$infoMsg = '비밀번호를 확인해 주세요.';
			}
		}
		
		// 로그인 성공 시
		if ($login_ok) {
			// session에 user_name 저장			
			session_regenerate_id();		// Update the current session id with a newly generated one
			$_SESSION['user_name'] = $row['sf_name'];
			session_write_close();			// Write session data and end session
			
			// homemain.php 화면 이동
			header('location: '. URL. '/home');
			
		} else {
			echo "<script>checkInfo('$infoMsg');</script>";
		}
		
	}
?>







