<?php 

/**
 * 
  * @desc		: session 관리
  * @creator	: BrianC
  * @date		: 2019. 10. 17.
  * @Version	: 
  * @history	: 
  *
 */
class SessionManage 
{
	public function __construct()
	{
		$this->mngSession();
	}
	
	/**
	 * 
	  * @Method Name	: mngSession
	  * @desc			: 세션 유지 시간 관리 
	  * @creator		: BrianC
	  * @date			: 2019. 10. 17.
	 */
	private function mngSession () 
	{
		// session 초기화
		session_start();
		
		$expiryTime = 3600;	// seconds
		if (isset($_SESSION['sess_last_time']) && (time() - $_SESSION['sess_last_time'] > $expiryTime)) {
			session_unset();
			session_destroy();
		}
		$_SESSION['sess_last_time'] = time();
		
		//echo 'session_echo : '. session_cache_expire();
	}
}

?>