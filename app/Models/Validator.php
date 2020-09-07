<?php

namespace app\Models;

class Validator
{
	private static	$rules = [
					'name' => '#^.{3,}$#',
        			 'email' => '#^\w{2,30}@\w{2,20}\.\w{2,10}$#'
				];
	private static $errors;
	
	public static function validate()
	{
		if(isset($_POST['name']))
		{
			if(!preg_match(self::$rules['name'], $_POST['name']))
			{
				self::$errors['name'] = "поле Имя задачи должно содержать не менее 3 символов";
			}
		}

		if(isset($_POST['email']))
		{
			if(!preg_match(self::$rules['email'], $_POST['email']))
			{
				self::$errors['email'] = "email не валиден";
			}
		}

		return self :: $errors;
	} 
}
