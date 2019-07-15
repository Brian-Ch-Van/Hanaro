<?php

class CustomerModel 
{
	function __construct ($db) 
	{
		$this->dbCon = $db;
	}
	
	// customer list
	public function getCusList ()
	{
		$sql = "select top 100
					cm_no
					, cm_fname
					, cm_mname
					, cm_lname
					, cm_street1
					, cm_street2
					, cm_city
					, cm_province
					, cm_homephone
					, cm_sDate
				from tb_customer";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute();
		
		return $query->fetchAll();
	}
}