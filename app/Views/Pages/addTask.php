<h3>Добавление задачи</h3>
<form action="/main/store" method="post">
	<p>Имя задачи<input type="text" name="name"></p>
	<p>Email<input type="email" name="email"></p>
	<p>Задача<input type="text" name="task"></p>
	<?php if(isset($data)) : ?>
		<?php foreach($data as $error):?> 
			<p><?php echo $error;?> </p>
		<?php endforeach;?>
	<?php endif; ?>
	<a href="/" class="close">Отменить</a>
	<input type="submit" value="Cохранить">
</form>
