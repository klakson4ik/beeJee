<?php

namespace app\Models;
use vendor\core\libs\DB;
use app\Models\Validator;

class Tasks
{
	private  $db;
	private 	$rules = [
					'name' => '^\w{3,}$',
        			 'email' => '^\w{2,30}@\w{2,20}\.\w{2,10}$'
				];

	public function __construct()
	{
		$this->db = DB::connector();
	}

	public function getTasks()
	{
		$sql = ("SELECT `id`, `name`, `email`, `task`, `status` FROM `bee_jee_tasks`");
		$query = $this->db->query($sql);
		return $query->fetchAll();
	}

	public function addTask()
	{
		$errors = Validator::validate();
		if(isset($errors))
			return $errors;
		else
		{
			$sql = ("INSERT INTO `bee_jee_tasks` (`name`, `email`, `task`) VALUES (?,?,?)");			
			$stmt = $this->db->prepare($sql);
         $stmt->bindValue(1, trim($_POST['name']), \PDO::PARAM_STR);
         $stmt->bindValue(2, trim($_POST['email']), \PDO::PARAM_STR);
         $stmt->bindValue(3, trim($_POST['task']), \PDO::PARAM_STR);
         $stmt->execute();
		}	  
	}

	public function updateStatus()
	{
		if(isset($_POST['status_id']))
		{
			$sql = ("UPDATE bee_jee_tasks SET `status`= 1 WHERE id = ?");
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(1, trim($_POST['status_id']), \PDO::PARAM_INT);
			$stmt->execute();
		}
		return true;
	}
	public function getSortTasks()
	{
		$sortData = explode("_", $_SESSION['sort']);
		if($sortData[1] == 'ASC')
			$sql = ("SELECT `id`, `name`, `email`, `task`, `status` FROM `bee_jee_tasks` ORDER BY {$sortData[0]} ASC");
		else
			$sql = ("SELECT `id`, `name`, `email`, `task`, `status` FROM `bee_jee_tasks` ORDER BY {$sortData[0]} DESC");
		$query = $this->db->query($sql);
		return $query->fetchAll();
	}			  
	
	public function updateTask()
	{
		if(isset($_POST['task_id']))
		{
			$sql = ("UPDATE bee_jee_tasks SET `status`= 2, `task` = ? WHERE id = ?");
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(1, trim($_POST['text']), \PDO::PARAM_STR);
			$stmt->bindValue(2, trim($_POST['task_id']), \PDO::PARAM_INT);
			$stmt->execute();
		}
		return true;
	}	  
}
