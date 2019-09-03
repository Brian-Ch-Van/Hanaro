<?php

class Sales extends Controller 
{
	public function index ()
	{
		$this->salesList();
	}
	
	// Sales List
	public function salesList ()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/sales/salesmain.php';
		require 'application/views/_templates/footer.php';
	}
	
}