<?php namespace NptNguyen\Libs\CaptchaImages;

class CaptchaSessionLoginUser extends CaptchaSession
{
	private $captcha_uses_name = 'login_user';
	//timeout
	private $captcha_uses_timeout = 200; //200s

	//
	function __construct()
	{
		parent::__construct($this->captcha_uses_name, $this->captcha_uses_timeout);
	}

}
/*uses
	$captcha = new CaptchaSessionLoginUser();
	//create... show
	$captcha->createCaptchaSession();
	//check
	if($captcha->checkCaptchaSession($captcha_input)){
		echo 'ok';
	}
	//forget
	$captcha->forgetCaptchaSession();
*/

?>