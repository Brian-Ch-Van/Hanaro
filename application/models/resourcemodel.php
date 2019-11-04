<?php 

/**
 * 
  * @desc		: 리소스 관련 DB Model
  * @creator	: BrianC
  * @date		: 2019. 10. 22.
  * @Version	: 
  * @history	: 최초 생성
  *
 */
Class ResourceModel {
	
	function __construct($db) 
	{
		$this->dbCon = $db;
		
		$this->loginUserId = $_SESSION['user_id'];
	}
	
	/**
	 * 
	  * @Method Name	: selRsrcList
	  * @desc			: 리소스 리스트 조회
	  * @creator		: BrianC
	  * @date			: 2019. 10. 22.
	  * @return 
	 */
	public function selRsrcList () 
	{
		$sql = "select  
					rsrc_id
					, rsrc_name
					, rsrc_type
					, rsrc_disp_name
					, rsrc_desc
					, sort_order
					, parent_rsrc_id
					, rsrc_path
					, use_yn
					, rst_user
					, rst_date
					, lst_upd_user
					, lst_upd_date
				from tb_rsmnf";
		$query = $this->dbCon->prepare($sql);
		$query->execute();
		
		return $query->fetchAll();
	}
	
	/**
	 * 
	  * @Method Name	: mergeRsrcInfo
	  * @desc			: 리소스 정보 merge
	  * @creator		: BrianC
	  * @date			: 2019. 10. 23.
	 */
	public function mergeRsrcInfo ($rsrcInfo)
	{
		$sql = "merge into TB_RSMNF as ori
				using (values (:rsrcId)) as source (id)
					on (ori.rsrc_id = source.id)
				when matched then
					update set 
							ori.rsrc_name 			= :rsrcName
							, ori.rsrc_type 		= :rsrcType
							, ori.rsrc_desc 		= :rsrcDesc
							, ori.rsrc_disp_name	= :rsrcDispName
							, ori.sort_order 		= :sortOrder
							, ori.parent_rsrc_id 	= :parentRsrcId
							, ori.rsrc_path 		= :rsrcPath
							, ori.use_yn			= :useYn
							, ori.lst_upd_user 		= :lstUpdUser
							, ori.lst_upd_date 		= getdate()
				when not matched then
					insert (rsrc_id, rsrc_name, rsrc_type, rsrc_disp_name, rsrc_desc, sort_order, parent_rsrc_id, rsrc_path, use_yn, rst_user, rst_date, lst_upd_user, lst_upd_date)
					values (:rsrcId2, :rsrcName2, :rsrcType2, :rsrcDispName2, :rsrcDesc2, :sortOrder2, :parentRsrcId2, :rsrcPath2, :useYn2, :rstUser, getdate(), :lstUpdUser2, getdate());";
		
		// update
		$query = $this->dbCon->prepare($sql);
		$query->bindValue(':rsrcId', $rsrcInfo['inputRsrcId']);
		$query->bindValue(':rsrcName', $rsrcInfo['inputRsrcName']);
		$query->bindValue(':rsrcType', $rsrcInfo['inputRsrcType']);
		$query->bindValue(':rsrcDispName', $rsrcInfo['inputRsrcDispName']);
		$query->bindValue(':rsrcDesc', $rsrcInfo['inputRsrcDesc']);
		$query->bindValue(':sortOrder', $rsrcInfo['inputSortOrder']);
		$query->bindValue(':parentRsrcId', $rsrcInfo['inputParentRsrcId']);
		$query->bindValue(':rsrcPath', $rsrcInfo['inputRsrcPath']);
		$query->bindValue(':useYn', $rsrcInfo['inputUseYn']);
		$query->bindValue(':lstUpdUser', $this->loginUserId);
		// insert
		$query->bindValue(':rsrcId2', $rsrcInfo['inputRsrcId']);
		$query->bindValue(':rsrcName2', $rsrcInfo['inputRsrcName']);
		$query->bindValue(':rsrcType2', $rsrcInfo['inputRsrcType']);
		$query->bindValue(':rsrcDispName2', $rsrcInfo['inputRsrcDispName']);
		$query->bindValue(':rsrcDesc2', $rsrcInfo['inputRsrcDesc']);
		$query->bindValue(':sortOrder2', $rsrcInfo['inputSortOrder']);
		$query->bindValue(':parentRsrcId2', $rsrcInfo['inputParentRsrcId']);
		$query->bindValue(':rsrcPath2', $rsrcInfo['inputRsrcPath']);
		$query->bindValue(':useYn2', $rsrcInfo['inputUseYn']);
		$query->bindValue(':rstUser', $this->loginUserId);
		$query->bindValue(':lstUpdUser2', $this->loginUserId);
		
		$query->execute();
	}
	
	/**
	 * 
	  * @Method Name	: delRsrcInfo
	  * @desc			: 리소스 삭제
	  * @creator		: BrianC
	  * @date			: 2019. 10. 24.
	  * @param 			: $rsrcId
	 */
	public function deleteRsrcInfo ($rsrcId)
	{
		$sql = "delete TB_RSMNF
				where rsrc_id = :rsrcId; ";
		
		$query = $this->dbCon->prepare($sql);
		
		$query->bindValue(':rsrcId', $rsrcId);
		$query->execute();
	}
	
	/**
	 * 
	  * @Method Name	: getRsrcId
	  * @desc			: 신규 리소스 ID 채번
	  * @creator		: BrianC
	  * @date			: 2019. 10. 24.
	  * @return 		: new_rsrc_id
	 */
	public function getRsrcId ()
	{
		$sql = "select 'R' + RIGHT('0000' + CONVERT(nvarchar(4), ISNULL(RIGHT(MAX(rsrc_id),4),0)+1), 4) new_rsrc_id from TB_RSMNF;";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute();
		
		return $query->fetch();
	}
	
}
