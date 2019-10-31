<?php
	$userRoleList = $_SESSION['role_list'];
	$userScreenList = $_SESSION['screen_list'];
	
// 	$splitFileName = explode('\\', __FILE__);
// 	echo 'splitFileName : <br>';
// 	print_r($splitFileName);
	
	$curScreenName = $splitFileName[count($splitFileName)-1];
	
	$isScreenAuth = in_array($curScreenName, array_column($userScreenList, 'screen_name'));
	if (!$isScreenAuth) {
		require_once 'application/views/error/inaccessible.php';
		exit;
	}


	
	