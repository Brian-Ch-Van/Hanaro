<?php

/**
 * 
  * @desc		: admin 관련 controller
  * @creator	: BrianC
  * @date		: 2019. 9. 9.
  * @Version	: 
  * @history	: 최초 생성
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
	  * @desc			: 사용자 목록 조회 - 페이징 적용
	  * @creator		: BrianC
	  * @date			: 2019. 9. 23. 최초 생성
	 */
	public function userList ()
	{
		$schData = $_POST;
		
		$user_model = $this->loadModel("UserModel");
		$userList = $user_model->selUserList($schData, 0, '');
		
		$totalCnt = count($userList);
		
		$page = 1;
		if(isset($_GET['page']) && !empty($_GET['page'])) {
			$page = $_GET['page'];
		}
		
		$list = 15;
		if(isset($schData) && !empty($schData)) {
			if(!empty($schData)) {
				$list = $schData['inputListCnt'];
			}
		}
		$block = 5;	
		
		$pageNum = ceil($totalCnt/$list);	
		$blockNum = ceil($pageNum/$block);	
		$nowBlock = ceil($page/$block);		
		
		$startPage = ($nowBlock * $block) - ($block-1);	
		if($startPage <= 1) {
			$startPage = 1;
		}
		
		$endPage = $nowBlock * $block;		
		if($pageNum <= $endPage) {
			$endPage = $pageNum;
		}
		
		$startRow = ($page-1) * $list;		// 페이징에서 조회 할 시작 row
		
		// paging list
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
			$formProfileData = $_POST;
			
			if (!empty($formProfileData)) {
				
				$resignDate = $formProfileData['inputResignYmd'];
				if(!empty($resignDate)) {
					$formProfileData['inputActYn'] = 'N';
				}
				
				$profile_model = $this->loadModel('ProfileModel');
				
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
	
	/**
	 * 
	  * @Method Name	: openAddRole
	  * @desc			: Role 등록 화면 open 
	  * @creator		: BrianC
	  * @date			: 2019. 11. 1.
	 */
	public function openAddRole ()
	{
		$comm_model = $this->loadModel('CommonModel');
		
		$rgnList = $comm_model->selCdmnList('REGION_CD');
		$brchList = $comm_model->selCdmnList('BRCH_CD');
		$pstnList = $comm_model->selCdmnList('POSITION_CD');
		
		require 'application/views/_templates/header.php';
		require 'application/views/admin/addrole.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: addRole
	  * @desc			: Role 등록
	  * @creator		: BrianC
	  * @date			: 2019. 11. 28.
	 */
	public function addRoleInfo ()
	{
		$result = array();
		
		try {
			$formData = $_POST;
			
			if (!empty($formData)) {

				$comm_model = $this->loadModel('CommonModel');
				
				$comm_model->insertRoleInfo($formData);
				
				$result['success'] = true;
				$result['data'] = "Role information has been saved.";
				
			} else {
				throw new exception ('Role 정보 등록 중 오류가 발생했습니다.');
			}
			
		} catch (Exception $e) {
			$result['success'] = false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
	}
	
	public function openRsrcList ()
	{
		$result = array();
		
		try {
			$rsrc_model = $this->loadModel("ResourceModel");
			$rsrcList = $rsrc_model->selRsrcList();
			
			$listHtml = '
						<table class="table table-hover table-sm table-responsive-md" id="tableRoleRsrcList">
							<thead class="thead-light">
								<tr>
									<th scope="col" >Name</th>
									<th scope="col" >Type</th>
									<th scope="col" >Desc.</th>
									<th scope="col" id="selectAll"></th>
								</tr>
							</thead>
							<tbody>';
			
			foreach ($rsrcList as $row) {
				$listHtml .= '<tr id="trRsrcList">
								<td scope="row" class="rsrcData">'. $row['rsrc_disp_name'] . '</td>';
				if("S" == $row['rsrc_type']) {
					$listHtml .= '<td scope="row" class="rsrcData">화면</td>';
				} else if ("M" == $row['rsrc_type']) {
					$listHtml .= '<td scope="row" class="rsrcData">메뉴</td>';
				}
				$listHtml .= '	<td scope="row" class="rsrcData">'. $row['rsrc_desc'] . '</td>
								<td scope="row"><input type="checkbox" name="checkRsrc" value="' . $row['rsrc_id'] . '/' . $row['rsrc_disp_name']. '/' . $row['rsrc_type']. '/' . $row['rsrc_desc'] . '"></td>
							</tr>
							';
			}
			
			$listHtml .= '</tbody>
						</table>
						';
			
			$result['success'] = true;
			$result['data'] = $listHtml;
			
		} catch (Exception $e) {
			$result['success'] = false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
	}
	
}

