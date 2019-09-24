<?php
/**
 * 
  * @desc		: 프로필 관련 DB Model`
  * @creator	: BrianC
  * @date		: 2019. 9. 3.
  * @Version	: v1.0
  * @history	: 
  *
 */
class ProfileModel 
{
	function __construct ($db) 
	{
		$this->dbCon = $db;
		$this->userName = $_SESSION['user_name'];
	}
	
	/**
	 * 
	  * @Method Name	: updatePassword
	  * @desc			: 비밀번호 수정
	  * @creator		: BrianC
	  * @date			: 2019. 9. 12.
	  * @param  $newPw
	 */
	public function updatePassword ($newPw) 
	{
		$sql = "update tb_epmnm
					set pw = :newPw
				where lower(fst_name) = lower(:fstName)";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute(array(':newPw'=>$newPw, ':fstName'=>$this->userName));
		
	}
}