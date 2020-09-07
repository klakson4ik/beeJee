<?php

namespace app\Models;
use vendor\core\libs\DB;
class Auth
{
	private static $errors;
	private static $login;
	private static $password;

	public static function verify()
	{
		if(!empty($_POST['login']))  
			self::$login = trim($_POST['login']);
		else
			self::$errors['login'] = "Поле Login не заполнено";

		if(!empty($_POST['password']))
			self::$password = trim($_POST['password']);
		else
			 self::$errors['password'] = "Поле Password не заполнено";

		if(isset(self::$errors))
		{
			return self::$errors;
		}else
			self::DBcheckUser();
		
		return self::$errors;
		
	}

	private static function DBCheckUser()
	{
		$sql = ("SELECT `login`, `password` FROM `user` WHERE `login` = ?");
		$db = DB::connector();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(1, self::$login, \PDO::PARAM_STR);
		$stmt->execute();
		$data = $stmt->fetch();
		if(!empty($data['login']))
		{
			if(password_verify(self::$password, $data['password']))
				$_SESSION['is_admin'] = true;
			else
				self::$errors['password'] = "пароли не совпадают";
		}else
			self::$errors['login'] = "пользователя не существует";
			
	}
}
