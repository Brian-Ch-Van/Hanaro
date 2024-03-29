<?php
 /**
  * 
   * @desc		: 프로필 관련 함수 Controller
   * @creator	: BrianC
   * @date		: 2019. 9. 12.
   * @Version	: v1.0
   * @history	: 최초 생성
   *
  */
class Profile extends Controller
{
	public function index ()
	{
		$this->mngPsw();
	}
	
	/**
	 * 
	  * @Method Name	: mngPsw
	  * @desc			: 비밀번호 변경 화면 이동
	  * @creator		: BrianC
	  * @date			: 2019. 9. 12.
	 */
	public function mngPsw ()
	{
		require 'application/views/_templates/header.php';
		require 'application/views/profile/passwordmanage.php';
		require 'application/views/_templates/footer.php';
	}
	
	/**
	 * 
	  * @Method Name	: getProfInfo
	  * @desc			: 프로필 정보 관리 화면 오픈
	  * @creator		: BrianC
	  * @date			: 2019. 9. 24.
	 */
	public function getProfInfo ($userId)
	{
		if(array_key_exists('user_id', $_SESSION) && !empty($_SESSION['user_id']) && isset($userId)) {
			if($userId != $_SESSION['user_id']) {
				require 'application/views/error/warning.php';
				
			} else {
				$profile_model = $this->loadModel('ProfileModel');
				$profileInfo = $profile_model->selProfInfo($userId);
				
				require 'application/views/_templates/header.php';
				require 'application/views/profile/profilemanage.php';
				require 'application/views/_templates/footer.php';
			}
			
		} else {
			require 'application/views/error/wrongpage.php';
		}
	}
	
	/**
	 * 
	  * @Method Name	: modifyProfInfo
	  * @desc			: 프로필 정보 수정
	  * @creator		: BrianC
	  * @date			: 2019. 10. 15.
	  * @throws exception
	 */
	public function modifyProfInfo () 
	{
		try {
			$formProfileData = $_POST;	// POST로 넘겨온 form 전체
			
			if (!empty($formProfileData)) {
				if(empty($formProfileData['inputKname'])) {
					throw new exception ('Korean Name is empty.');
				} else if (empty($formProfileData['inputEmail'])) {
					throw new exception ('Email is empty.');
				} else {
					// profile model call
					$profile_model = $this->loadModel('ProfileModel');
					
					$loginUserId = $_SESSION['user_id'];
					$formProfileData['lstUpdUser'] = $loginUserId;
					
					// update
					$profile_model->updateProfInfo($formProfileData);
					
					$result = array();
					$result['success'] = true;
					$result['data'] = "User information has been successfully modified.";
				}
				
			} else {
				throw new exception ('개인 정보 수정 중 오류가 발생했습니다.');
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
	  * @Method Name	: chgPassword
	  * @desc			: 비밀번호 정합성 체크, 변경 
	  * @creator		: BrianC
	  * @date			: 2019. 9. 12.
	  * @throws exception
	 */
	public function chgPassword ()
	{
		try {
			if(isset($_POST['newPwData'])) {
				
				if(empty($_POST['curPwData'])){
					throw new exception('현재 비밀번호를 입력해주세요.');
					
				} else if (empty($_POST['newPwData'])) {
					throw new exception('새로운 비밀번호를 입력해주세요.');
					
				} else if (empty($_POST['conPwData'])) {
					throw new exception('비밀번호를 확인해주세요.');
					
				} else {
					if ($_POST["newPwData"] == $_SESSION['user_pw']) {
						throw new exception('기존 비밀번호와 변경하려는 비밀번호가 동일합니다.');
					}
					
					if ($_POST["newPwData"] != $_POST["conPwData"]) {
						throw new exception('입력하신 비밀번호가 다릅니다. 확인해주세요.');
					}
					
					$encryptObj = new Encryption();
					$encryptedPw = $encryptObj->encryptAes($_POST["newPwData"]);
					
					$profile_model = $this->loadModel('ProfileModel');
					$profile_model->updatePassword($encryptedPw);
					
					$_SESSION['user_pw'] = $_POST["newPwData"];	// 수정 후 세션에 저장
					
					$result['success'] = true;
					$result['data'] = "비밀번호가 변경되었습니다.";
				}
			}
		} catch (Exception $e) {
			$result['success']	= false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
	}
	
	/**
	 * 
	  * @Method Name	: goConfirm
	  * @desc			: pop-up sign out confirm modal
	  * @creator		: BrianC
	  * @date			: 2019. 9. 12.
	 */
	public function goConfirm () {
		require 'application/views/_templates/signoutmodal.php';
	}
	
}