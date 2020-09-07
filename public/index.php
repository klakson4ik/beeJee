<?php

require_once '../config/Init.php';
require_once LIBS . '/FrameRoute.php';
use vendor\core\libs\FrameRoute;
session_start();
FrameRoute :: start($uri);

?>
