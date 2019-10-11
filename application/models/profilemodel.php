<?php
/**
 * 
  * @desc		: 프로필 관련 DB Model
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
// 		$this->loginUserId = $_SESSION['user_id'];
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
					user_id			userId
					,kname			kName
					,en_fname		fName
					,en_lname		lName
					,ep_no			empNo
					,email			email
					,company		company
					,position		position
					,resign_ymd		resignYmd
					,gender			gender
					,bth_ymd		bthYmd
					,user_pw		usePw
					,phone_no		phoneNo
					,cell_no		cellNo
					,add_street		addStreet
					,add_city		addCity
					,add_province	addProvince
					,postal			postal
					,act_yn			actYn
					,del_yn			delYn
					,del_date		delDate
					,remark			remark
					,rst_user		rstUser
					,rst_date		rstDate
					,lst_upd_user	lstUpdUser
					,lst_upd_date	lstUpdDate
				FROM TB_USMNF
				where user_id = :userId ";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute(array(':userId'=>$userId));
		
		return $query->fetch();
	}
	
	/**
	 * 
	  * @Method Name	: updateProfInfo
	  * @desc			: 사용자 정보 업데이트
	  * @creator		: BrianC
	  * @date			: 2019. 10. 10.
	 */
	public function updateProfInfo ($data)
	{
		$sql = "update TB_USMNF
				set ACT_YN			= :actYn
					, POSITION  	= :position
					, RESIGN_YMD 	= :resignYmd
					, PHONE_NO 		= :phoneNo
					, CELL_NO 		= :cellNo
					, GENDER 		= :gender
					, BTH_YMD 		= :bthYmd
					, ADD_STREET 	= :addStreet
					, ADD_CITY 		= :addCity
					, ADD_PROVINCE 	= :addProvince
					, POSTAL 		= :postal
					, LST_UPD_USER	= :lstUpdUser
					, LST_UPD_DATE	= getdate()
				where USER_ID 		= :userId ";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute(array(':actYn'=>$data['inputActYn'], ':position'=>$data['inputPosition'], ':resignYmd'=>$data['inputResignYmd'], ':phoneNo'=>$data['inputPhoneNo'], ':cellNo'=>$data['inputCellNo'], 
							':gender'=>$data['inputGender'], ':bthYmd'=>$data['inputBirth'], ':addStreet'=>$data['inputAddStreet'], ':addCity'=>$data['inputAddCity'], ':addProvince'=>$data['inputProvince'], 
							':postal'=>$data['inputPostal'], ':lstUpdUser'=>$data['lstUpdUser'], ':userId'=>$data['inputUserId']));
	}
	

}