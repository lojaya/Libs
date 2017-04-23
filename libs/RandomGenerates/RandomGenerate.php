<?php namespace NptNguyen\Libs\RandomGenerates;

/**
* source: https://www.dougv.com/2010/03/a-strong-password-generator-written-in-php/
* random string, password
* uses:
$password = generatePassword(); // $password is 8 lower-case letters
$password = generatePassword(10); // $password is 10 lower-case letters
$password = generatePassword(12, 1, 2, 3); // $password is 12 characters: 6 lower-case letters, 1 upper-case letter, 2 numbers and 3 symbols
$password = generatePassword(10, 0, 3, 2); // $password is a 10 characters:  5 lower-case letters, 3 numbers and 2 symbols
$password = generatePassword(7, 2, 1); // $password is 7 characters: 4 lower-case letters, 2 upper-case letters and 1 number
$password = generatePassword(0); // $password is Boolean false; warning error that password length is less than 1
$password = generatePassword(21); // $password is Boolean false; warning error that arguments are out of range
$password = generatePassword(10, -1, 3, 1); // $password is Boolean false; warning error that arguments are out of range
$password = generatePassword('foo'); // $password is Boolean false; error returned that arguments are not an integer
$password = generatePassword(8, 9); // $password is Boolean false; warning error that capital letters count exceeds password length
$password = generatePassword(10, 5, 3, 3); // $password is Boolean false; warning error that total special characters count exceeds password length
//
if(false === ($pass2 = generatePassword(10, 2, 1, 3))) {
   echo "Error generating pass2!<br />";
}
else {
   echo "pass2: $pass2<br />";
}
*/
class RandomGenerate
{
   private $chars_uppercase = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
   private $chars_lowercase = 'abcdefghijklmnopqrstuvwxyz';
   private $chars_number = '0123456789';
   private $chars_symbol = '!@#$%^&*()-+?';
	
   //generateCharRandom(12, 1, 2, 3)
   /* $password is 12 characters: 6 lower-case letters, 1 upper-case letter, 2 numbers and 3 symbols
   // lower-case = length - uppercase - number - symbol
   Uppercase: generateCharRandom(8, 8);
   5-Uppercase + 3-Lowercase: generateCharRandom(8, 5)
   */
	protected function generateCharRandom($length = 8, $uppercases = 0, $numbers = 0, $symbols = 0) {
		// get count of all required minimum special chars
		$count = $uppercases + $numbers + $symbols;

		// sanitize inputs; should be self-explanatory
   	if(!is_int($length) || !is_int($uppercases) || !is_int($numbers) || !is_int($symbols)) {
         trigger_error('Argument(s) not an integer', E_USER_WARNING);
         return false;
   	}
		elseif($length < 0 || $length > 20 || $uppercases < 0 || $numbers < 0 || $symbols < 0) {
   		trigger_error('Argument(s) out of range', E_USER_WARNING);
   		return false;
		}
      elseif($uppercases > $length) {
         trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
         return false;
      }
      elseif($numbers > $length) {
         trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
         return false;
      }
      elseif($symbols > $length) {
         trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
         return false;
      }
      elseif($count > $length) {
         trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
         return false;
      }

      // all inputs clean, proceed to build password      
      $out = null;
      // build the base password of all lower-case letters
      for($i = 0; $i < $length; $i++) {
         $out .= substr($this->chars_lowercase, mt_rand(0, strlen($this->chars_lowercase) - 1), 1);
      }
 
      // create arrays if special character(s) required
      if($count) {
         // split base password to array; create special chars array
         $tmp1 = str_split($out);
         $tmp2 = array();
    
         // add required special character(s) to second array
         for($i = 0; $i < $uppercases; $i++) {
            array_push($tmp2, substr($this->chars_uppercase, mt_rand(0, strlen($this->chars_uppercase) - 1), 1));
         }
         for($i = 0; $i < $numbers; $i++) {
            array_push($tmp2, substr($this->chars_number, mt_rand(0, strlen($this->chars_number) - 1), 1));
         }
         for($i = 0; $i < $symbols; $i++) {
            array_push($tmp2, substr($this->chars_symbol, mt_rand(0, strlen($this->chars_symbol) - 1), 1));
         }
    
         // hack off a chunk of the base password array that's as big as the special chars array
         $tmp1 = array_slice($tmp1, 0, $length - $count);
         // merge special character(s) array with base password array
         $tmp1 = array_merge($tmp1, $tmp2);
         // mix the characters up
         shuffle($tmp1);
         // convert to string for output
         $out = implode('', $tmp1);
      }
    
      return $out;
   }
   public function getGeneratePassword($length = 8){
      return $this->generateCharRandom($length, 2, 1, 1);
   }
   public function getGenerateString($length = 8){
      //random 4 lowercase, 2 uppercase, 2 numbers
      return $this->generateCharRandom($length, (int)$length/4, (int)$length/4);
   }
}

?>