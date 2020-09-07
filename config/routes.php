<?php


use vendor\core\libs\Router;
use app\Controllers\MainController;
use app\Controllers\LoginController;

Router::route('', function(){
	MainController::index(); 
});

Router::route('/main/add', function(){
	MainController::add(); 
});

Router::route('/main/store', function(){
	MainController::store(); 
});

Router::route('/login/index', function(){
	LoginController::index(); 
});

Router::route('/login/auth', function(){
	LoginController::auth(); 
});

Router::route('/main/updateStatus', function(){
	MainController::updateStatus(); 
});


Router::route('/main/editTask', function(){
	MainController::editTask(); 
});

Router::route('/main/sort', function(){
	MainController::sort(); 
});

Router::route('/login/logout', function(){
	LoginController::logout(); 
});
