<?php

class ProfileModel 
{
	function __construct ($db) 
	{
		$this->dbCon = $db;
		$this->userName = $_SESSION['user_name'];
	}
	
	// update password
	public function updatePassword ($newPw) 
	{
		$sql = "update tb_epmnm
				set pw = :newPw
				where lower(fst_name) = lower(:fstName)";
		
		$query = $this->dbCon->prepare($sql);
		$query->execute(array(':newPw'=>$newPw, ':fstName'=>$this->userName));
		
	}
}