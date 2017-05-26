<?php namespace NptNguyen\Libs\Curls;
/**
* chua lam
*/
class MyCurl
{
	private $url = null;
	private $parse_url = null;
	//
	function __construct($url)
	{
		$this->url = $url;
		$this->parse_url = parse_url($url);
		//parulr -> neu att ko ton tai -> ko co
	}
	//http://username:password@hostname:9090/path?arg=value#anchor
	//get parse_url
	public function getParseUrl(){
		return $this->parse_url;
	}

	//get protocol -> http or https //http
	public function getScheme(){
		// parse_url($url, PHP_URL_SCHEME);
		if(isset($this->parse_url['scheme'])){
			return $this->parse_url['scheme'];
		}
		return false;
	}
	//get host //hostname
	public function getHost(){
		// parse_url($url, PHP_URL_HOST);
		if(isset($this->parse_url['host'])){
			return $this->parse_url['host'];
		}
		return false;
	}
	//get port //9090
	public function getPort(){
		// parse_url($url, PHP_URL_PORT);
		if(isset($this->parse_url['port'])){
			return $this->parse_url['port'];
		}
		return false;
	}
	//get user //username
	public function getUser(){
		// parse_url($url, PHP_URL_USER);
		if(isset($this->parse_url['user'])){
			return $this->parse_url['user'];
		}
		return false;
	}
	//get pass //password
	public function getPass(){
		// parse_url($url, PHP_URL_PASS);
		if(isset($this->parse_url['pass'])){
			return $this->parse_url['pass'];
		}
		return false;
	}
	//get path //path
	public function getPath(){
		// parse_url($url, PHP_URL_PATH);
		if(isset($this->parse_url['path'])){
			return $this->parse_url['path'];
		}
		return false;
	}
	//get query //arg=value
	public function getQuery(){
		// parse_url($url, PHP_URL_QUERY);
		if(isset($this->parse_url['query'])){
			return $this->parse_url['query'];
		}
		return false;
	}
	//get fragment //anchor
	public function getFragment(){
		// parse_url($url, PHP_URL_FRAGMENT);
		if(isset($this->parse_url['fragment'])){
			return $this->parse_url['fragment'];
		}
		return false;
	}
	
}


 ?>