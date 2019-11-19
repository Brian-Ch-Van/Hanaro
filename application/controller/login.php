<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
		$this->openSignIn();
	}
	
	/**
	 * 
	  * @Method Name	: signIn
	  * @desc			: sign in 화면 open
	  * @creator		: BrianC
	  * @date			: 2019. 9. 9.
	 */
	public function openSignIn ()
	{
		require 'application/views/login/signin.php';
	}
	
	/**
	 * 
	  * @Method Name	: signIn
	  * @desc			: 사용자 validaion 확인 후 sign in
	  * @creator		: BrianC
	  * @date			: 2019. 10. 28.
	 */
	public function signIn () 
	{
		try {
			$loginValid = false;
			
			if (($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['login'])) {
				$email = $_POST['inputEmail'];
				$userpassword = $_POST['inputPassword'];
				
				$login_model = $this->loadModel('LoginModel');
				$userInfo = $login_model->selUserInfo($email);
				
				$infoMsg = "";
				
				if(!empty($userInfo) && count($userInfo) != 0) {
					$actYn = $userInfo['act_yn'];
					if($actYn == 'N') {
						$infoMsg = "사용자 아이디의 계정이 승인되지 않았습니다.<br> 관리자에게 문의해주세요.";
						
					} else {
						$password = $userInfo['user_pw'];
						
						$encryptObj = new Encryption();
						$plainedPw = $encryptObj->decryptAes($password);
						
						if($userpassword == $plainedPw) {
							$loginValid = true;
						} else {
							$infoMsg = '비밀번호를 확인해 주세요.';
						}
					}
					
				} else {
					$infoMsg = '등록된 사용자가 아닙니다.';
				}
				
				// 로그인 성공 시
				if ($loginValid) {
					session_regenerate_id();		// Update the current session id with a newly generated one
					// session 값 set
					$_SESSION['user_name'] = $userInfo['kname'];
					$_SESSION['user_id'] = $userInfo['user_id'];
					$_SESSION['user_pw'] = $userpassword;
					
					// auth test ==========
					/*
					$const = new ConstClass();
					if($row['user_id'] == '190001') {			// 수지
						$_SESSION['role_id'] = 'admin';
					} else if ($row['user_id'] == '190129') {	// 윤아
						$_SESSION['role_id'] = 'van_cq_staff';
					}
					// 화면 권한 부여
					$_SESSION['rsrc_list'] = $const->getRsrcListByRoleId($_SESSION['role_id']);
					// auth test ==========
					*/
					
					// Role
					$comm_model = $this->loadModel('CommonModel');
					$roleRsrcList = $comm_model->selRoleRsrcList($userInfo['user_id']);
					
					$roleList = array();
					$menuList = array();
					$screenList = array();
					
					foreach ($roleRsrcList as $row ) {
						array_push($roleList, $row['role_id']);
						$roleUniqList = array_unique($roleList);
						
						if ($row['rsrc_type'] == 'M') {
							array_push($menuList, ['menu_id' => $row['rsrc_id'], 'menu_name' => $row['rsrc_name']]);
							
						} else if ($row['rsrc_type'] == 'S') {
							array_push($screenList, ['screen_id' => $row['rsrc_id'], 'screen_name' => $row['rsrc_name']]);
						}
					}

					$_SESSION['role_list'] = $roleUniqList;
					$_SESSION['menu_list'] = $menuList;
					$_SESSION['screen_list'] = $screenList;
					session_write_close();			// write session data and end session
					
					header('location: '. URL. '/home');
					
				} else {
					require_once 'application/views/login/signin.php';
					echo "<script>checkInfo('$infoMsg');</script>";
				}
			}
			
		} catch (Exception $e) {
			throw new exception ('Sign in 중 사용자 validation 오류가 발생했습니다. Error Message : ' + $e->getMessage());
		}
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
	public function signUpUserInfo () 
	{
		require 'application/libs/phpMailer/Exception.php';
		
		try {
			// JSON.stringfy로 string으로 넘긴 경우
			// $formData = file_get_contents("php://input");	// parsing 전 POST data
			// $data = json_decode($formData, true);			// JSON object 를 Array로 decode 해주고
			
			$formData = $_POST;
			
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
					
					// 이메일 중복 체크
					$emailCnt = $login_model->selUserByEmail($formData['inputEmail']);
					if($emailCnt != 0) {
						throw new exception ('The email is already used.');
					}
					
					$user = $login_model->getUserId();		// user_id 채번
					$formData['inputUserId'] = $user['user_id'];
					
					// 저장
					$login_model->insertUserInfo($formData);
					
					$result['success'] = true;
					$result['data'] = "Your user information has been registered. <br>A confirmation email will be sent to the email address you entered, you can sign in with the email after administrator approves.";
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
	
	/**
	 * 
	  * @Method Name	: sendCnfEmail
	  * @desc			: 등록 확인 메일 전송
	  * @creator		: BrianC
	  * @date			: 2019. 10. 7.
	 */
	public function sendCnfEmail () 
	{
		require 'application/libs/phpMailer/PHPMailer.php';
		require 'application/libs/phpMailer/SMTP.php';
		require 'application/libs/phpMailer/Exception.php';
		
		// 메일 객체 생성
		$mail = new PHPMailer();
		
		try {
			$mail->SMTPDebug = 2;								// debug
			$mail->isSMTP();									// smtp 사용
			$mail->Host = "smtp.gmail.com";						// email 전송 서버 - gmail smtp 사용
			$mail->SMTPAuth = true;								// smtp 인증
			$mail->Username = "noreply.hanasolution@gmail.com";	// 메일 계정
			$mail->Password = "gksktm2255";						// 메일 비밀번호
			$mail->SMTPSecure = "ssl";							// ssl 사용
			$mail->Port = 465;									// 메일 전송 시 사용할 포트
			$mail->CharSet = "utf-8";
			
			// from: address, name
			$mail->setFrom("noreply.hanasolution@gmail.com", "Hana Solutions");
			
			// data 받아 와서
			$formData = $_POST;	// POST로 넘겨온 form 전체
			//$emailTo = $_POST['emailData'];
			
			// to: address, name(option), 다건 가능
			$mail->addAddress($formData['inputEmail']);
			//$mail->addAddress("hanas.brian19@gmail.com");
			
			// cc
			//$mail->addCC($address);
			
			// attach: path
			//$mail->addAttachment("./picture.png");
			
			// body
			$mail->isHTML(true);					// html 사용
			$mail->Subject = "SIGN UP NOTICE";		// 제목
			
			// 본문 내용
			$mail->Body	= '	<!DOCTYPE html >
							<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
							<title>Sign Up Confirmation</title>
							<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
							</head>
							<body style="margin: 0; padding: 0;">
							    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
							        <tr>
							            <td style="padding: 10px 0 30px 0;">
							                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
							                    <tr>
							                        <td align="center" style="background-color:#00bcff; padding: 30px 0 20px 0; color: #1e5e77; font-size: 24px; font-weight: bold; font-family: Arial, sans-serif;">
							                            Welcome to <span style="color: #ee4b50;">HANARO</span>
														<br/><br/>
														<span style="font-size: 36px">- Hana Solutions -</span>
													</td>
							                    </tr>
							                    <tr>
							                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
							                                <tr>
							                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
							                                        <b>Thank you for signing up!</b>
							                                    </td>
							                                </tr>
							                                <tr>
							                                    <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
																	Your registration request has been successfully sent.<br/>
																	Followings are your account information.<br/><br/>
																	<table style="background-color: #e8e6e6; width: 75%; border: solid;">
																		<tr>
																			<td style="width:20%">E-mail</td><td style="width:5%"> : </td><td>'. $formData['inputEmail'] . '</td>
																		</tr>
																		<tr>
																			<td>Name<td> : </td></td><td>' . $formData['inputKname'] . '</td>
																		</tr>
																		<tr>
																			<td>Name_en<td> : </td></td><td>' . $formData['inputFname'] . '&nbsp;'. $formData['inputLname'] . '</td>
																		</tr>
																		<tr>
																			<td>Company<td> : </td></td><td>'. $formData['inputCompany'] . '</td>
																		</tr>
																	</table>

																	<br/><b>You can sign in HANARO with the e-mail after administrator approves.</b><br/>
																	<br/>Thank you
							                                    </td>
							                                </tr>
							                            </table>
							                        </td>
							                    </tr>
							                    <tr>
							                        <td style="background-color:#607d8b; padding: 10px 30px 10px 30px;">
							                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
							                                <tr>
							                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
							                                        <p>Copyright 2019. Hana Solutions. All rights reserved.</p>
							                                        <p>Tel	: 778-285-2255 </p>
																	Email	: support@hanasolution.com
							                                    </td>
							                                </tr>
							                            </table>
							                        </td>
							                    </tr>
							                </table>
							            </td>
							        </tr>
							    </table>
							</body>
							</html>
							';
			
			// gmail은 CA 인증 필요 - 인증체크 해지
			$mail->SMTPOptions = array("ssl"=>array("verify_peer"=>false, "verify_peer_name"=>false, "allow_self_signed"=>true));
			
			// send email
			$mail->send();
			echo "Email send success! ";
		} catch (Exception $e) {
			echo "Email has not been sent. Error : " . $mail->ErrorInfo;
		}
	}

}
