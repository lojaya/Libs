<?php namespace App\Libs;
/**
* 
*/
class StringProcess
{
	protected function clearUtf8($s){
		$t = $s;
		$t = preg_replace('/[áàảãạâấầẩẫậăắằẳẵặ]/u' ,'a', $t);
		$t = preg_replace('/[éèẻẽẹêếềểễệ]/u' ,'e', $t);
		$t = preg_replace('/[íìỉĩị]/u' ,'i', $t);
		$t = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u' ,'o', $t);
		$t = preg_replace('/[úùủũụưứừửữự]/u' ,'u', $t);
		$t = preg_replace('/[đĐ]/u' ,'d', $t);
		return $t;
	}
	protected function getStringNoUtf8($str)
	{
		$name = $str;
		// xoa ki tu 2 cham : ( )
		$name = preg_replace('/[:()"\']/u', '', $name);
		//doi chu hoa thanh thuong
		$name = mb_convert_case($name, MB_CASE_LOWER,'utf-8');
		// xoa utf8
		$name = $this->clearUtf8($name);
		// thay ki tu space thanh -
		$name = preg_replace('/ /', '-', $name);
		return $name;
	}
	static public function getStringSlug($name){
		return $this->getStringNoUtf8($name);
	}
}

 ?>