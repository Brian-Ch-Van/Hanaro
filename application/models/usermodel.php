<?php 
/**
 * 
  * @desc		: 사용자 관련 DB 모델
  * @creator	: BrianC
  * @date		: 2019. 9. 23.
  * @Version	: v1.0
  * @history	: 최초 생성
  *
 */
Class UserModel {
	
	function __construct($db) 
	{
		$this->dbCon = $db;
	}
	
	/**
	 * 
	  * @Method Name	: getUserList
	  * @desc			: 사용자 목록 조회
	  * @creator		: BrianC
	  * @date			: 2019. 9. 23.
	  * @return 
	 */
	function getUserList () 
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
				FROM TB_USMNF";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute();
		
		return $query->fetchAll();
	}
	
}
