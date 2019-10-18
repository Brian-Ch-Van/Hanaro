<?php

if(isset($_GET['lang']))
{
	$lang = $_GET['lang'];
	
	// register the session and set the cookie
	$_SESSION['lang'] = $lang;
	
	setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isset($_SESSION['lang']))
{
	$lang = $_SESSION['lang'];
}
else if(isset($_COOKIE['lang']))
{
	$lang = $_COOKIE['lang'];
}
else
{
	$lang = 'en';
}

//echo "<script>alert('$lang');</script>";

switch ($lang) {
	case 'ko':
		$lang_file = 'lang_ko.php';
		break;
		
	default:
		$lang_file = 'lang_en.php';
}

include 'application/languages/'.$lang_file;