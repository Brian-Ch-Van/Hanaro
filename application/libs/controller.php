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
			require 'encryption.php'; // 암,복호화 클래스
			$enClass = new Encryption();
			$decryptedText = $enClass->decryptRsa(HANA_WHOLE_SALES_DB_PW);
			
			// PDO로 DB connection. ODBC Driver 17 for SQL Server
			// 마지막 파라미터에 options을 주면 view 화면에서 데이터를 출력하는 방법 정할 수 있음. ex>$row['name'], $row[0], $row->name etc
			$this->db = new PDO("sqlsrv:Server=". HANA_WHOLE_SALES_DB_HOST. ";Database=". HANA_WHOLE_SALES_DB_NAME, HANA_WHOLE_SALES_DB_USER, $decryptedText);
			// PDO 에러 표시 설정
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// session 초기화
			session_start();
			
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
	public function loadModel ($model_name) 
	{
		require 'application/models/' . strtolower($model_name) . '.php';
		return new $model_name($this->db);
	}
	
}
