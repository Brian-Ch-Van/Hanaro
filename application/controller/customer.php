<?php

class Customer extends Controller 
{
	public function index ()
	{
		$this->custList();
	}
	
	// Customer List
	public function custList ()
	{
		$model = $this->loadModel("CustomerModel");
		$cust_list = $model->getCusList();
		
		require 'application/views/_templates/header.php';
		require 'application/views/customer/customerlist.php';
		require 'application/views/_templates/footer.php';
	}
	
}