<?php 

class Controller 
{
	
	public $db = null;
	
	public function __construct() 
	{
		$this->dbConnect();
	}
	
	private function dbConnect() 
	{
		try {
			require 'encryption.php'; // 암,복호화 클래스
			$enClass = new Encryption();
			$decryptedText = $enClass->decryptRsa(HANA_WHOLE_SALES_DB_PW);
			
			// PDO로 DB connection. ODBC Driver 17 for SQL Server
			// 마지막 파라미터에 options을 주면 view 화면에서 데이터를 출력하는 방법 정할 수 있음. ex>$row['name'], $row[0], $row->name etc
			$this->db = new PDO("sqlsrv:Server=". HANA_WHOLE_SALES_DB_HOST. ";Database=". HANA_WHOLE_SALES_DB_NAME, HANA_WHOLE_SALES_DB_USER, $decryptedText);
			
		} catch (Exception $e) {
			echo $e;
			exit('DB Connection Fail!!!');
		}
	}
	
	// model 명으로 model Class 호출
	public function loadModel ($model_name) 
	{
		require 'application/models/' . strtolower($model_name) . '.php';
		return new $model_name($this->db);
	}
	
}
