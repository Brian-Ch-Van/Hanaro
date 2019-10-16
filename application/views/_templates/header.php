<?php
	
	// session에 user_name 있으면 로그인 한 상태
	if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
		//echo $_SESSION['user_name'] . '님이 로그인 했습니다.';
		
	} else {
		header('location: ' . URL );
	}

?>

<!doctype html>
<html lang="en" class="h-100">
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Hana Solutions</title>
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
		<link href="<?php echo CSS_URL; ?>/bootstrap.min.css" rel="stylesheet" >
		<link href="<?php echo CSS_URL; ?>/navbar_footer.css" rel="stylesheet" >
		<link href="<?php echo CSS_URL; ?>/common.css" rel="stylesheet" >
		<link href="<?php echo CSS_URL; ?>/profile.css" rel="stylesheet" >
		<script src="<?php echo JS_URL; ?>/common.js"></script>
		
		<!-- favicon -->
        <link rel="shortcut icon" href="<?php echo ICON_URL; ?>/h_favicon.png" />

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
		
		<!-- Font Awesome (for icons) SDN을 따로 받았음 -->
		<script src="https://kit.fontawesome.com/b531862797.js"></script>
		
		<!-- jQuery loading 후 올라가야 modal에서 error 안 남 -->
		<script src="<?php echo JS_URL; ?>/bootstrap.bundle.min.js"></script>
		
		<!-- Chart -->
		<script src="https://d3js.org/d3.v5.min.js"></script>
		<script src="<?php echo CSS_URL;?>/billboard/billboard.js"></script>
		<link rel="stylesheet" href="<?php echo CSS_URL;?>/billboard/billboard.css">
		
		<script type="text/javascript">
			$(document).ready(function() {
			    
				// sign out
				$("#sign_out").on("click", function() {
				    location.href = "<?php echo URL; ?>/login/signOut";
				});

				// 메뉴 선택
				$('#menuBar a').on('click', function (e) {
				   //e.preventDefault();		// 기존 이벤트 무시, javascript 이벤트 포함
 				   //$('#menuBar li').removeClass('active');
 				   //$(this).addClass("active");
				   //location.href = "<?php echo URL;?>/product";
				});

			});
		</script>
	</head>
	
	<body class="d-flex flex-column h-100 bg-light">
		<header>
			<!-- Fixed navbar -->
			<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
				<!-- <img src="<?php echo ICON_URL; ?>/h_logo.png" width="30" height="30" class="d-inline-block align-top" alt="Hana Solutions"> -->
				<a class="navbar-brand" href="<?php echo URL; ?>/home">Hana Solutions</a>
				
				<!-- 화면 사이즈 변경 시 toggle로 메뉴 버튼 표시 -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<!-- Nav menu -->
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav bd-navbar-nav" id="menuBar">
						<li class="nav-item active" >
							<a class="nav-link" href="<?php echo URL; ?>/home">Home</a>
						</li>
						<li class="nav-item active" >
							<a class="nav-link" href="<?php echo URL; ?>/sales">Sales</a>
						</li>
						<!-- 
						<li class="nav-item" >
							<a class="nav-link" href="<?php echo URL; ?>/product">Product</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo URL; ?>/branch">Branch</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo URL; ?>/customer">Customer</a>
						</li>
						 -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="" id="admin_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
							<div class="dropdown-menu" aria-labelledby="admin_dropdown">
								<a class="dropdown-item" href="<?php echo URL; ?>/admin">사용자목록</a>
							</div>
						</li>
					</ul>
									
					<!-- search box 
					<form class="form-inline mt-2 mt-md-0">
						<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form>
					-->
				</div>
				
				<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
					<li class="nav-item dropdown active">
						<a class="nav-item nav-link dropdown-toggle mr-md-2 text-warning" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Hello <?php echo $_SESSION['user_name']; ?> !
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
							<a class="dropdown-item" href="<?php echo URL; ?>/profile/getProfInfo/<?php echo $_SESSION['user_id']; ?>">Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo URL; ?>/profile">Change password</a>        					
						</div>
					</li>
				</ul>
				
				<button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#signoutConfirm">Sign out</button>
			</nav>
		</header>
		
		<?php require 'signoutmodal.php'; ?>

