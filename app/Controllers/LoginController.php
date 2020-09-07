<?php

namespace app\Controllers;
use app\Models\Template;
use app\Models\Auth;

class LoginController
{
	public static function index()
	{	
		if(isset($_SESSION['auth_errors']))
		{
			Template::getHtml("login.php", $_SESSION['auth_errors']);
			unset($_SESSION['auth_errors']);
		}else
		{
			Template::getHtml("login.php");
		}
	}

	public static function auth()
	{
		$errors = Auth::verify();
		if(isset($errors))
		{
			$_SESSION['auth_errors'] = $errors;
			header("Location: /login/index");
		}else
			header("Location: /");
	}
	public static function logout()
	{
		unset($_SESSION['is_admin']);
		header("Location: /");
	}
}
