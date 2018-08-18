<?php

namespace App\Http\Libraries;
use Faker\Provider\DateTime;
use Carbon\Carbon;

/**
* 
*/
class Validate
{

	public static function validateCourierImport($data=array())
	{

		if($data['id_no']!=''){
			$valid_id_no = Validate::checkExactLength($data['id_no'],13);
		}else{
			$valid_id_no = Validate::isAlphaNumeric($data['passport_id']);
		}
		$valid_contact_no = Validate::checkExactLength($data['cell_contact'],10);

		if(!$valid_id_no || !$valid_contact_no){
			return "Invalid data";
		}else{
			return "Approved or completed successfully";
		}
	}

	public static function validateClaimsImport($data=array())
	{
		$valid_customer_no = Validate::checkLength($data['customer_no'],7,10);

		if(!$valid_customer_no){
			return "Invalid data";
		}else{
			return "Approved or completed successfully";
		}
	}

	public static function isNumeric($value='')
	{
		if(is_numeric($value)){
			return true;
		}else{
			return false;
		}
	}

	public static function isAlphaNumeric($value='')
	{
		if(ctype_alnum($value)){
		    return true;
		}else{
		    return false;
		}
	}

	public static function checkExactLength($value,$length=0)
	{
		return (strlen($value) == $length);
	}

	public static function checkLength($value,$min=0,$max=0)
	{
		return (strlen($value) >= $min && strlen($value) <= $max);
	}
}
