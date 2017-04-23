<?php namespace NptNguyen\Libs;

/**
*  generate from function pathinfo
*/
class PathInfo
{
	private $path = null;
	private $pathinfo = null;
	//
	function __construct($path)
	{
		$this->path = $path;
		$this->pathinfo = pathinfo($path);
	}
	//  /www/htdocs/inc/lib.inc.php
	//array(4) { ["dirname"]=> string(15) "/www/htdocs/inc" ["basename"]=> string(11) "lib.inc.php" ["extension"]=> string(3) "php" ["filename"]=> string(7) "lib.inc" }
	//get pathinfo
	public function getPathInfo(){
		return $this->pathinfo;
	}
	//get dirname // /www/htdocs/inc
	//ex: "abc.png" -> dirname "."
	public function getDirname(){
		return $this->pathinfo['dirname'];
	}
	//get basename //lib.inc.php
	public function getBasename(){
		return $this->pathinfo['basename'];
	}
	//get extension //php
	//if exist extension -> false
	public function getExtension(){
		if(isset($this->pathinfo['extension'])){
			return $this->pathinfo['extension'];
		}
	}
	//get filename //lib.inc
	public function getFilename(){
		return $this->pathinfo['filename'];
	}
}


 ?>