<?php 

class Home extends Controller
{
	
	public function index ()
	{
		$this->homeMain();
	}
	
	public function homeMain() 
	{
		$home_model = $this->loadModel('HomeModel');
		$sales_amt = $home_model->getSales();
		
		require 'application/views/_templates/header.php';
		require 'application/views/home/homemain.php';
		require 'application/views/_templates/footer.php';
	}
	
}

