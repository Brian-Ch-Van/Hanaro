<?php

/**
 * 
  * @desc		: Common 관련 DB 모델 
  * @creator	: BrianC
  * @date		: 2019. 10. 29.
  * @Version	: 
  * @history	: 최초 생성
  *
 */
class CommonModel 
{
	
	function __construct($db) {
		$this->dbCon = $db;
	}
	
	/**
	 * 
	  * @Method Name	: selRoleRsrcList
	  * @desc			: 
	  * @creator		: BrianC
	  * @date			: 2019. 10. 29.
	  * @param 			: $userId
	  * @return 
	 */
	public function selRoleRsrcList ($userId)
	{
		try {
			$sql = "select
						a.user_id			user_id
						, b.role_id			role_id
						, b.role_name		role_name
						, b.auth_alias		auth_alias
						, b.del_yn			role_del_yn
						, d.rsrc_id			rsrc_id
						, d.rsrc_name		rsrc_name
						, d.rsrc_type		rsrc_type
						, d.rsrc_desc		rsrc_desc
						, d.sort_order		sort_order
						, d.parent_rsrc_id	parent_rsrc_id
						, d.rsrc_path		rsrc_path
						, d.use_yn			rsrc_use_yn
					from
						TB_USRLF a
						, TB_RLMNF b
						, TB_RLRSF c
						, TB_RSMNF d
					where 1=1
						and a.role_id = b.role_id
						and b.role_id = c.role_id
						and c.rsrc_ID = d.rsrc_id
						and a.user_id = :userId";
			
			$query = $this->dbCon->prepare($sql);
			$query->bindParam(':userId', $userId);
			
			$query->execute();
			
			return $query->fetchAll();
			
		} catch (PDOException $e) {
			die("Role Resource list 조회 중 오류 발생 : " . $e->getMessage());
		}
		
	}
}