<?php 

/**
 * 
  * @desc		: Home 관련 controller
  * @creator	: BrianC
  * @date		: 2019. 9. 1.
  * @Version	: 
  * @history	: 
  *
 */
class Home extends Controller
{
	
	public function index ()
	{
		$this->homeMain();
	}
	
	/**
	 * 
	  * @Method Name	: homeMain
	  * @desc			: home 화면 이동
	  * @creator		: BrianC
	  * @date			: 2019. 9. 1.
	 */
	public function homeMain() 
	{
		$home_model = $this->loadModel('HomeModel');
		$sales_amt = $home_model->getSales();
		
		require 'application/views/_templates/header.php';
		require 'application/views/home/homemain.php';
		require 'application/views/_templates/footer.php';
	}
	
}

