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
	
	/**
	 * 
	  * @Method Name	: selProfInfo
	  * @desc			: 사용자 프로필 정보 조회
	  * @creator		: BrianC
	  * @date			: 2019. 9. 25.
	  * @param  $userId
	  * @return 
	 */
	public function selProfInfo ($userId) 
	{
		$sql = "SELECT 
					user_id
					,kname
					,en_fname
					,en_lname
					,ep_no
					,gender
					,bth_ymd
					,user_pw
					,phone_no
					,cell_no
					,email
					,add_street
					,add_city
					,add_province
					,postal
					,act_yn
					,del_yn
					,del_date
					,remark
					,rst_user
					,rst_date
					,lst_upd_user
					,lst_upd_date
				FROM TB_USMNF
				where user_id = :userId ";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute(array(':userId'=>$userId));
		
		return $query->fetch();
	}
	

}