<?php

define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('CONTROLLERS', APP . '/controllers');
define('MODELS', APP . '/models');
define('VIEWS', APP . '/Views/');
define('PAGES', APP . '/Views/Pages/');
define('CORE', ROOT . '/vendor/core');
define('LIBS', ROOT . '/vendor/core/libs');
define('WWW', ROOT . '/public');
define('CACHE', ROOT . '/tmp/cache');
define('CONFIG', ROOT . '/config');
define('CSS', WWW . '/css');

$uri = rtrim($_SERVER['REQUEST_URI'], '/');

define('PATH', $app_path);

