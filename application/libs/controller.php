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
			// PDO로 DB connection. ODBC Driver 17 for SQL Server
			// 마지막 파라미터에 options을 주면 view 화면에서 데이터를 출력하는 방법 정할 수 있음. ex>$row['name'], $row[0], $row->name etc
			$this->db = new PDO("sqlsrv:Server=". DB_HOST. ";Database=". DB_NAME, DB_USER, $this->decodeText(DB_PASS));
			
		} catch (Exception $e) {
			echo $e;
			exit('DB Connection Fail!!!');
		}
	}
	
	// 암호화
	public function encodeText($plainText) 
	{
		$key = "HanaSolutions";	//암/복호화 할 key 값, 관리를 어떻게 할지 고려
		
		// 256 bit 키를 만들기 위해서 key를 해시해서 첫 32바이트를 사용합니다.
		$key = substr(hash('sha256', $key, true), 0, 32);
		//echo "비밀번호 바이너리:" . $key . "<br/>";
		
		// Initial Vector(IV)는 128 bit(16 byte)입니다.
		//$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$iv = str_repeat(chr(0), 16);
		
		$encryp_2 = openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		$decryp_2 = openssl_decrypt($encryp_2, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		
		// 암호화
		$encrypted = base64_encode(openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
		
		return $encrypted;
	}
	
	// 복호화
	public function decodeText($ecryptedText) 
	{
		$key = "HanaSolutions";	//암/복호화 할 key 값
		
		// 256 bit 키를 만들기 위해서 key를 해시해서 첫 32바이트를 사용합니다.
		$key = substr(hash('sha256', $key, true), 0, 32);
		//echo "비밀번호 바이너리:" . $key . "<br/>";
		
		// Initial Vector(IV)는 128 bit(16 byte)입니다.
		//$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$iv = str_repeat(chr(0), 16);
		
		// 복호화
		$decrypted = openssl_decrypt(base64_decode($ecryptedText), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		
		return $decrypted;
	}
}
