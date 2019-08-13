<?php

class Profile extends Controller
{
	public function index ()
	{
		$this->mngPsw();
	}
	
	// manage password
	public function mngPsw ()
	{
		
		require 'application/views/_templates/header.php';
		require 'application/views/profile/managepassword.php';
		require 'application/views/_templates/footer.php';
	}
	
}