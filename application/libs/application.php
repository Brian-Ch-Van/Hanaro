<?php 
	
class Application 
{
	
	private $controller = null;
	private $action = null;
	
	public function __construct() 
	{
		
		$cancontroll = false;
		$url = "";
		
		if (isset($_GET['url'])) {                          // url catch 됐으면
			$url = rtrim($_GET['url'], '/');                // url 오른쪽 '/' 자르고
			$url = filter_var($url, FILTER_SANITIZE_URL);   // url아닌 문자들 제거
		}
		
		$params = explode('/', $url);	// '/' 기준으로 문자 잘라서
		$counts = count($params);		// param의 크기
		
		$this->controller = "login";		// Root Url 다음의 기본 값을 login으로 설정. localhost/Hanaro = localhost/Hanaro/login
		
		if (isset($params[0])) {
			if(!empty($params[0])) $this->controller = $params[0];	// Root url 다음 주소값을 controller에 set
		}

		if (file_exists('./application/controller/' . $this->controller . '.php')) {
			require './application/controller/' . $this->controller . '.php';    // controller 파일 호출
			
			$this->controller = new $this->controller();	// 위에서 실행한 파일명의 class 객체 생성. controller는 이제 class 객체
			$this->action = "index";						// 기본 실행 method 명에 index set하기 위해
			
			if (isset($params[1])) {		// null 체크
				if (!empty($params[1])) $this->action = $params[1];
			}
			
			if (method_exists($this->controller, $this->action)) {
				$cancontroll = true;
				
				switch ($counts) {
					case 0:
					case 1:
					case 2:
						$this->controller->{$this->action}();
						break;
					case 3:
						$this->controller->{$this->action}($params[2]);
						break;
					case 4:
						$this->controller->{$this->action}($params[2], $params[3]);
						break;
					case 5:
						$this->controller->{$this->action}($params[2], $params[3], $params[4]);
						break;
				}
			}
		}
		
		// controller 객체와 action method가 없을 경우, 잘못된 url
		if ($cancontroll == false) {
			require './application/views/error/404.php';
		}
		
	}
}
