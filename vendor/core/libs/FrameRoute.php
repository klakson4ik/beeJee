<?php

namespace vendor\core\libs;

use vendor\core\libs\Router;


class FrameRoute
{
      public static function start($uri)
      {

         spl_autoload_register(function($class) {
            $file =  ROOT . '/' . str_replace('\\', '/', $class) . '.php';
            if(file_exists($file))
               require_once $file;
         });

			require_once CONFIG . '/routes.php';

			Router::execute($uri);

		}
}
