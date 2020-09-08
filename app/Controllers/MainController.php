<?php

namespace app\Controllers;
use app\Models\Tasks;
use app\Models\Template;

class MainController
{
	 public static function index()
	 {
			$perPage = 2;
			$classTasks = new Tasks();
			$data['tasks'] = isset($_SESSION['sort']) ? $classTasks->getSortTasks() : $classTasks->getTasks();
			$count = (int)ceil(count($data['tasks']) / $perPage);
			if(isset($_SESSION['page']))
			{
				$data['page'] = $_SESSION['page'];
				unset($_SESSION['page']);
			}else
				$data['page'] = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$data['tasks']= array_slice($data['tasks'], ($data['page'] - 1) * $perPage, $perPage);
			$data['count'] = $count;
			Template::getHtml("main.php", $data);			
	 }

	 public static function add()
	 {
		if(isset($_SESSION['errors']))
		{
			Template::getHtml("addTask.php", $_SESSION['errors']);
			unset($_SESSION['errors']);
		}else
		{
			 Template::getHtml("addTask.php");
		}
	 }

	 public static function store()
	 {
		$classTasks = new Tasks();
		$errors = $classTasks->addTask();
		if(isset($errors))
		{
			$_SESSION['errors'] = $errors;
			header("Location: /main/add");
		}
		else
		{	
			$_SESSION['is_add'] = true;	  
			header("Location: /");
		}
	 }

	 public static function updateStatus()
	 {
			if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true)
			{
				$classTasks = new Tasks();
 				$classTasks->updateStatus();
				header("Location: /");				
			}else
				header("Location: /login/index");

	 }

	 public static function editTask()
	 {
			if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true)
			{
				$classTasks =  new Tasks();
				$classTasks->updateTask();	
				header("Location: /");
			}else
				header("Location: /login/index");
	 }

	 public static function sort()
	 {
			$_SESSION['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
			$_SESSION['sort'] = $_POST['sort'];
			header("Location: /");
	 }
}
