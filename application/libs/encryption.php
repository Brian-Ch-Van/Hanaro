<?php
// 암,복호화 클래스
// AES 대칭키 사용, 키 관리 고려 - 사용자 로그인 암호
// RSA 개인키/대중키 생성, 복호화 때 개인키 필요 - DB Connection 암호

class Encryption {

	// 암호화 - AES
	// open_ssl 사용, extension 추가
	public function encryptAes($plainText)
	{
		$key = "HanaSolutions";	//암/복호화 할 key 값, 관리를 어떻게 할지 고려(table로 관리할지 고려)
		
		// 256 bit 키를 만들기 위해서 key를 해시해서 첫 32바이트를 사용
		$key = substr(hash('sha256', $key, true), 0, 32);
		//echo "비밀번호 바이너리:" . $key . "<br/>";
		
		// Initial Vector(IV)는 128 bit(16 byte)
		//$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$iv = str_repeat(chr(0), 16);
		
		$encryp_2 = openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		$decryp_2 = openssl_decrypt($encryp_2, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		
		// 암호화
		$encrypted = base64_encode(openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
		
		return $encrypted;
	}
	
	// 복호화 - AES
	public function decryptAes($ecryptedText)
	{
		$key = "HanaSolutions";	//암/복호화 할 key 값, 관리를 어떻게 할지 고려
		
		// 256 bit 키를 만들기 위해서 key를 해시해서 첫 32바이트를 사용
		$key = substr(hash('sha256', $key, true), 0, 32);
		//echo "비밀번호 바이너리:" . $key . "<br/>";
		
		// Initial Vector(IV)는 128 bit(16 byte)
		//$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$iv = str_repeat(chr(0), 16);
		
		// 복호화
		$decrypted = openssl_decrypt(base64_decode($ecryptedText), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		
		return $decrypted;
	}
	
	// 복호화 - RSA
	public function decryptRsa ($encryptedBase64)
	{
		// 개인키
		$privKey = RSA_PRIVATE_KEY;
		
		// 복호화
		openssl_private_decrypt(base64_decode($encryptedBase64), $decrypted, $privKey);
		
		//echo "decrypted : " . $decrypted . "<br/>";
		return $decrypted;
	}
}