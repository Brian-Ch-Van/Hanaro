<?php

/**
 * 
  * @desc		: admin 관련 controller
  * @creator	: BrianC
  * @date		: 2019. 9. 9.
  * @Version	: 
  * @history	: 
  *
 */
class Admin extends Controller 
{
	
	public function index ()
	{
		$this->userList();
	}
	
	/**
	 * 
	  * @Method Name	: userList
	  * @desc			: 사용자 목록 조회
	  * @creator		: BrianC
	  * @date			: 2019. 9. 23. 최초 생성
	 */
	public function userList ()
	{
		$schData = $_POST;
		
		$user_model = $this->loadModel("UserModel");
		// 검색 조건에 맞는 전체 데이터 조회
		$userList = $user_model->selUserList($schData, 0, '');
		
		// 페이징 처리 start =============================
		$totalCnt = count($userList);	// 데이터 전체 건 수
		
		$page = 1;	// 현재 페이지
		if(isset($_GET['page']) && !empty($_GET['page'])) {
			$page = $_GET['page'];
		}
		
		$list = 15;	// default 페이지 당 리스트 수
		if(isset($schData) && !empty($schData)) {
			if(!empty($schData)) {
				$list = $schData['inputListCnt'];
			}
		}
		$block = 5;	// 블록 당 페이지 수
		
		$pageNum = ceil($totalCnt/$list);	// 총 페이지 수
		$blockNum = ceil($pageNum/$block);	// 총 블록 수
		$nowBlock = ceil($page/$block);		// 현재 블록
		
		$startPage = ($nowBlock * $block) - ($block-1);	// 각 블록의 시작 페이지
		if($startPage <= 1) {
			$startPage = 1;
		}
		
		$endPage = $nowBlock * $block;		// 각 블록의 끝 페이지
		if($pageNum <= $endPage) {
			$endPage = $pageNum;
		}

		$startRow = ($page-1) * $list;		// 페이징에서 조회 할 시작 row
		
		// 페이징 처리 end =============================

		// 페이징 적용한 리스트
		$userList = $user_model->selUserList($schData, $startRow, $list);

		require 'application/views/_templates/header.php';
		require 'application/views/admin/userlist.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: getUserInfo
	  * @desc			: 사용자 상세 정보 조회
	  * @creator		: BrianC
	  * @date			: 2019. 10. 9.
	  * @param  $userId
	 */
	public function getUserInfo ($userId)
	{
		$profile_model = $this->loadModel('ProfileModel');
		$profileInfo = $profile_model->selProfInfo($userId);
		
		require 'application/views/_templates/header.php';
		require 'application/views/admin/userdetail.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: modifyUserInfo
	  * @desc			: 사용자 정보 수정
	  * @creator		: BrianC
	  * @date			: 2019. 10. 10.
	 */
	public function modifyUserInfo ()
	{
		try {
			$formProfileData = $_POST;	// POST로 넘겨온 form 전체
			
			if (!empty($formProfileData)) {
				
				$resignDate = $formProfileData['inputResignYmd'];
				if(!empty($resignDate)) {
					$formProfileData['inputActYn'] = 'N';
				}
				
				// profile model call
				$profile_model = $this->loadModel('ProfileModel');
				
				// 로그인 사용자
				$loginUserId = $_SESSION['user_id'];	
				$formProfileData['lstUpdUser'] = $loginUserId;

				// update
				$profile_model->updateUserInfo($formProfileData);
				
				$result = array();
				$result['success'] = true;
				$result['data'] = "User information has been modified.";
				
			} else {
				throw new exception ('사용자 정보 수정 중 오류가 발생했습니다.');
			}
			
		} catch (Exception $e) {
			$result['success'] = false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
	}
	
	// Sales -> 메뉴 이동 필요???
	public function sales ()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/admin/sales.php';
		require 'application/views/_templates/footer.php';
	}
	
	
}