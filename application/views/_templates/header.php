<?php
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
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>		
		
		<!-- Font Awesome -->
		<script src="https://kit.fontawesome.com/b531862797.js"></script>
		
		<script src="<?php echo JS_URL; ?>/bootstrap.bundle.min.js"></script>
		
		<!-- Chart -->
		<script src="https://d3js.org/d3.v5.min.js"></script>
		<script src="<?php echo CSS_URL;?>/billboard/billboard.js"></script>
		<link rel="stylesheet" href="<?php echo CSS_URL;?>/billboard/billboard.css">
		
		<script type="text/javascript">
			$(document).ready(function() {

			    console.log('accessable menu');
				<?php foreach ($_SESSION['menu_list'] as $row) { ?>
						console.log('menu_id: '+ '<?php echo $row['menu_id']?>' + ' / menu_name :' +'<?php echo $row['menu_name']?>');

						$('#menuBar').find('li').each(function (){
							var barMnNm = $(this).attr('id').split('_')[1];
							if(barMnNm == '<?php echo $row['menu_name']; ?>') {
									$(this).removeAttr('hidden');
								}
							});
				<?php }	?>

				$("body").contextmenu(function () {
					return false;
				});
				
				// sign out
				$('#sign_out').on('click', function() {
				    location.href = "<?php echo URL; ?>/login/signOut";
				});
				
			});
		</script>

	</head>
	
	<body class="d-flex flex-column h-100 bg-light" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'>
		<header>
			<!-- Fixed navbar -->
			<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark" >
				<!-- <img src="<?php echo ICON_URL; ?>/h_logo.png" width="30" height="30" class="d-inline-block align-top" alt="Hana Solutions"> -->
				<a class="navbar-brand" href="<?php echo URL; ?>/home">Hana Solutions</a>
				
				<!-- 화면 사이즈 변경 시 toggle로 메뉴 버튼 표시 -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<!-- Nav menu -->
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav bd-navbar-nav" id="menuBar">
						<li class="nav-item" id="li_Home" hidden>
							<a class="nav-link" href="<?php echo URL; ?>/home">Home</a>
						</li>
						<li class="nav-item dropdown" id="li_Sales" hidden>
							<a class="nav-link dropdown-toggle" href="" id="sales_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sales</a>
							<div class="dropdown-menu" aria-labelledby="sales_dropdown">
								<a class="dropdown-item" href="<?php echo URL; ?>/sales">Sales Main</a>
								<a class="dropdown-item" href="<?php echo URL; ?>/sales/openDailySales">Daily Sales</a>
								<a class="dropdown-item" href="<?php echo URL; ?>/sales/openHourlySales">Hourly Visitors/Sales Chart</a>
							</div>
						</li>
						<li class="nav-item dropdown" id="li_Admin" hidden>
							<a class="nav-link dropdown-toggle" href="" id="admin_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
							<div class="dropdown-menu" aria-labelledby="admin_dropdown">
								<a class="dropdown-item" href="<?php echo URL; ?>/admin">User List</a>
								<a class="dropdown-item" href="<?php echo URL; ?>/admin/openAddRole">Add Role</a>
							</div>
						</li>
						<li class="nav-item dropdown" id="li_System" hidden>
							<a class="nav-link dropdown-toggle" href="" id="system_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">System</a>
							<div class="dropdown-menu" aria-labelledby="system_dropdown">
								<a class="dropdown-item" href="<?php echo URL; ?>/system/getRsrcList">Resource Manage</a>
								<a class="dropdown-item" href="<?php echo URL; ?>/system/openEncryptDemo">Encrypt Demo</a>
							</div>
						</li>						
					</ul>
				</div>
				<!-- Nav menu end -->
				
				<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
					<li class="nav-item dropdown">
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
				<!-- 한/영 처리 추후 개발 
				<a href="<?php echo URL;?>/home?lang=ko"><img class="ml-2" src="<?php echo IMG_URL;?>/kr_sm.png" alt="Kor_flag" title="한국어"/></a><a href="<?php echo URL;?>/home?lang=en"><img class="ml-1" src="<?php echo IMG_URL;?>/ca_sm.png" alt="Can_flag" title="English"/></a>
				 -->
			</nav>
		</header>

	<script type="text/javascript">

		// Menu active
		var loc_path = location.pathname;
		$('li.active').removeClass('active');
// 		alert('loc_pat = ' + loc_path);
	
		if(loc_path.includes('/home')){
			$('#li_Home').addClass('active');
		} else if(loc_path.includes('/sales')) {
			$('#li_Sales').addClass('active');
		} else if(loc_path.includes('/admin')) {
			$('#li_Admin').addClass('active');
		} else if(loc_path.includes('/system')) {
			$('#li_System').addClass('active');
		}	// .. menu add 
		
	</script>
			
	<?php require 'signoutmodal.php'; ?>