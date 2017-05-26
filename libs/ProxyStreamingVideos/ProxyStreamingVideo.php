<?php namespace NptNguyen\Libs\ProxyStreamingVideos;

/**
* 
*/
use NptNguyen\Libs\Cookie\CookieObject;

class ProxyStreamingVideo
{
	private $url_video = '';
	private $cookie = '';

	function __construct($url_video, $cookie = '')
	{
		$this->cookie = new CookieObject();
		$this->url_video = $url_video;
		if(!empty($cookie)){
			$this->cookie = $cookie;
		}
		// $this->cookie = $cookie;
		// var_dump($this->cookie);
	}
	//ok;
	function getStreamVideo(){
		if($this->cookie->getCookieName()){
			// echo 'ok';exit;
			//is cookie
			$this->getStream(true);

		}
		// exit;
		$this->getStream();
	}
	protected function getStream($cookie = false){
		
		//http://stackoverflow.com/questions/8401412/php-streaming-video-handler
		// $real_file_location_path_or_url = 'http://vjs.zencdn.net/v/oceans.mp4';
		$real_file_location_path_or_url = $this->url_video;
		ini_set('memory_limit','30M'); //3MB
		set_time_limit(3600);
		ob_start();
		// do any user checks here - authentication / ip restriction / max downloads / whatever**

		// if check fails, return back error message**

		// if check succeeds, proceed with code below**

		if( isset($_SERVER['HTTP_RANGE']) ){
			$opts['http']['header'][0] = 'Range: '.$_SERVER['HTTP_RANGE'];
		}
		$opts['http']['method'] = 'HEAD';
		//set cookie
		if($cookie){
			//is cookie
			if(count($this->cookie) == 1){
				$temp = 'Cookie: '.$this->cookie->getCookieName().'='.$this->cookie->getCookieData().'; path='.$this->cookie->getCookiePath().'; expires='.$this->cookie->getCookieExpires().'; domain='.$this->cookie->getCookieDomain();
				$opts['http']['header'][1] =  $temp;
			}else{
				$i = 1;
				foreach ($this->cookie as $key) {					// $opts['http']['header'][1] = 'Cookie: DRIVE_STREAM='.$cookie['data']['DRIVE_STREAM'].'; path=/; expires=Session; domain=.drive.google.com';
					$temp = 'Cookie: '.$key->getCookieName().'='.$key->getCookieData().'; path='.$key->getCookiePath().'; expires='.$key->getCookieExpires().'; domain='.$key->getCookieDomain();
					$opts['http']['header'][$i] = $temp;
					$i++;
				}
			}
			
			
		}
		$conh = stream_context_create($opts);

		$opts['http']['method'] = 'GET';

		$cong = stream_context_create($opts);

		$out[] = file_get_contents($real_file_location_path_or_url, false, $conh);

		$out[] = $http_response_header;

		ob_end_clean();

		array_map('header', $http_response_header);

		readfile($real_file_location_path_or_url, false, $cong);
		exit;
	}
}


 ?>