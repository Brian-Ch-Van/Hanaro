<?php

class Admin extends Controller 
{
	public function index ()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/admin/adminmain.php';
		require 'application/views/_templates/footer.php';
	}
	
	public function eplyList () 
	{
		$model = $this->loadModel("EmployeeModel");
		$eply_list = $model->getEplyList();
		
		require 'application/views/_templates/header.php';
		require 'application/views/admin/employeelist.php';
		require 'application/views/_templates/footer.php';
	}
	
	
}