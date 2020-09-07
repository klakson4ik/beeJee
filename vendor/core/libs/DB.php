<?php

namespace vendor\core\libs;

class DB
{

    public static function connector()
    {
        require_once CONFIG . '/Config_DB.php';
        return  new \PDO(DB_DSN, DB_LOGIN, DB_PASSWORD, DB_OPT);
    }
}


