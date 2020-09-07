<form action="/login/auth" method="post">
	<p>Login<input type="text" name="login"></p>
	<p>Password<input type="password" name="password"></p>
	<?php if(isset($data)) : ?>
		<?php foreach($data as $error):?> 
			<p><?php echo $error;?> </p>
		<?php endforeach;?>
	<?php endif; ?>
	<a href="/" class="close">Отменить</a>
	<input type="submit" value="Войти">
</form>
