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
		$this->loginUserId = $_SESSION['user_id'];
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
	
	/**
	 * 
	  * @Method Name	: selCdmnList
	  * @desc			: 통합 코드 정보 조회
	  * @creator		: BrianC
	  * @date			: 2019. 11. 27.
	  * @param  $cdId
	  * @return 
	 */
	public function selCdmnList ($cdId)
	{
		try {
			$sql = "select 
						cd_id
						, cd_key
						, cd_value
						, cd_desc
						, cd_order
						, use_yn
						, rst_user
						, rst_date
						, lst_upd_user
						, lst_upd_date
					from TB_CDMNF 
					where cd_id = :cdId
					order by cd_order
					";
			
			$query = $this->dbCon->prepare($sql);
			$query->bindParam(':cdId', $cdId);
			
			$query->execute();
			
			return $query->fetchAll();
			
		} catch (PDOException $e) {
			die("통합코드 list 조회 중 오류 발생 : " . $e->getMessage());
		}
	}
	
	/**
	 * 
	  * @Method Name	: insertRole
	  * @desc			: Role info 등록
	  * @creator		: BrianC
	  * @date			: 2019. 11. 28.
	 */
	public function insertRoleInfo ($roleInfo)
	{
		try {
			$sql = "insert into TB_RLMNF
						( ROLE_ID
						, ROLE_NAME
						, AUTH_ALIAS
						, ROLE_DESC
						, DEL_YN
						, RST_USER
						, RST_DATE
						, LST_UPD_USER
						, LST_UPD_DATE )
					values
						( :roleId
						, :roleName
						, :authAlias
						, :roleDesc
						, 'Y'
						, :rstUser
						, getdate()
						, :lstUpdUser
						, getdate() )";
			
			$query = $this->dbCon->prepare($sql);
			
			$query->bindValue(':roleId', $roleInfo['inputRoleId']);
			$query->bindValue(':roleName', $roleInfo['inputRoleName']);
			$query->bindValue(':authAlias', $roleInfo['inputAuthArr']);
			$query->bindValue(':roleDesc', $roleInfo['inputRoleDesc']);
			$query->bindValue(':rstUser', $this->loginUserId);
			$query->bindValue(':lstUpdUser', $this->loginUserId);
			$query->execute();
		} catch (PDOException $e) {
			die("Role 등록 중 오류 발생 (method - insertRoleInfo) :  " . $e->getMessage());
		}
	}
	
	/**
	 * 
	  * @Method Name	: insertRoleRsrc
	  * @desc			: Role Id의 Resource 등록
	  * @creator		: BrianC
	  * @date			: 2019. 11. 29.
	  * @param 			: $roleInfo
	 */
	public function insertRoleRsrc ($roleId, $rsrcId)
	{
		try {
			$sql = "insert into TB_RLRSF
						( ROLE_ID
						, RSRC_ID
						, RST_USER
						, RST_DATE
						, LST_UPD_USER
						, LST_UPD_DATE)
					values
						( :roleId
						, :rsrcId
						, :rstUser
						, getdate()
						, :lstUpdUser
						, getdate() )";
			
			$query = $this->dbCon->prepare($sql);
			
			$query->bindValue(':roleId', $roleId);
			$query->bindValue(':rsrcId', $rsrcId);
			$query->bindValue(':rstUser', $this->loginUserId);
			$query->bindValue(':lstUpdUser', $this->loginUserId);
			$query->execute();
		} catch (PDOException $e) {
			die("Role의 Resource 등록 중 오류 발생 (method - insertRoleInfo) :  " . $e->getMessage());
		}
	}
	
}