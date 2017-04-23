<?php namespace NptNguyen\Libs;
/**
* 
*/
class GuestInfo
{
	private $ip = '';
	private $user_agent = '';
	private $get_browser = ['browser_name' => 'Unknown', 'platform' => 'Unknown', 'version' => ''];
	private $location_info = ['country' => '', 'city' => ''];
	private $http_referer = ['host' => ''];
	protected function getIpAddress(){
		//php
		
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = @$_SERVER['REMOTE_ADDR'];
	    // $result  = array('country'=>'', 'city'=>'');
	    $ip = '';
	    if(filter_var($client, FILTER_VALIDATE_IP)){
	        $ip = $client;
	    }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
	        $ip = $forward;
	    }else{
	        $ip = $remote;
	    }
	    
	    //laravel $request->ip();
	    $this->setIp($ip);
	}
	public function getLocationInfoByIp($ip = ''){
		//set ip
		if($ip != ''){
			$this->setIp($ip);
		}else{
			$this->getIpAddress();
		}
	    if(!empty($this->getIp()) && $this->getIp() != '::1'){
	    	$ip_data = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$this->getIp()));    
		    if($ip_data && $ip_data->geoplugin_countryName != null){
		        $this->location_info['country'] = $ip_data->geoplugin_countryCode;
		        $this->location_info['city'] = $ip_data->geoplugin_city;
		    }
	    }
	    //array
	    return $this->location_info;
	}
	//
	public function getBrowser()
	{
		//http://php.net/manual/en/function.get-browser.php
		//set user agent
		$this->setUserAgent($_SERVER['HTTP_USER_AGENT']); 
	    //First get the platform?
	    if (preg_match('/linux/i', $this->getUserAgent())) {
	        $this->get_browser['platform'] = 'Linux';
	    }
	    elseif (preg_match('/macintosh|mac os x/i', $this->getUserAgent())) {
	        $this->get_browser['platform'] = 'Mac';
	    }
	    elseif (preg_match('/windows|win32/i', $this->getUserAgent())) {
	        $this->get_browser['platform'] = 'Windows';
	    }
	    //Next get the name of the useragent yes seperately and for good reason
	    if (strpos($this->getUserAgent(), 'Opera') || strpos($this->getUserAgent(), 'OPR/')) {
	    	$this->get_browser['browser_name'] = 'Opera';
	    }
	    elseif (strpos($this->getUserAgent(), 'Edge')) {
	    	$this->get_browser['browser_name'] = 'Edge';
	    }
	    elseif (strpos($this->getUserAgent(), 'Chrome')) {
	    	$this->get_browser['browser_name'] = 'Chrome';
	    }
	    elseif (strpos($this->getUserAgent(), 'Safari')) {
	    	$this->get_browser['browser_name'] = 'Safari';
	    }
	    elseif (strpos($this->getUserAgent(), 'Firefox')) {
	    	$this->get_browser['browser_name'] = 'Firefox';
	    }
	    elseif (strpos($this->getUserAgent(), 'MSIE') || strpos($this->getUserAgent(), 'Trident/7')) {
	    	$this->get_browser['browser_name'] = 'Internet Explorer';
	    }
	    //
	    // finally get the correct version number
	    $known = array('Version', $this->get_browser['browser_name'], 'other');
	    $pattern = '#(?<browser>' . join('|', $known) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    if (!preg_match_all($pattern, $this->getUserAgent(), $matches)) {
	        // we have no matching number just continue
	    }
	    
	    // see how many we have
	    $i = count($matches['browser']);
	    if ($i != 1) {
	        //we will have two since we are not using 'other' argument yet
	        //see if version is before or after the name
	        if (strripos($this->getUserAgent(),"Version") < strripos($this->getUserAgent(),$this->get_browser['browser_name'])){
	            $this->get_browser['version'] = $matches['version'][0];
	        }
	        else {
	            $this->get_browser['version'] = $matches['version'][1];
	        }
	    }
	    else {
	        $this->get_browser['version'] = $matches['version'][0];
	    }
	    
	    // check if we have a number
	    if ($this->get_browser['version'] == null || $this->get_browser['version'] == '') {
	    	$this->get_browser['version'] = '?';
	    }
	    //'pattern'    => $pattern
	    return $this->get_browser;
	}
	public function setIp($ip_address){
		$this->ip = $ip_address;
	}
	public function getIp(){
		return $this->ip;
	}
	public function setUserAgent($agent){
		$this->user_agent = $agent;
	}
	public function getUserAgent(){
		return $this->user_agent;
	}
	public function setHttpReferer(){
		//http://php.net/manual/en/function.parse-url.php
		$this->http_referer['url'] = @$_SERVER['HTTP_REFERER'];
		if($this->http_referer['url'] != ''){
			//host
			$this->http_referer['host'] = parse_url($this->http_referer['url'], PHP_URL_HOST);
		}
		
	}
	public function getHttpReferer(){
		$this->setHttpReferer();
		return $this->http_referer;
	}
}

 ?>