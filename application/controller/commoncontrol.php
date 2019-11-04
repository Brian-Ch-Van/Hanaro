<?php

/**
 * 
  * @desc		: Common Controller
  * @creator	: BrianC
  * @date		: 2019. 10. 29.
  * @Version	: 
  * @history	: 최초 생성
  *
 */
class CommonControl extends Controller
{
	public function index ()
	{
		$this->getRoleRsrcList();
	}
	
	/**
	 * 
	  * @Method Name	: getRoleRsrcList
	  * @desc			: Role, Resource list of users 
	  * @creator		: BrianC
	  * @date			: 2019. 10. 29.
	  * @return 		: Role Resource list
	 */
	public function getRoleRsrcList ($userId)
	{
		try {
			$common_model = $this->loadModel('CommonModel');
			$roleRsrcList = $common_model->selRoleRsrcList($userId);
			
			return $roleRsrcList;
			
		} catch (PDOException $e) {
			die("Database error : " . $e->getMessage());
		}
		
	}
	
}