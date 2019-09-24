<?php
/**
 * 
  * @desc		: admin 관련 controller
  * @creator	: BrianC
  * @date		: 2019. 9. 9.
  * @Version	: 
  * @history	: 
  *
 */
class Admin extends Controller 
{
	
	public function index ()
	{
		$this->userList();
	}
	
	/**
	 * 
	  * @Method Name	: userList
	  * @desc			: 사용자 목록 조회
	  * @creator		: BrianC
	  * @date			: 2019. 9. 23.
	 */
	public function userList ()
	{
		$user_model = $this->loadModel("UserModel");
		$userList = $user_model->getUserList();
		
		require 'application/views/_templates/header.php';
		require 'application/views/admin/userlist.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: eplyList
	  * @desc			: 직원 목록 조회
	  * @creator		: BrianC
	  * @date			: 2019. 9. 23.
	 */
	public function eplyList () 
	{
		$model = $this->loadModel("EmployeeModel");
		$eply_list = $model->getEplyList();
		
		require 'application/views/_templates/header.php';
		require 'application/views/admin/employeelist.php';
		require 'application/views/_templates/footer.php';
	}
	
	// Sales -> 메뉴 이동 필요???
	public function sales ()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/admin/sales.php';
		require 'application/views/_templates/footer.php';
	}
	
	
}