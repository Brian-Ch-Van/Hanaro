<?php 

/**
 * 
  * @desc		: Controller class
  * @creator	: BrianC
  * @date		: 2019. 9. 1.
  * @Version	: v1.0
  * @history	: 최초 생성
  *
 */
class Controller 
{
	public $db = null;
	public $dbCq1Han = null;
	public $dbDn1Han = null;
	public $dbLl1Han = null;
	public $dbRmHist = null;
	public $dbPcHist = null;
	public $dbDbHist = null;
	public $dbUbcHist = null;
	
	public function __construct() 
	{
		$this->dbConnect();
	}
	
	/**
	 * 
	  * @Method Name	: dbConnect
	  * @desc			: DB Conncection
	  * @creator		: BrianC
	  * @date			: 2019. 9. 1.
	 */
	private function dbConnect() 
	{
		try {
			require 'encryption.php';
			$enClass = new Encryption();
			$decryptedText = $enClass->decryptRsa(HANA_DB_PW);
			
			// PDO로 DB connection. ODBC Driver 17 for SQL Server
			// 마지막 파라미터에 options을 주면 view 화면에서 데이터를 출력하는 방법 정할 수 있음. ex>$row['name'], $row[0], $row->name etc
			$this->db = new PDO("sqlsrv:Server=". HANA_DB_HOST. ";Database=". HANA_DB_NAME, HANA_DB_USER, $decryptedText);
			// PDO error set
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			// branch db connection 
			$this->dbCq1Han = new PDO("sqlsrv:Server=". HANA_CQ_DB_HOST. ";Database=". HANA_CQ_DB_NAME_DB1HAN, HANA_CQ_DB_USER, HANA_CQ_DB_PW);
			$this->dbCq1Han->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$this->dbDn1Han = new PDO("sqlsrv:Server=". HANA_DN_DB_HOST. ";Database=". HANA_DN_DB_NAME_DB1HAN, HANA_DN_DB_USER, HANA_DN_DB_PW);
			$this->dbDn1Han->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$this->dbLl1Han = new PDO("sqlsrv:Server=". HANA_LL_DB_HOST. ";Database=". HANA_LL_DB_NAME_DB1HAN, HANA_LL_DB_USER, HANA_LL_DB_PW);
			$this->dbLl1Han->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$this->dbRmHist = new PDO("sqlsrv:Server=". HANA_RM_DB_HOST. ";Database=". HANA_RM_DB_NAME_HANAHIST, HANA_RM_DB_USER, HANA_RM_DB_PW);
			$this->dbRmHist->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$this->dbPcHist = new PDO("sqlsrv:Server=". HANA_PC_DB_HOST. ";Database=". HANA_PC_DB_NAME_HANAHIST, HANA_PC_DB_USER, HANA_PC_DB_PW);
			$this->dbPcHist->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$this->dbDbHist = new PDO("sqlsrv:Server=". HANA_DB_DB_HOST. ";Database=". HANA_DB_DB_NAME_HANAHIST, HANA_DB_DB_USER, HANA_DB_DB_PW);
			$this->dbDbHist->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$this->dbUbcHist = new PDO("sqlsrv:Server=". HANA_UBC_DB_HOST. ";Database=". HANA_UBC_DB_NAME_HANAHIST, HANA_UBC_DB_USER, HANA_UBC_DB_PW);
			$this->dbUbcHist->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		} catch (PDOException $e) {
			echo 'DB Connection failed: ' . $e->getMessage();
			exit;
		}
	}
	
	/**
	 * 
	  * @Method Name	: loadModel
	  * @desc			: model name에 맞는 model class call
	  * @creator		: BrianC
	  * @date			: 2019. 9. 1.
	  * @param  		: $model_name
	  * @return 		: model class
	 */
	public function loadModel ($modelName) 
	{
		require 'application/models/' . strtolower($modelName) . '.php';
		return new $modelName($this->db);
	}
	
	/**
	 * 
	  * @Method Name	: loadModelByDbName
	  * @desc			: call model call with branch DB
	  * @creator		: BrianC
	  * @date			: 2019. 11. 25.
	  * @param  $modelName
	  * @param  $brchName
	  * @return 
	 */
	public function loadModelByDbName ($modelName, $brchName)
	{
		require 'application/models/' . strtolower($modelName) . '.php';
		
		if("CQ_DB1HAN" == $brchName) {
			return new $modelName($this->dbCq1Han);
		} else if ("DN_DB1HAN" == $brchName) {
			return new $modelName($this->dbDn1Han);
		} else if ("LL_DB1HAN" == $brchName) {
			return new $modelName($this->dbLl1Han);
		} else if ("RM_HIST" == $brchName) {
			return new $modelName($this->dbRmHist);
		} else if ("PC_HIST" == $brchName) {
			return new $modelName($this->dbPcHist);
		} else if ("DB_HIST" == $brchName) {
			return new $modelName($this->dbDbHist);
		} else if ("UBC_HIST" == $brchName) {
			return new $modelName($this->dbUbcHist);
		}
		
	}
	
}
