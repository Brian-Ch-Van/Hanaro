<?php

/**
 * 
  * @desc		: System 관련 Controller
  * @creator	: BrianC
  * @date		: 2019. 10. 22.
  * @Version	: 
  * @history	: 최초 생성
  *
 */
class System extends Controller
{
	
	public function index ()
	{
		$this->getRsrcList();
	}
	
	/**
	 * 
	  * @Method Name	: getRsrcList
	  * @desc			: 리소스 리스트 조회
	  * @creator		: BrianC
	  * @date			: 2019. 10. 22.
	 */
	public function getRsrcList ()
	{
		$rsrc_model = $this->loadModel("ResourceModel");
		$rsrcList = $rsrc_model->selRsrcList();
		
		require 'application/views/_templates/header.php';
		require 'application/views/system/resourcemanage.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: saveRsrcInfo
	  * @desc			: 리소스 정보 저장
	  * @creator		: BrianC
	  * @date			: 2019. 10. 24.
	 */
	public function saveRsrcInfo ()
	{
		$result = array();
		
		try {
			$rsrcInfo = $_POST;
			
			if(!empty($rsrcInfo)) {
				$rsrc_model = $this->loadModel("ResourceModel");
				
				if(empty($rsrcInfo['inputRsrcId'])) {
					$newRsrcId = $rsrc_model->getRsrcId();
					$rsrcInfo['inputRsrcId'] = $newRsrcId['new_rsrc_id'];
				}
				
				if(empty($rsrcInfo['inputUseYn'])) {
					$rsrcInfo['inputUseYn'] = 'Y';
				}
				
				$rsrc_model->mergeRsrcInfo($rsrcInfo);

				$result['success'] = true;
				$result['data'] = 'Resource infomation has been successfully saved.';
				
			} else {
				throw new exception ('An error occurred while saving resource information.');
			}
			
		} catch (Exception $e) {
			$result['success'] = false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
	}
	
	/**
	 * 
	  * @Method Name	: delRsrcInfo
	  * @desc			: 리소스 정보 삭제
	  * @creator		: BrianC
	  * @date			: 2019. 10. 24.
	  * @param 			: $rsrcId
	  * @throws exception
	 */
	public function delRsrcInfo ($rsrcId)
	{
		try {
			if(!empty($rsrcId)) {
				$rsrc_model = $this->loadModel("ResourceModel");
				
				$rsrc_model->deleteRsrcInfo($rsrcId);
				
				$result = array();
				$result['success'] = true;
				$result['data'] = 'Resource infomation has been deleted.';
				
			} else {
				throw new exception ('An error occurred while deleting resource information.');
			}
			
		} catch (Exception $e) {
			$result['success'] = false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
	}
	
	public function openEncryptDemo ()
	{
		require 'application/views/system/ecryptdemo.php';
	}
	
	public function getEncrypted ()
	{
		$plainText = $_POST['inputPlainText'];
		$ecryptedText = $_POST['inputEncrypted'];
		
		$key = 'HanaSolutions';	
		
		$key = substr(hash('sha256', $key, true), 0, 32);
		
		$iv = str_repeat(chr(0), 16);
		
		$encryp_2 = openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		$decryp_2 = openssl_decrypt($encryp_2, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		
		$encrypted = base64_encode(openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
		
		$decrypted = openssl_decrypt(base64_decode($ecryptedText), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		
		echo "<br>Key binary : " . $key . "<br/><br/>";
		
		echo 'plainText : ' . $plainText . "<br/>";
		echo 'Encrypted : ' . $encrypted . "<br/><br/>";
		
		echo 'ecryptedText : ' . $ecryptedText . "<br/>";
		echo 'Decrypted : ' . $decrypted . "<br/>";
	}
	
}