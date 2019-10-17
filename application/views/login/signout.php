<?php 
	
	//unset($_SESSION['user_name']);
	session_unset();	
	session_destroy();
	
	header('location: ' . URL );
