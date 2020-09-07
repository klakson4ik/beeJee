<!doctype html>

<html lang="en">
<head>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
	<title>Tasks</title>
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body>

	<header>
	<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true): ?>
		<span class="login-name">admin</span>
		<a class="login-href" href="/login/logout">Выйти</a>
	<?php else:?>
		<span class="login-name">Гость</span>
		<a class="login-href" href="/login/index">Авторизоваться</a>
	<?php endif;?>
	</header>

	<div class="content">
   	<?=$content; ?>
	</div>

	<footer>
	</footer>

</body>
</html>
