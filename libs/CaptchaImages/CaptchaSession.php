<?php namespace NptNguyen\Libs\CaptchaImages;

use Session;
use App\Libs\SessionTimeouts\SessionTimeout;
abstract class CaptchaSession extends SessionTimeout
{
	
	//
	private $captcha_name = null;
	//timeout
	private $captcha_timeout = null;
	//name session timeout
	private $session_timeout_name = null;
	//
	function __construct($name, $timeout = 300)
	{
		$this->captcha_name = 'captcha_session_'.$name;
		$this->captcha_timeout = $timeout;
		$this->session_timeout_name = 'captcha_session_timeout_'.$name;
		//session timeout
		parent::__construct($this->session_timeout_name, $this->captcha_timeout);
	}
	//

	public function createCaptchaSession(){
		//
		$image = new CaptchaImage();
		$captcha_value = $image->getShowCaptchaImage();
		//
		//session store
		if(Session::has($this->captcha_name)){
			//forget
			Session::forget($this->captcha_name);
		}
		Session::put($this->captcha_name, $captcha_value);
		//
		//create timeout
		$this->createSessionTimeout();
	}
	//check
	public function checkCaptchaSession($captcha_input){
		//check timeout
		if($this->checkSessionTimeout()){
			// session captcha
			if(Session::has($this->captcha_name)){
				//so sanh 2 gia tri
				if(Session::get($this->captcha_name) == $captcha_input){					
					return true;
				}
			}
		}
		return false;
	}
	public function forgetCaptchaSession(){
		if(Session::has($this->captcha_name)){
			Session::forget($this->captcha_name);
		}
		$this->forgetSessionTimeout();
		
	}
}

?>