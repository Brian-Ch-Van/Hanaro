<?php

class Login extends Controller
{
	public function index ()
	{
		require 'application/views/login/signin.php';
	}
	
	public function logOut ()
	{
		require 'application/views/login/signout.php';
	}
}