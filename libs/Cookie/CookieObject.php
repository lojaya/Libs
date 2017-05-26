<?php namespace NptNguyen\Libs\Cookie;

/**
* 
*/
class CookieObject
{
	private $cookie_name = '';
	private $cookie_data = '';
	private $cookie_path = '';
	private $cookie_expires = '';
	private $cookie_domain = '';
	
	function __construct($cookie_name = '', $cookie_data = '', $cookie_path = '/', $cookie_expires = 'Session', $cookie_domain = '')
	{
		$this->cookie_name = $cookie_name;
		$this->cookie_data = $cookie_data;
		$this->cookie_path = $cookie_path;
		$this->cookie_expires = $cookie_expires;
		$this->cookie_domain = $cookie_domain;
	}
	function getCookieName(){
		if(!empty($this->cookie_name)){
			return $this->cookie_name;
		}
		return false;
	}
	function getCookieData(){
		return $this->cookie_data;
	}
	function getCookiePath(){
		return $this->cookie_path;
	}
	function getCookieExpires(){
		return $this->cookie_expires;
	}
	function getCookieDomain(){
		return $this->cookie_domain;
	}
}