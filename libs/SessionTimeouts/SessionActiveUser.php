<?php namespace NptNguyen\Libs\SessionTimeouts;
use Session;
class SessionActiveUser extends SessionGenerate
{
	//change name to uses
	private $session_uses_key = 'active_user';
	private $session_uses_timeout = 600; //300s = 5p*60s
	//default mỗi một session_uses_key sẽ kèm theo 1 session block
	//block sẽ chặn các truy cập trái phép, default là 2h
	//dựa vào block để xác định có cho phép hành động nữa hay ko (nếu hết timeout uses)
	//ex: khi ta active user, nếu quá timeoute active là 5p, do đó block là cái để xét là user đó đang active và đo đó get value block đó để xác định user nào, else thì ko có ..

	function __construct($uses_id = null)
	{
		parent::__construct($this->session_uses_key, $this->session_uses_timeout, $uses_id);
	}
	//
}
/* uses
	//uses_id co the null neu ko biet
	$ss = new SessionActiveUser(13);
	//create
	$ss->createSessionUsesBlock();
	$ss->createSessionUses();
	//check block
	if($ss->checkSessionUsesBlock()){
		//co block
		if($ss->checkSessionUses()){
			//co session
		}
	}
	//get block
	$value_block = $ss->getSessionUsesBlock()
	if($value_block){
		//...
	}
	//forget
	$ss->forgetSessionUses();
*/

 ?>