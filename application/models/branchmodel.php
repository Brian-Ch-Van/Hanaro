<?php
/**
 *
 * @author		: BrianC
 * @create		: 2019. 7. 31.
 * @desc		: 매장 정보 모델
 *
 */

class BranchModel 
{
	function __construct ($db) 
	{
		$this->dbCon = $db;
	}
	
	// branch list
	public function getBrnList ()
	{
		$sql = "select top 100
					mk_no
					, mk_name
					, mk_street
					, mk_city
					, mk_province
					, mk_postal
					, mk_telno
					, mk_vDate
				from tb_market";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute();
		
		return $query->fetchAll();
	}
}