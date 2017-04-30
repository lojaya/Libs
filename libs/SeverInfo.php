<?php 
namespace NptNguyen\Libs;

/**
* custom server
* http://php.net/manual/en/reserved.variables.server.php
*/
class ServerInfo
{
	
	public static function getServerName(){
		return $_SERVER['SERVER_NAME'];
	}
	public static function getHttpReferer(){
		return $_SERVER['HTTP_REFERER'];
	}
}

 ?>