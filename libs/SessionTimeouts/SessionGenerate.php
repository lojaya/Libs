<?php namespace NptNguyen\Libs\SessionTimeouts;
use Session;
abstract class SessionGenerate extends SessionTimeout
{
	//
	private $session_uses_key = 'session_';
	private $session_uses_timeout = 300; //300s = 5p*60s
	//block cac truy cap trai phep neu ko active, default 2h
	//dựa vào block để xác định có cho phép active nữa hay ko (nếu hết timeout active)
	private $session_uses_block = 'session_block_';
	//id
	//co the null, neu ko can.. chi co 1
	private $session_uses_id = null;
	//
	function __construct($uses_key, $uses_timeout = 300, $uses_id = null)
	{
		$this->session_uses_key = $this->session_uses_key.$uses_key;
		$this->session_uses_timeout = $uses_timeout;
		$this->session_uses_id = $uses_id;
		$this->session_uses_block = $this->session_uses_block.$uses_key.'_'.$this->session_uses_id;
		// $this->setSessionTimeout($this->session_uses_key, $this->session_uses_timeout);
		parent::__construct($this->session_uses_key, $this->session_uses_timeout);
	}
	public function createSessionUses(){
		$this->createSessionTimeout();
	}
	public function checkSessionUses(){
		return $this->checkSessionTimeout();
	}
	public function createSessionUsesBlock(){
		if(Session::has($this->session_uses_block)){
			Session::forget($this->session_uses_block);
		}
		Session::put($this->session_uses_block, $this->session_uses_id);
		//Session::save();
	}
	public function checkSessionUsesBlock(){
		if(Session::has($this->session_uses_block)){
			return true;
		}
		return false;
	}
	public function getSessionUsesBlock(){
		if(Session::has($this->session_uses_block)){
			return Session::get($this->session_uses_block);
		}
		return false;
	}
	protected function forgetSessionUsesBlock(){
		if(Session::has($this->session_uses_block)){
			Session::forget($this->session_uses_block);
		}
	}
	public function forgetSessionUses(){
		//forget timeout
		$this->forgetSessionTimeout();
		$this->forgetSessionUsesBlock();
	}
}

 ?>