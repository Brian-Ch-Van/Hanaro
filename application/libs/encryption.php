<?php

/**
 * 
 * @author		: BrianC
 * @create		: 2019. 8. 14.
 * @desc		: 암,복호화 클래스
 * 				  AES 대칭키 사용, 키 관리 고려 - 사용자 로그인 암호, 로그인 암호는 복호화돼서 테이블에 등록되어 있어야 함
 * 				  RSA 개인키/대중키 생성, 복호화 때 개인키 필요 - DB Connection 암호
 */

class Encryption {

	// Encrypt - AES
	// open_ssl 사용, extension 추가
	public function encryptAes($plainText)
	{
		$key = "HanaSolutions";	
		
		$key = substr(hash('sha256', $key, true), 0, 32);
		//echo "비밀번호 바이너리:" . $key . "<br/>";
		
		// Initial Vector(IV)는 128 bit(16 byte)
		//$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$iv = str_repeat(chr(0), 16);
		
		// binary
		$encryp_2 = openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		$decryp_2 = openssl_decrypt($encryp_2, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		
		// encryption
		$encrypted = base64_encode(openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
		
		return $encrypted;
	}
	
	// Decrypt - AES
	public function decryptAes($ecryptedText)
	{
		$key = "HanaSolutions";	
		
		$key = substr(hash('sha256', $key, true), 0, 32);
		//echo "비밀번호 바이너리:" . $key . "<br/>";
		
		// Initial Vector(IV)는 128 bit(16 byte)
		//$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$iv = str_repeat(chr(0), 16);
		
		// decryption
		$decrypted = openssl_decrypt(base64_decode($ecryptedText), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		
		return $decrypted;
	}
	
	// Decrypt - RSA
	public function decryptRsa ($encryptedBase64)
	{
		// private key - differenct for each db pw
		$privKey = RSA_PRIVATE_KEY;
		
		// decryption
		openssl_private_decrypt(base64_decode($encryptedBase64), $decrypted, $privKey);
		
		//echo "decrypted : " . $decrypted . "<br/>";
		return $decrypted;
	}
}