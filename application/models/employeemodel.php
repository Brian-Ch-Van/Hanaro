<?php
/**
 * 
 * @author		: BrianC
 * @create		: 2019. 7. 16.
 * @desc		: 직원 정보 모델
 *
 */

class EmployeeModel
{
	function __construct ($db) {
		$this->dbCon = $db;
	}
	
	// employee list
	public function getEplyList () 
	{
		try {
			$sql = "select
					sf_no
					, sf_name
					, sf_sdate
					, sf_contact
					, sf_remark
				from tb_staff";
			
			$query = $this->dbCon->prepare($sql);
			$query->execute();
			
		} catch (PDOException $e) {
			die("Database error : " . $e->getMessage());
		}

		return $query->fetchAll();
	}
	
}