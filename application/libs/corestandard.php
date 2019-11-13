<?php 

/**
 * 
  * @desc		: logic 분기, controller 기본 function 설정
  * @creator	: BrianC
  * @date		: 2019. 9. 1.
  * @Version	: v1.0
  * @history	: 최초 생성
  *
 */
class CoreStandard
{
	
	private $controller = null;
	private $action = null;
	
	public function __construct() 
	{
		
		$ctrlVerify = false;
		$url = "";
		
		if (isset($_GET['url'])) {                   
			$url = rtrim($_GET['url'], '/');                
			$url = filter_var($url, FILTER_SANITIZE_URL);
		}
		
		$params = explode('/', $url);	
		$counts = count($params);
		
		$this->controller = "login";		// Root Url 다음의 기본 값을 login으로 설정. localhost/Hanaro = localhost/Hanaro/login
		
		if (isset($params[0])) {
			if(!empty($params[0])) $this->controller = $params[0];
		}

		if (file_exists('./application/controller/' . $this->controller . '.php')) {
			require './application/controller/' . $this->controller . '.php';    // controller 파일 호출
			
			$this->controller = new $this->controller();	// 위에서 실행한 파일명의 class 객체 생성. controller는 이제 class 객체
			$this->action = "index";						// 기본 실행 method 명에 index set
			
			if (isset($params[1])) {
				if (!empty($params[1])) $this->action = $params[1];
			}
			
			// controller 객체와  action method => 해당 controll의 method 호출 
			if (method_exists($this->controller, $this->action)) {
				$ctrlVerify = true;
				
				$paramArr = array();
				for ($i = 3; $i <= $counts; $i++) {
					array_push($paramArr, $params[$i-1]);
				}
				$paramStr = implode(',', $paramArr);
				
				$this->controller->{$this->action}($paramStr);
			}
		}
		
		// controller 객체와 action method가 없을 경우 => 잘못된 url
		if ($ctrlVerify == false) {
			require './application/views/error/wrongpage.php';
		}
		
	}
}
