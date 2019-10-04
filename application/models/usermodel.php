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
	  * @Method Name	: selUserList
	  * @desc			: 사용자 목록 조회
	  * @creator		: BrianC
	  * @date			: 2019. 9. 23.
	  * @return 
	 */
	function selUserList_ ($schData) 
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
					,company
					,position
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
				WHERE kname like :name	
					and en_fname like :fname
					and en_lname like :lname
					and company like :company
				order by rst_date desc
				";
// 		offset {$start_row} rows
// 		fetch next {$list} row only
		
		$query = $this->dbCon->prepare($sql);
		
		// search 한 경우
		if(count($schData) > 0) {
			$query->execute(array(':name'=>"%{$schData['inputName']}%", ':fname'=>"%{$schData['inputFname']}%", ':lname'=>"%{$schData['inputLname']}%", ':company'=>"%{$schData['inputCompany']}%"));
		} else {
			$query->execute(array(':name'=>"%%", ':fname'=>"%%", ':lname'=>"%%", ':company'=>"%%"));
		}
		
		return $query->fetchAll();
	}
	
	/**
	 *
	 * @Method Name	: selUserList
	 * @desc		: 사용자 목록 조회 - 페이징 처리
	 * @creator		: BrianC
	 * @date		: 2019. 10. 3.
	 * @return
	 */
	function selUserList ($schData, $startRow, $list)
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
					,company
					,position
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
				WHERE kname like :name
					and en_fname like :fname
					and en_lname like :lname
					and company like :company
				order by rst_date desc
				offset {$startRow} rows";
		
		if(!empty($list)){
			$sql = $sql." fetch next {$list} row only";
		}
		
		$query = $this->dbCon->prepare($sql);
		
		// search 한 경우
		if(count($schData) > 0) {
			$query->execute(array(':name'=>"%{$schData['inputName']}%", ':fname'=>"%{$schData['inputFname']}%", ':lname'=>"%{$schData['inputLname']}%", ':company'=>"%{$schData['inputCompany']}%"));
		} else {
			$query->execute(array(':name'=>"%%", ':fname'=>"%%", ':lname'=>"%%", ':company'=>"%%"));
		}
		
		return $query->fetchAll();
	}
	
}
