<?php namespace NptNguyen\Libs\GetLinkVideos;
use NptNguyen\Libs\PathInfo;
/**
* 
*/
class GetLinkVideo
{
	protected $src_2160 = '2160';
	protected $src_1080 = '1080p';
	protected $src_720 = '720p';
	protected $src_480 = '480p';
	protected $src_360 = '360p';
	protected $src_video_json = null;
	protected $status = 'ok';
	protected $vidcode = [
	 	//2D Non-DASH
        '18'	=> '360p',
        '59'	=> '480p',
        '22'	=> '720p',
        '37'	=> '1080p',
        //3D Non-DASH
        '82'	=> '360p',
        '83'	=> '240p',
        '84'	=> '720p',
        '85'	=> '1080p'
    ];
    protected $itag = [
		37,
		22,
		59,
		18
	];
	protected $cookie = ['data' => null, 'expires' => 'Session', 'domain' => '.drive.google.com'];
	//
	public function getCookie(){
		return $this->cookie;
	}
	protected function curl($url) {
	    $ch = @curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    $head[] = "Connection: keep-alive";
	    $head[] = "Keep-Alive: 300";
	    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	    $head[] = "Accept-Language: en-us,en;q=0.5";
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
	    $page = curl_exec($ch);
	    curl_close($ch);
	    return $page;
	}
	protected function curlGetCookie($url) {
	    $ch = @curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    $head[] = "Connection: keep-alive";
	    $head[] = "Keep-Alive: 300";
	    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	    $head[] = "Accept-Language: en-us,en;q=0.5";
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
	    curl_setopt($ch, CURLOPT_HEADER, 1); //set get cookie
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
	    $page = curl_exec($ch);
	    curl_close($ch);
	    //
	    // var_dump($page);
	    // $c = explode('Set-Cookie: ', $page);
	    // unset($c[0]);
	    // if(isset($c[2])){
	    // 	$c1 = explode('HttpOnly', $c[2]);
	    // 	$c[2] = $c1[0];
	    // }
	    
	    // var_dump($c);
	    //
	    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $page, $matches);// get cookie
		$cookies = array();
		// var_dump($matches);exit;
		foreach($matches[1] as $item) {
		    parse_str($item, $cookie);
		    $cookies = array_merge($cookies, $cookie);
		}
		//save cookie
		foreach ($cookies as $key => $value) {
			$this->cookie['data'][$key] = $value;
		}
		// var_dump($this->cookie);exit;
	    return $page;
	}
	protected function getIdZingTv($link){
		//http://tv.zing.vn/video/Juushin-Enbu-Hero-Tales-Tap-1/IWZC6IUA.html
		$path_info = new PathInfo($link);
		return $path_info->getFilename();
	}
	//ok
	function getLinkZingTv($link){
		//http://tv.zing.vn/video/Juushin-Enbu-Hero-Tales-Tap-1/IWZC6IUA.html

		$id = $this->getIdZingTv($link);
		$api = 'http://api.tv.zing.vn/3.0/media/info?api_key=d04210a70026ad9323076716781c223f&media_id='.$id;//Link API
		$data = @file_get_contents($api);
		// var_dump($data);
		if($data){
			//ok
			$json = json_decode($data, true);
			//{"response": 
				//{"id": 200906,
			    // "title": "",
			    // "full_name": "Juushin Enbu: Hero Tales - Tập 1",
			    // "episode": 1,
			    // "release_date": "10/04/2017",
			    // "duration": 1447,
			    // "thumbnail": "2017/0412/f6/effb4c2a04da30ae0350a07384c6b3d2_2.jpg",
			    // "file_url": "stream17.tv.zdn.vn/streaming/b8a96120c036dfe0028dda7a37b94573/5927e04a/2017/0410/07/8bd5217c6d3162fac30023e0c293f717.mp4?format\u003df360\u0026device\u003dother",
			    // "other_url": {
			    //   "Video480": "stream17.tv.zdn.vn/streaming/6fa6437c1828703bc0fbdef2f5b3da45/5927e04a/Video480/2017/0410/07/048d7f99850574b8c7eb6348fc49c39d.mp4?format\u003df480\u0026device\u003dother",
			    //   "Video720": "stream17.tv.zdn.vn/streaming/aa1f054af8a0d280583549bc621f6f44/5927e04a/Video720/2017/0410/07/d79f5b330ca73329b4b97fe96fe01b3a.mp4?format\u003df720\u0026device\u003dother",
			    //   "Video3GP": "stream.m.tv.zdn.vn/tv/44da8694cfaa8ce8257d1a4e950a5e7f/5927e04a/Video3GP/2017/0410/07/4ee37d16b155a6cc8f4d3eb341357de0.3gp?format\u003df3gp\u0026device\u003dother"
			    // },
			//....}
			// var_dump($json);
			//get 360p -> file_url
			if(isset($json['response']['file_url'])){
				$this->src_video_json[$this->src_360] = $json['response']['file_url'];
			}
			//get 480p -> Video480
			if(isset($json['response']['other_url']['Video480'])){
				$this->src_video_json[$this->src_480] = $json['response']['file_url'];
			}
			//get 720p -> Video720
			if(isset($json['response']['other_url']['Video720'])){
				$this->src_video_json[$this->src_720] = $json['response']['file_url'];
			}
			// var_dump($this->src_video_json);

		}else{
			//error -> update status
			$this->status = 'Error get link zing tv';
		}

	}
	//ok
	function getLinkVideoGooglePhotos($link){
	    $get = $this->curl($link);
	    $data = explode('url\u003d', $get);
	    $url = explode('%3Dm', $data[1]);
	    $decode = urldecode($url[0]);
	    $count = count($data);
	    $this->src_video_json = array();
		if($count > 4) {
	        $v1080p = $decode.'=m37';
	        $v720p = $decode.'=m22';
	        $v360p = $decode.'=m18';
	        $this->src_video_json[$this->src_1080] = $v1080p;
	        $this->src_video_json[$this->src_720] = $v720p;
	        $this->src_video_json[$this->src_360] = $v360p;
	    }
	    if($count > 3) {
	        $v720p = $decode.'=m22';
	        $v360p = $decode.'=m18';
	        $this->src_video_json[$this->src_720] = $v720p;
	        $this->src_video_json[$this->src_360] = $v360p;
	    }
	    if($count > 2) {
	        $v360p = $decode.'=m18';
	        $this->src_video_json[$this->src_360] = $v360p;
	    }
	    // var_dump($this->src_video_json);
	    //return $this->src_video_json;
	    // save data var json
	    //return $this->src_video_json;
	}
	public function getDriveIdFromUrlDrive($url){
		$path = parse_url($url);
		$path_data = explode('/', $path['path']);
		// var_dump(count($path_data));
		if(count($path_data) == 5){
			//id la 3
			return $path_data[3];
		}
		return false;
	}
	//ok
	public function getLinkDriveUseProxy($url){
		$id = $this->getDriveIdFromUrlDrive($url);
		if(!$id){
			$this->status = 'Sai Url Drive!';
			exit;
		}
		$data = $this->curlGetCookie('https://drive.google.com/e/get_video_info?docid='.$id);
		// var_dump($data);
		$content = explode('status=ok', $data);
		if(count($content) == 2){
			//
			parse_str($content[1], $tag);
			// var_dump($tag);
			// $source_video = null;
			if(isset($tag['fmt_stream_map'])){
				$data_source = explode(',', $tag['fmt_stream_map']);
				foreach ($data_source as $url) {
					list($itag,$link) = explode('|', $url);
					if(in_array($itag, $this->itag)){
						// $source_video[$this->vidcode[$itag]] = $link;
						// $source_video[$this->vidcode[$itag]] = $link;
						$this->src_video_json[$this->vidcode[$itag]] = $link;
					}
				}
			}
			// var_dump($source_video);
		}else{
			//error -> update status
			$this->status = 'Error get link drive use proxy';
		}
	}
	function getLinkDriveEmbedYoutube($url){
		//https://drive.google.com/file/d/0B5vaC4qOISLQSTk1ZjNnOUJJVVE/view
		$id = $this->getDriveIdFromUrlDrive($url);
		if(!$id){
			$this->status = 'Sai Url Drive!';
			exit;
		}
		return 'https://youtube.googleapis.com/embed/?status=ok&hl=en&allow_embed=0&ps=docs&partnerid=30&autoplay=0&docid='.$id.'&abd=0&public=false&el=leaf&title=Video.mp4';
		return false;
	}
	//ok
    public function getLinkVideoIo($link){
    	$this->setSrcVideoJsonNull();
    	//
    	$api_video_io = env('GET_LINK_REMOTE_API').$link;
		$curl = @file_get_contents($api_video_io);
		$data = json_decode($curl);
		// var_dump($data);die();
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		if(count($data) >= 1){
			//get link thanh cong
			foreach ($data as $src_item) {
				
				$this->src_video_json[$src_item->label.'p'] = $src_item->file;
			}
			// var_dump($this->src_video_json);die();
			return true;
		}
		return false;
    }
    //check status
    function checkSatus(){
    	if($this->status == 'ok'){
    		return true;
    	}
    	return false;
    }
    //get status
    function getSatus(){
    	return $this->status;
    }
    protected function setSrcVideoJsonNull(){
    	$this->src_video_json = null;
    }
    public function getSrc2160()
    {
    	if(isset($this->src_video_json[$this->src_2160])){
    		return $this->src_video_json[$this->src_2160];
    	}else{
    		return false; // ko có j xảy ra
    	}
    }
    // trả về src nếu tồn tại, else return false
    public function getSrc1080()
    {
    	if(isset($this->src_video_json[$this->src_1080])){
    		return $this->src_video_json[$this->src_1080];
    	}else{
    		return false; // ko có j xảy ra
    	}
    }
    // trả về src nếu tồn tại, else return false
    public function getSrc720()
    {
    	if(isset($this->src_video_json[$this->src_720])){
    		return $this->src_video_json[$this->src_720];
    	}else{
    		return false;
    	}
    }
    public function getSrc480()
    {
    	if(isset($this->src_video_json[$this->src_480])){
    		return $this->src_video_json[$this->src_480];
    	}else{
    		return false;
    	}
    }
    public function getSrc360()
    {
    	if(isset($this->src_video_json[$this->src_360])){
    		return $this->src_video_json[$this->src_360];
    	}else{
    		return false; // ko có j xảy ra
    	}
    }
    public function getSrcVideoJson()
    {
    	if(!empty($this->src_video_json)){
    		return $this->src_video_json;
    	}else{
    		return false; // ko có j xảy ra
    	}
    }
}

 ?>