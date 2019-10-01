<?php
/**
 * 
  * @desc		: 로그인 관련 함수 controller
  * @creator	: BrianC
  * @date		: 2019. 9. 12.
  * @Version	: v1.0
  * @history	: 
  *
 */
class Login extends Controller
{
	public function index () 
	{
		$this->signIn();
	}
	
	/**
	 * 
	  * @Method Name	: signIn
	  * @desc			: sign in 화면 open
	  * @creator		: BrianC
	  * @date			: 2019. 9. 9.
	 */
	public function signIn ()
	{
		require 'application/views/login/signin.php';
	}
	
	/**
	 * 
	  * @Method Name	: signOut
	  * @desc			: sign out confirm
	  * @creator		: BrianC
	  * @date			: 2019. 9. 9.
	 */
	public function signOut ()
	{
		require 'application/views/login/signout.php';
	}
	

	/**
	 * 
	  * @Method Name	: signUp
	  * @desc			: 사용자 아이디 채번 후 등록 화면 오픈
	  * 				: 오픈 시 채번 안함 - 2019. 9. 27.
	  * @creator		: BrianC
	  * @date			: 2019. 9. 13.
	 */
	public function openSignUp () 
	{
// 		$login_model = $this->loadModel('LoginModel');
// 		$user = $login_model->getUserId();
		
		require 'application/views/login/signup.php';
	}
	
	/**
	 * 
	  * @Method Name	: getUserInfo
	  * @desc			: 직원 정보 조회 - 공통으로 구성할 지 고려
	  * @creator		: BrianC
	  * @date			: 2019. 9. 13.
	 */
	public function getEmpInfo ()
	{
		try {
			if (isset($_POST['empNoData'])) {
				if (empty($_POST['empNoData'])) {
					throw new exception('직원 번호를 입력해주세요');
				} else if (strpos($_POST['empNoData'], " ") !== false) {
					throw new exception('입력하신 내용에 공백이 포함되어 있습니다.');
				} else {
					$empNo = $_POST['empNoData'];
					
					$login_model = $this->loadModel('LoginModel');
					$empInfo = $login_model->selEmpInfo($empNo);
					
					if ($empInfo == false) {
						throw new exception ('직원 정보를 찾을 수 없습니다.');
						
					} else {
						$result['success'] = true;
						$result['empInfo'] = $empInfo;	// Object - 리턴 받는 곳에서 value 출력해서 사용
						
					}
				}
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
	  * @Method Name	: signUpUserInfo
	  * @desc			: 사용자 정보 등록
	  * @creator		: BrianC
	  * @date			: 2019. 9. 17.
	 */
	public function signUpUserInfo () {
		
		try {
			// JSON.stringfy로 string으로 넘긴 경우
			// $formData = file_get_contents("php://input");	// parsing 전 POST data
			// $data = json_decode($formData, true);			// JSON object 를 Array로 decode 해주고
			
			$formData = $_POST;	// POST로 넘겨온 form 전체
			
			if (!empty($formData)) {
				// 필수항목 값 체크 해주고
				if(empty($formData['inputKname'])) {
					throw new exception ('한글 이름을 입력해주세요.');
				} else if (empty($formData['inputEmail'])) {
					throw new exception ('이메일을 입력해주세요.');
				} else if (empty($formData['inputPw'])) {
					throw new exception ('비밀번호를 입력해주세요.');
				} else if (empty($formData['inputCnfPw'])) {
					throw new exception ('비밀번호를 확인해주세요.');
				} else if ($formData['inputPw'] != $formData['inputCnfPw']) {
					throw new exception ('입력하신 비밀번호가 다릅니다. 확인해주세요.');
				} else {

					// 암호화 class 객체 생성
					$encryptObj = new Encryption();
					$encryptedPw = $encryptObj->encryptAes($formData['inputPw']);
					$formData['inputPw'] = $encryptedPw;
					
					// model call
					$login_model = $this->loadModel('LoginModel');
					
					$user = $login_model->getUserId();		// user_id 채번
					$formData['inputUserId'] = $user['user_id'];
					
					// 저장
					$login_model->insertUserInfo($formData);
					
					$result['success'] = true;
					$result['data'] = "사용자 ID " . $formData['inputUserId'] . " 정보가 등록되었습니다.<br>관리자 승인 후 해당 ID로 사용 가능합니다.";
				}
				
			} else {
				throw new exception ('사용자 정보 등록 중 오류가 발생했습니다.');
			}
		} catch (Exception $e) {
			$result['success'] = false;
			$result['errMsg'] = $e->getMessage();
			
		} finally {
			echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}
		
	}

	
	
	
	
	
	
	
}
