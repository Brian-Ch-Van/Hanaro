<?php 

class Home extends Controller
{
	
	public function index ()
	{
		$this->homeMain();
	}
	
	public function homeMain() 
	{
		require 'application/views/_templates/header.php';
		require 'application/views/home/homemain.php';
		require 'application/views/_templates/footer.php';
	}
	
}

