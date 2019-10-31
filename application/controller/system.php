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
		try {
			$rsrcInfo = $_POST;	// POST로 넘겨온 form 전체
			
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
				
				$result = array();
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
	
	
}