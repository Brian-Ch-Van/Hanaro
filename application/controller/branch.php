<?php

class Branch extends Controller 
{
	public function index ()
	{
		$this->brnList();
	}
	
	// Branch List
	public function brnList ()
	{
		$model = $this->loadModel("BranchModel");
		$brn_list = $model->getBrnList();
		
		require 'application/views/_templates/header.php';
		require 'application/views/branch/branchlist.php';
		require 'application/views/_templates/footer.php';
	}
	
}