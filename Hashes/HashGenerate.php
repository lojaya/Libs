<?php namespace App\Libs\Hashes;
/**
* 
*/
use Session;
class HashGenerate
{
	//mã hóa hash
	// protected $openssl_method = 'aes-128-cbc';
	protected $openssl_method = 'aes128';
	protected $openssl_pass = '1234567812345678';
	protected $openssl_iv = '1234567812345678';
	//
	//tra ve ma hoa, 16 letter
	protected function getOpenSslEncrypt($name)
	{
		//return string --> 16 letter
		return openssl_encrypt($name, $this->openssl_method, $this->openssl_pass, true, $this->openssl_iv);
	}
	//return username, else false
	protected function getOpenSslDecrypt($name_encrypt)
	{
		return openssl_decrypt($name_encrypt, $this->openssl_method, $this->openssl_pass, true, $this->openssl_iv);
	}
	//pack, converts hex string to raw binary
	protected function packConvertHexStringToRawBinary($hex_string){
		return pack('h*', $hex_string);
	}
	//unpack, converts raw binary to hex, return 1 mang with name 1
	//use $arr[1]
	protected function unpackConvertRawBinaryToHexString($raw){
		return unpack('h*', $raw);
	}
	//32 letter
	public function getEnscryptHash($name){
		//encrypt name
		$name_encrypt = $this->getOpenSslEncrypt($name);
		//convert raw to hex
		$name_encrypt_hex = $this->unpackConvertRawBinaryToHexString($name_encrypt);
		return $name_encrypt_hex[1];
	}
	//
	public function getDescryptHash($name_hash){
		//convert hex to raw
		$name_raw = $this->packConvertHexStringToRawBinary($name_hash);
		//decrypt openssl
		$name_decrypt = $this->getOpenSslDecrypt($name_raw);
		return $name_decrypt;
	}
	public function checkHash($name, $name_encrypt){
		//return string else false
		$temp_descrypt = $this->getDescryptHash($name_encrypt);
		if($temp_descrypt){
			if($name == $temp_descrypt){
				return true;
			}
		}
		return false;
	}
	public function setPasswordHash($value)
	{
		// tao hash
		return password_hash($value, PASSWORD_DEFAULT);
	}
	//check
	public function checkPasswordHash($value_bd, $value_hash)
	{
		// check hash
		if(password_verify($value_bd, $value_hash)){
			return true;
		}
		else{
			return false;
		}
	}
}
/*
use
	$hash = new HashGenerate();
	$name = '66666';
	$name_enscrypt = $hash->getEnscryptHash($name);
	var_dump($name_enscrypt);
	//
	$name_descrypt = $hash->getDescryptHash($name_enscrypt);
	var_dump($name_descrypt);
	//check
	var_dump($hash->checkHash($name, '85ee0bbe84239e7f914dbcf55bfcaf9b'));
	//password hash
	//create
	$pass_hash = $hash->setPasswordHash('password');
	//check
	if($hash->checkPasswordHash($pass, $pass_hash)){
		//ok... is check pass
	}

*/
 ?>