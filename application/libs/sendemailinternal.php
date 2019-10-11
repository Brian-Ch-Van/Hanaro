<?php

class SendEmail {

	public function sendToSingle()
	{
		// 이메일 발송
		$to = "hanas.brianc19@gmail.com";
		$subject = "PHP 메일 발송 테스트";
		$contents = "PHP mail()함수를 이용한 메일 발송 테스트";
		$headers = "From: hanas.brian19@gmail.com\r\n";
		
		try {
			mail($to, $subject, $contents, $headers);
		} catch (Exception $e) {
			throw new exception ($e);
		}
	}

}