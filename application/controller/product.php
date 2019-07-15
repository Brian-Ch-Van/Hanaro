<?php

class Product extends Controller
{
	public function index ()
	{
		$this->prodList();
	}
	
	// Product List
	public function prodList ()
	{
		$model = $this->loadModel("ProductModel");
		$prod_list = $model->getProdList();
		
		require 'application/views/_templates/header.php';
		require 'application/views/product/productlist.php';
		require 'application/views/_templates/footer.php';
	}
	
}