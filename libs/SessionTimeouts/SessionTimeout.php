<?php namespace NptNguyen\Libs\SessionTimeouts;
use Session;
class SessionTimeout
{
	//
	private $session_key = null;
	private $session_value = null; //time()
	private $session_timeout = null; 
	//
	//time 300s ~ 5p
	function __construct($key, $timeout = 300)
	{
		$this->session_key = $key;
		//$this->session_value = $value;
		$this->session_timeout = $timeout;
	}
	protected function createSessionTimeout(){
		if(Session::has($this->session_key)){
			//forget
			Session::forget($this->session_key);
		}
		//create
		$this->session_value = time() + $this->session_timeout;
		Session::put($this->session_key, $this->session_value);
		//Session::save();
	}
	protected function checkSessionTimeout(){
		if(Session::has($this->session_key)){
			//check timeout
			//get timeout->value
			if(Session::get($this->session_key) >= time()){
				return true;
			}	 
		}
		return false;
	}
	protected function forgetSessionTimeout(){
		if(Session::has($this->session_key)){
			//forget
			Session::forget($this->session_key);
		}
	}
	protected function getSessionTimeoutKey(){
		return $this->session_key;
	}
	protected function getSessionTimeoutValue(){
		return $this->session_value;
	}
	protected function getSessionTimeoutTimeout(){
		return $this->session_timeout;
	}
}
 ?>