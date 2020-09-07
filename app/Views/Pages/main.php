<?php if(isset($_SESSION['is_add']) && $_SESSION['is_add'] == true):?>
	<?php  
		echo '<script type="text/javascript">';
		echo ' alert("Добавлена новая задача")';  //not showing an alert box.
		echo '</script>';
		unset($_SESSION['is_add']);
	?>
<?php endif;?> 
<table>
	<tr>
		<form action="/main/sort" method="post">
		<th>Имя задачи
				<p><button name="sort" value="name_ASC"><</button>
					<button name="sort" value="name_DESC">></button></p>
		</th>
		<th>email
					<p><button name="sort" value="email_ASC"><</button>
					<button name="sort" value="email_DESC">></button></P>
		</th>
		<th>Задача
					<p><button name="sort" value="task_ASC"><</button>
					<button name="sort" value="task_DESC">></button></p>
		</th>
		<th>Статус задачи
				<p><button name="sort" value="status_ASC"><</button>
				<button name="sort" value="status_DESC">></button></p>
		</th>
		</form>
	</tr>
	<?php foreach ($data['tasks'] as $task) :?>
	<tr>
		<td><?=$task['name'];?></td>
		<td><?=$task['email'];?></td>
		<td><?=$task['task'];?>
		<p><?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true):?>	
		<form action="/main/editTask" method="post">
				<input type="textarea" name="text">
				<button name="task_id" value="<?=$task['id'];?>">Сохранить</button>
		</form>
		<?php endif;?></p>
		</td>	
		<?php if($task['status'] == 0):?>
			<td>Назначено</td>
		<?php elseif($task['status'] == 1):?>
			<td>Выполнено</td>
		<?php else:?>
			<td>Выполнео отредактировано администратором</td>
		<?php endif;?>
		<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true):?>	
			<td>
				<form action="/main/updateStatus" method="post">
					<button name="status_id" value="<?=$task['id']; ?>">Назначить статус как выполнено</button>
				</form>
			 </td>
		<?php endif;?>		  
	</tr>
   <?php endforeach;?>
</table>

	<a  class="add-href" href="/main/add">Добавить задачу</a>
	<div class="pagination">
	<?php if($data['page'] > 1):?>
		<a href="/?page=<?=$data['page'] - 1 ;?>"><</a>
	<?php endif;?>
	<?php if($data['page'] < $data['count']) :?>
		<a href ="/?page=<?=$data['page'] + 1;?>">></a>
	<?php endif;?>
	</div>
